<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Setting;

class NotificationTemplateController extends Controller
{
    public function index()
    {
        $settings = [
            'wa_template_order_created' => Setting::get('wa_template_order_created', "Halo {{customer_name}}! Order #{{order_number}} sudah diterima. 📦 {{product_name}} 💰 Rp {{total_amount}} ➡️ Bayar: {{payment_url}}"),
            'wa_template_payment_confirmed' => Setting::get('wa_template_payment_confirmed', "Halo {{customer_name}}! Pembayaran #{{order_number}} diterima ✅ Order diproses. Resi menyusul."),
            'wa_template_shipping_created' => Setting::get('wa_template_shipping_created', "Halo {{customer_name}}! Order #{{order_number}} dikirim 📦 Kurir: {{courier_name}} Resi: {{tracking_number}} Track: {{tracking_url}}"),
            'wa_template_delivered' => Setting::get('wa_template_delivered', "Halo {{customer_name}}! Order #{{order_number}} sudah sampai 🎉 Terima kasih!"),
        ];
        return view('admin.notification-templates', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = [
            'wa_template_order_created',
            'wa_template_payment_confirmed',
            'wa_template_shipping_created',
            'wa_template_delivered'
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key));
        }

        return back()->with('success', 'Template Notifikasi berhasil disimpan.');
    }
}
