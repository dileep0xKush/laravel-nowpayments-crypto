<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;


Route::get('/', [ProductController::class, 'index'])->name('product.list');

Route::get('/payment/{id}', [PaymentController::class, 'showProductPayment'])->name('payment.show');
Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('payment.create');
