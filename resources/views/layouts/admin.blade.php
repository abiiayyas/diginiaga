<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex space-x-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 text-lg font-bold text-gray-900">
                            📦 {{ config('app.name') }}
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-3 py-2 text-sm {{ request()->routeIs('admin.orders.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Orders
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-3 py-2 text-sm {{ request()->routeIs('admin.products.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Produk
                        </a>
                        <a href="{{ route('admin.landing-pages.index') }}" class="inline-flex items-center px-3 py-2 text-sm {{ request()->routeIs('admin.landing-pages.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Landing Pages
                        </a>
                        <a href="{{ route('admin.analytics.index') }}" class="inline-flex items-center px-3 py-2 text-sm {{ request()->routeIs('admin.analytics.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Analytics
                        </a>
                        <a href="{{ route('admin.campaigns.index') }}" class="inline-flex items-center px-3 py-2 text-sm {{ request()->routeIs('admin.campaigns.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            Campaigns
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">{{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-gray-500 hover:text-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
