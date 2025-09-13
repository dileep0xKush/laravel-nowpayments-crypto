@extends('layouts.app')

@section('title', 'Pay for ' . $product->name)

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Pay for {{ $product->name }}</h2>
        <p class="mb-4">{{ $product->description }}</p>
        <p class="mb-4 font-semibold">Price: ${{ number_format($product->price, 2) }}</p>

        <form method="POST" action="{{ route('payment.create') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <label for="pay_currency" class="block mb-2 font-semibold">Select Crypto Currency:</label>
            <select id="pay_currency" name="pay_currency" required class="border rounded p-2 w-full mb-4">
                <option value="btc">Bitcoin (BTC)</option>
                <option value="eth">Ethereum (ETH)</option>
                <option value="usdt">Tether (USDT)</option>
                <!-- Add more if needed -->
            </select>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Pay Now
            </button>
        </form>
    </div>
@endsection
