<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
</head>
<body class="bg-surface-50 font-sans text-gray-900 antialiased">
    
    <!-- Sidebar -->
    <div id="application-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform w-64 hidden fixed top-0 left-0 bottom-0 z-[60] bg-white border-r border-gray-200 shadow-soft lg:block lg:translate-x-0">
        <div class="flex items-center justify-between px-6 pt-6 pb-4">
            <a href="{{ route('admin.dashboard') }}" class="flex-none text-xl font-semibold flex items-center transition-transform hover:scale-105" aria-label="Brand">
                <img src="{{ asset('logo-black.png') }}" alt="DigiNiaga" class="h-8 w-auto" onerror="this.outerHTML='<span class=\'text-lg font-bold text-gray-900\'><span class=\'text-brand-600\'>Digi</span>Niaga</span>'">
            </a>
            <button type="button" class="lg:hidden text-gray-500 hover:text-gray-600" data-hs-overlay="#application-sidebar" aria-controls="application-sidebar" aria-label="Close">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <nav class="hs-accordion-group p-4 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
            <ul class="flex flex-col space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-x-3 py-2.5 px-4 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-gray-600 hover:bg-surface-100 hover:text-gray-900' }}">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6Zm0 9.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                        Dashboard
                    </a>
                </li>

                <li class="hs-accordion {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" id="hs-orders-accordion">
                    <button type="button" class="hs-accordion-toggle w-full flex items-center gap-x-3 py-2.5 px-4 text-sm font-medium rounded-xl transition-all duration-200 text-gray-600 hover:bg-surface-100 hover:text-gray-900 {{ request()->routeIs('admin.orders.*') ? 'hs-accordion-active:text-brand-600' : '' }}" aria-expanded="{{ request()->routeIs('admin.orders.*') ? 'true' : 'false' }}" aria-controls="hs-orders-collapse">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                        Orders
                        <svg class="hs-accordion-active:block ml-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                        <svg class="hs-accordion-active:hidden ml-auto block size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    </button>
                    <div id="hs-orders-collapse" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ request()->routeIs('admin.orders.*') ? '' : 'hidden' }}" aria-labelledby="hs-orders-accordion">
                        <ul class="pt-2 pl-9 space-y-1">
                            <li><a href="{{ route('admin.orders.index') }}" class="flex items-center gap-x-3 py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.orders.index') ? 'bg-surface-100 font-semibold text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">Semua Order</a></li>
                            <li><a href="{{ route('admin.orders.supplier-queue') }}" class="flex items-center gap-x-3 py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.orders.supplier-queue') ? 'bg-surface-100 font-semibold text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">Antrian Supplier</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-x-3 py-2.5 px-4 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-gray-600 hover:bg-surface-100 hover:text-gray-900' }}">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" /></svg>
                        Produk
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.landing-pages.index') }}" class="flex items-center gap-x-3 py-2.5 px-4 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.landing-pages.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-gray-600 hover:bg-surface-100 hover:text-gray-900' }}">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" /></svg>
                        Landing Pages
                    </a>
                </li>

                <li class="hs-accordion {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}" id="hs-analytics-accordion">
                    <button type="button" class="hs-accordion-toggle w-full flex items-center gap-x-3 py-2.5 px-4 text-sm font-medium rounded-xl transition-all duration-200 text-gray-600 hover:bg-surface-100 hover:text-gray-900" aria-expanded="{{ request()->routeIs('admin.analytics.*') ? 'true' : 'false' }}" aria-controls="hs-analytics-collapse">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
                        Analytics
                        <svg class="hs-accordion-active:block ml-auto hidden size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                        <svg class="hs-accordion-active:hidden ml-auto block size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    </button>
                    <div id="hs-analytics-collapse" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ request()->routeIs('admin.analytics.*') ? '' : 'hidden' }}" aria-labelledby="hs-analytics-accordion">
                        <ul class="pt-2 pl-9 space-y-1">
                            <li><a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-x-3 py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.analytics.index') ? 'bg-surface-100 font-semibold text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">Performa LP</a></li>
                            <li><a href="{{ route('admin.analytics.campaigns') }}" class="flex items-center gap-x-3 py-2 px-3 text-sm rounded-lg transition-colors {{ request()->routeIs('admin.analytics.campaigns') ? 'bg-surface-100 font-semibold text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">Campaign ROAS</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-x-3 py-2.5 px-4 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.campaigns.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-gray-600 hover:bg-surface-100 hover:text-gray-900' }}">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" /></svg>
                        Campaigns
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.notification-templates') }}" class="flex items-center gap-x-3 py-2.5 px-4 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.notification-templates') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-gray-600 hover:bg-surface-100 hover:text-gray-900' }}">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" /></svg>
                        Notifikasi
                    </a>
                </li>

                <li class="pt-4 mt-4 border-t border-gray-100">
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-x-3 py-2.5 px-4 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-gray-600 hover:bg-surface-100 hover:text-gray-900' }}">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.99l1.003.828c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                        Pengaturan
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Header -->
    <header class="fixed top-0 right-0 left-0 lg:left-64 z-50 flex items-center justify-between bg-white/80 backdrop-blur-md border-b border-gray-200 px-4 sm:px-6 py-3 h-[60px] transition-all duration-300">
        <div class="flex items-center">
            <button type="button" class="lg:hidden text-gray-500 hover:text-gray-600 mr-3" data-hs-overlay="#application-sidebar" aria-controls="application-sidebar" aria-label="Toggle navigation">
                <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
            </button>
            <div class="lg:hidden">
                <a href="{{ route('admin.dashboard') }}" aria-label="Brand">
                    <img src="{{ asset('logo-black.png') }}" alt="DigiNiaga" class="h-6 w-auto" onerror="this.outerHTML='<span class=\'text-md font-bold text-gray-900\'><span class=\'text-brand-600\'>Digi</span>Niaga</span>'">
                </a>
            </div>
        </div>

        <!-- Account Info & Dropdown (Top Right) -->
        <div class="hs-dropdown relative inline-flex" style="--placement: bottom-end; --trigger: click;">
            <button id="hs-dropdown-with-header" type="button" class="hs-dropdown-toggle w-[2.375rem] h-[2.375rem] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </button>

            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-lg rounded-2xl p-2 mt-2 border border-gray-100 z-50" aria-labelledby="hs-dropdown-with-header">
                <div class="py-3 px-5 -m-2 bg-surface-50 border-b border-gray-100 rounded-t-2xl">
                    <p class="text-xs text-gray-400">Masuk sebagai</p>
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email }} ({{ ucfirst(Auth::user()->role) }})</p>
                </div>
                <div class="mt-2 py-1.5">
                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-xl text-sm text-gray-800 hover:bg-surface-100 focus:outline-none focus:bg-surface-100 transition-colors" href="{{ route('admin.dashboard') }}">
                        <svg class="shrink-0 size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    
                    <div class="my-1.5 border-t border-gray-100"></div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-xl text-sm text-red-500 hover:bg-red-50/50 hover:text-red-600 focus:outline-none focus:bg-red-50/50 transition-colors text-left">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Wrapper -->
    <div class="pt-[60px] lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-teal-50 border border-teal-200 text-teal-800 rounded-xl text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
