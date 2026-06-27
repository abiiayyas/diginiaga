@extends('layouts.admin')

@section('title', 'Pusat Pengaturan')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-slate-200">Pusat Pengaturan</h2>
    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Kelola profil, password, dan integrasi sistem eksternal di sini.</p>
</div>

<div x-data="{ activeTab: new URLSearchParams(window.location.search).get('tab') || 'profil' }">
    <!-- Tabs Header -->
    <div class="border-b border-gray-200 dark:border-slate-700 w-full overflow-x-auto [&::-webkit-scrollbar]:hidden" style="-webkit-overflow-scrolling: touch; scrollbar-width: none;">
        <nav class="flex space-x-6 min-w-max" aria-label="Tabs">
            <button @click="activeTab = 'toko'" :class="activeTab === 'toko' ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none">
                Toko
            </button>
            <button @click="activeTab = 'profil'" :class="activeTab === 'profil' ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none">
                Profil & Password
            </button>
            <button @click="activeTab = 'kurir'" :class="activeTab === 'kurir' ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none">
                Integrasi Kurir
            </button>
            <button @click="activeTab = 'piksel'" :class="activeTab === 'piksel' ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none">
                Piksel FB (Global)
            </button>
            <button @click="activeTab = 'notifikasi'" :class="activeTab === 'notifikasi' ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300 hover:border-gray-300 dark:hover:border-slate-600'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none">
                Notifikasi (WA & Telegram)
            </button>
        </nav>
    </div>

    <!-- Tabs Content -->
    <div class="mt-6">
        
        <!-- Tab: Toko -->
        <div x-show="activeTab === 'toko'" x-cloak>
            <form method="post" action="{{ route('admin.settings.update') }}">
                @csrf
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-slate-800 max-w-2xl">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-200 mb-1">Informasi Toko</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Nama toko akan tampil di halaman landing page.</p>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nama Toko</label>
                            <input type="text" name="store_name" value="{{ $settings['store_name'] ?? config('app.name', 'Toko Resmi') }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Diginiaga Shop">
                            <p class="text-[11px] text-gray-400 dark:text-slate-500 mt-1">Nama ini akan muncul di bagian "Toko Resmi" pada landing page.</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-800">
                        <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-6 rounded-lg text-sm transition-colors">Simpan Pengaturan</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tab: Profil -->
        <div x-show="activeTab === 'profil'" x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Update Profile -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-200 mb-1">Informasi Profil</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Perbarui nama dan alamat email akun Anda.</p>
                    
                    <form method="post" action="{{ route('admin.settings.profile') }}" class="space-y-4">
                        @csrf
                        @method('patch')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nama</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors">Simpan Profil</button>
                        </div>
                    </form>
                </div>

                <!-- Update Password -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-slate-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-200 mb-1">Ubah Password</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Pastikan akun Anda menggunakan password yang panjang dan acak.</p>
                    
                    <form method="post" action="{{ route('admin.settings.password') }}" class="space-y-4">
                        @csrf
                        @method('patch')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password" required class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('current_password', 'updatePassword') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Password Baru</label>
                            <input type="password" name="password" required class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('password', 'updatePassword') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('password_confirmation', 'updatePassword') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors">Perbarui Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <form method="post" action="{{ route('admin.settings.update') }}">
            @csrf

            <!-- Tab: Kurir -->
            <div x-show="activeTab === 'kurir'" x-cloak class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-slate-800 max-w-2xl">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-200 mb-1">Integrasi Kurir</h3>
                <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Atur provider pengiriman dan API Key yang digunakan sistem.</p>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Active Courier Provider</label>
                        <select name="active_courier_provider" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="biteship" {{ ($settings['active_courier_provider'] ?? '') == 'biteship' ? 'selected' : '' }}>Mengantar</option>
                            <option value="lainnya" {{ ($settings['active_courier_provider'] ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <p class="text-[11px] text-gray-400 dark:text-slate-500 mt-1">Pilih layanan kurir utama yang aktif di form pemesanan.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Mengantar API Key</label>
                        <input type="text" name="biteship_api_key" value="{{ $settings['biteship_api_key'] ?? '' }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="biteship_xxx">
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-800">
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-6 rounded-lg text-sm transition-colors">Simpan Pengaturan</button>
                </div>
            </div>

            <!-- Tab: Piksel FB -->
            <div x-show="activeTab === 'piksel'" x-cloak class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-slate-800 max-w-2xl">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-200 mb-1">Global FB Pixel</h3>
                <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Pixel ID ini akan disematkan di SEMUA halaman Landing Page. Berguna untuk tracking global.</p>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Global Meta Pixel ID</label>
                    <input type="text" name="global_pixel_id" value="{{ $settings['global_pixel_id'] ?? '' }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. 123456789012345">
                    <p class="text-[11px] text-gray-400 dark:text-slate-500 mt-1">Jika diisi, Pixel ini akan mendampingi (ikut dimuat bersama) Pixel ID spesifik tiap produk.</p>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-800">
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-6 rounded-lg text-sm transition-colors">Simpan Pengaturan</button>
                </div>
            </div>

            <!-- Tab: Notifikasi -->
            <div x-show="activeTab === 'notifikasi'" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- WA Notif -->
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-200 mb-1">WA Gateway & Buyer Notif</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Atur token Fonnte dan pesan otomatis untuk pembeli.</p>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Fonnte API Token</label>
                                <input type="text" name="fonnte_token" value="{{ $settings['fonnte_token'] ?? '' }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Token dari fonnte.com">
                            </div>

                            <div class="flex items-center gap-3 bg-gray-50 dark:bg-slate-800/50 p-3 rounded-lg border border-gray-100 dark:border-slate-800">
                                <input type="checkbox" name="wa_buyer_notification_enabled" value="1" id="wa_notif_toggle" class="rounded border-gray-300 dark:border-slate-600 text-brand-600 focus:ring-brand-600 w-4 h-4" {{ ($settings['wa_buyer_notification_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                <label for="wa_notif_toggle" class="text-sm text-gray-700 dark:text-slate-300 font-medium">Kirim notifikasi WA otomatis ke pembeli baru</label>
                            </div>

                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 flex items-center justify-between">
                                <span class="text-sm text-blue-800">Isi pesan otomatis dapat dikonfigurasi di menu Notifikasi.</span>
                                <a href="{{ route('admin.notification-templates') }}" class="text-sm font-semibold text-blue-700 hover:underline">Atur Template &rarr;</a>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-800">
                            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-6 rounded-lg text-sm transition-colors">Simpan Pengaturan</button>
                        </div>
                    </div>

                    <!-- Telegram Notif -->
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-slate-800">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-200 mb-1">Notifikasi Telegram Admin</h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Dapatkan notifikasi pesanan baru langsung ke Telegram.</p>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Bot Token</label>
                                <input type="text" name="telegram_bot_token" value="{{ $settings['telegram_bot_token'] ?? '' }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="123456789:ABCdefGHIjklMNOpqrSTUvwxYZ">
                                <p class="text-[11px] text-gray-400 dark:text-slate-500 mt-1">Dapatkan dari @BotFather</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Chat ID</label>
                                <input type="text" name="telegram_chat_id" value="{{ $settings['telegram_chat_id'] ?? '' }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Misal: -1001234567890">
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-800">
                            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-6 rounded-lg text-sm transition-colors">Simpan Pengaturan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
