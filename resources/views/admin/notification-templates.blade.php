@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Template Notifikasi WhatsApp</h1>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
        <p class="text-sm text-gray-500 mb-6">Template pesan WA otomatis. Gunakan <code class="text-xs bg-gray-100 px-1 py-0.5 rounded">@{{variable}}</code> untuk data dinamis.</p>

        <div class="mb-6"><h3 class="text-sm font-semibold text-gray-900 mb-2">Order Dibuat</h3><textarea rows="6" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm font-mono bg-gray-50" readonly>Halo @{{customer_name}}! Order #@{{order_number}} sudah diterima. 📦 @{{product_name}} 💰 Rp @{{total_amount}} ➡️ Bayar: @{{payment_url}}</textarea></div>
        <div class="mb-6"><h3 class="text-sm font-semibold text-gray-900 mb-2">Pembayaran Dikonfirmasi</h3><textarea rows="6" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm font-mono bg-gray-50" readonly>Halo @{{customer_name}}! Pembayaran #@{{order_number}} diterima ✅ Order diproses. Resi menyusul.</textarea></div>
        <div class="mb-6"><h3 class="text-sm font-semibold text-gray-900 mb-2">Resi Tergenerate</h3><textarea rows="8" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm font-mono bg-gray-50" readonly>Halo @{{customer_name}}! Order #@{{order_number}} dikirim 📦 Kurir: @{{courier_name}} Resi: @{{tracking_number}} Track: @{{tracking_url}}</textarea></div>
        <div class="mb-6"><h3 class="text-sm font-semibold text-gray-900 mb-2">Terkirim</h3><textarea rows="5" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm font-mono bg-gray-50" readonly>Halo @{{customer_name}}! Order #@{{order_number}} sudah sampai 🎉 Terima kasih!</textarea></div>
    </div>
</div>
@endsection
