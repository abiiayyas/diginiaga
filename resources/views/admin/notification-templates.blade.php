@extends('layouts.admin')

@section('title', 'Template Notifikasi WhatsApp')

@section('content')
<h2 class="text-xl font-semibold mb-6">Template Notifikasi WhatsApp</h2>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <p class="text-sm text-gray-500 mb-4">Template pesan WhatsApp yang dikirim otomatis. Gunakan placeholder <code>{<!-- -->{variable}}</code> untuk data dinamis.</p>

    <form action="#" method="POST">
        @csrf
        <div class="mb-6">
            <h3 class="font-medium mb-2">Order Dibuat</h3>
            <textarea rows="6" class="w-full rounded-lg border-gray-300 text-sm font-mono" readonly>Halo {{'{{customer_name}}'}}!

Order kamu #{{'{{order_number}}'}} sudah kami terima.

📦 {{'{{product_name}}'}}
💰 Total: Rp {{'{{total_amount}}'}}

Silakan selesaikan pembayaran melalui:
{{'{{payment_url}}'}}

Terima kasih!</textarea>
        </div>

        <div class="mb-6">
            <h3 class="font-medium mb-2">Pembayaran Dikonfirmasi</h3>
            <textarea rows="6" class="w-full rounded-lg border-gray-300 text-sm font-mono" readonly>Halo {{'{{customer_name}}'}}!

Pembayaran untuk order #{{'{{order_number}}'}} sudah diterima ✅
Order kamu sedang diproses.

Kami akan kirim nomor resi setelah pengiriman.

Terima kasih!</textarea>
        </div>

        <div class="mb-6">
            <h3 class="font-medium mb-2">Resi Tergenerate</h3>
            <textarea rows="8" class="w-full rounded-lg border-gray-300 text-sm font-mono" readonly>Halo {{'{{customer_name}}'}}!

Order #{{'{{order_number}}'}} sudah dikirim! 📦

Kurir: {{'{{courier_name}}'}}
No. Resi: {{'{{tracking_number}}'}}

Cek status:
{{'{{tracking_url}}'}}

Terima kasih!</textarea>
        </div>

        <div class="mb-6">
            <h3 class="font-medium mb-2">Terkirim (Delivered)</h3>
            <textarea rows="5" class="w-full rounded-lg border-gray-300 text-sm font-mono" readonly>Halo {{'{{customer_name}}'}}!

Order #{{'{{order_number}}'}} sudah sampai 🎉

Terima kasih sudah berbelanja! Jika ada pertanyaan, hubungi kami.</textarea>
        </div>
    </form>
</div>
