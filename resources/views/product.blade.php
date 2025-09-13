@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Available Products</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                <p class="text-gray-700 mt-2">{{ $product->description }}</p>
                <p class="font-bold text-indigo-700 mt-3">${{ number_format($product->price, 2) }}</p>
                <a href="{{ route('payment.show', $product->id) }}"
                   class="inline-block mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Pay with Crypto
                </a>
            </div>
        @endforeach
    </div>
@endsection
