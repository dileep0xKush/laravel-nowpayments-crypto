<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique();
            $table->string('payment_id')->nullable(); // NOWPayments payment id
            $table->string('pay_currency'); // crypto currency (e.g. btc)
            $table->decimal('price_amount', 12, 2);
            $table->string('price_currency')->default('USD'); // usually USD
            $table->string('payment_status')->default('pending');
            $table->string('invoice_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
