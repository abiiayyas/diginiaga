@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100 mb-6">Template Notifikasi WhatsApp</h1>
    <form action="{{ route('admin.notification-templates.update') }}" method="POST" class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-6">
        @csrf
        <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Template pesan WA otomatis. Gunakan <code class="text-xs bg-gray-100 dark:bg-slate-800 px-1 py-0.5 rounded">@{{variable}}</code> untuk data dinamis.</p>

        <div class="mb-6"><h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-2">Order Dibuat</h3><textarea name="wa_template_order_created" rows="6" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm font-mono focus:border-brand-500 focus:ring-brand-500">{{ $settings['wa_template_order_created'] }}</textarea></div>
        <div class="mb-6"><h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-2">Pembayaran Dikonfirmasi</h3><textarea name="wa_template_payment_confirmed" rows="6" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm font-mono focus:border-brand-500 focus:ring-brand-500">{{ $settings['wa_template_payment_confirmed'] }}</textarea></div>
        <div class="mb-6"><h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-2">Resi Tergenerate</h3><textarea name="wa_template_shipping_created" rows="8" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm font-mono focus:border-brand-500 focus:ring-brand-500">{{ $settings['wa_template_shipping_created'] }}</textarea></div>
        <div class="mb-6"><h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-2">Terkirim</h3><textarea name="wa_template_delivered" rows="5" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm font-mono focus:border-brand-500 focus:ring-brand-500">{{ $settings['wa_template_delivered'] }}</textarea></div>
        
        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-800">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-6 rounded-lg text-sm transition-colors">Simpan Template</button>
        </div>
    </form>
</div>
@endsection
