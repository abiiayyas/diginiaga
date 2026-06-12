<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\Order;
use App\Services\MidtransService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected MidtransService $midtrans;
    protected WhatsAppService $whatsapp;

    public function __construct(MidtransService $midtrans, WhatsAppService $whatsapp)
    {
        $this->midtrans = $midtrans;
        $this->whatsapp = $whatsapp;
    }

    public function showForm(Request $request, string $slug)
    {
        $landingPage = LandingPage::with('product')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $utmParams = [
            'utm_source' => $request->query('utm_source'),
            'utm_medium' => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
            'utm_content' => $request->query('utm_content'),
        ];

        $utmQuery = http_build_query(array_filter($utmParams));

        return view('checkout.form', compact('landingPage', 'utmQuery'));
    }

    public function payment(string $orderNumber)
    {
        $order = Order::with(['product', 'landingPage'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.finish')
                ->with('order_number', $order->order_number);
        }

        if (in_array($order->order_status, ['processing', 'shipped', 'delivered'])) {
            return redirect()->route('checkout.finish')
                ->with('order_number', $order->order_number);
        }

        try {
            $snapData = $this->midtrans->createTransaction($order);
            $snapToken = $snapData['token'] ?? null;
        } catch (\Exception $e) {
            return view('checkout.error', [
                'message' => 'Gagal membuat transaksi pembayaran. Silakan coba lagi.',
            ]);
        }

        return view('checkout.payment', compact('order', 'snapToken'));
    }

    public function finish(Request $request)
    {
        $orderNumber = $request->session()->get('order_number')
            ?? $request->query('order_id');

        $order = null;
        if ($orderNumber) {
            $order = Order::with(['product', 'landingPage'])
                ->where('order_number', $orderNumber)
                ->first();
        }

        return view('checkout.finish', compact('order'));
    }

    public function error()
    {
        return view('checkout.error', [
            'message' => 'Terjadi kesalahan saat memproses pembayaran.',
        ]);
    }

    public function pending()
    {
        return view('checkout.pending');
    }

    public function cod(string $orderNumber)
    {
        $order = Order::with(['product', 'landingPage'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('checkout.cod', compact('order'));
    }
}
