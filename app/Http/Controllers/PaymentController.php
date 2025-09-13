<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Show payment page for a product
    public function showProductPayment($id)
    {
        $product = Product::findOrFail($id);
        return view('payment.show', compact('product'));
    }

    // Create payment invoice via NOWPayments API and save payment
    public function createPayment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'pay_currency' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $payCurrency = $request->pay_currency;
        $apiKey = env('NOWPAYMENTS_API_KEY');

        $orderId = uniqid('order_');

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->post('https://api.nowpayments.io/v1/invoice', [
            'price_amount' => $product->price,
            'price_currency' => 'usd',
            'pay_currency' => $payCurrency,
            'order_id' => $orderId,
            'order_description' => "Payment for {$product->name}",
            'ipn_callback_url' => route('payment.callback'),
        ]);

        if ($response->failed()) {
            return back()->withErrors('Failed to create payment. Please try again.');
        }

        $data = $response->json();

        // Save payment details in DB inside a transaction for safety
        DB::transaction(function () use ($product, $orderId, $data, $payCurrency) {
            Payment::create([
                'product_id' => $product->id,
                'order_id' => $orderId,
                'payment_id' => $data['id'] ?? null,
                'pay_currency' => $payCurrency,
                'price_amount' => $product->price,
                'price_currency' => 'USD',
                'payment_status' => $data['payment_status'] ?? 'pending',
                'invoice_url' => $data['invoice_url'] ?? null,
            ]);
        });

        // Redirect user to invoice payment page
        return redirect($data['invoice_url']);
    }

    // NOWPayments webhook callback (IPN)
    public function paymentCallback(Request $request)
    {
        Log::info('NOWPayments webhook received:', $request->all());

        return DB::transaction(function () use ($request) {
            $payload = $request->all();

            $orderId = $payload['order_id'] ?? null;
            $paymentStatus = $payload['payment_status'] ?? null;
            $paymentId = $payload['id'] ?? null;

            if (!$orderId || !$paymentStatus) {
                Log::warning('Webhook missing order_id or payment_status', $payload);
                return response()->json(['message' => 'Invalid payload'], 400);
            }

            // Lock row for update to prevent race conditions
            $payment = Payment::where('order_id', $orderId)->lockForUpdate()->first();

            if (!$payment) {
                Log::warning("Payment not found for order_id: {$orderId}");
                return response()->json(['message' => 'Payment not found'], 404);
            }

            if ($payment->payment_status !== $paymentStatus) {
                $payment->payment_status = $paymentStatus;
                $payment->payment_id = $paymentId ?? $payment->payment_id;
                $payment->save();

                Log::info("Payment status updated: order_id={$orderId}, status={$paymentStatus}");
            } else {
                Log::info("Payment status unchanged for order_id={$orderId}");
            }

            return response()->json(['message' => 'IPN received']);
        });
    }
}
