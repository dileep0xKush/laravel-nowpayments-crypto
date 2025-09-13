<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Crypto Payments')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">🪙 CryptoPay</h1>
            <nav>
                <a href="/" class="text-gray-600 hover:text-indigo-600 mx-2">Home</a>
                <a href="/create-payment" class="text-gray-600 hover:text-indigo-600 mx-2">Create Payment</a>
            </nav>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-8 px-4">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Dileep Kushwaha — All rights reserved.
        </div>
    </footer>

</body>
</html>
