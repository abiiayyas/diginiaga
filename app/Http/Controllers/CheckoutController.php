<?php

namespace App\Http\Controllers;

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
}
