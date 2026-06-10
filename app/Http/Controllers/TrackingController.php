<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function show(string $orderNumber)
    {
        $order = Order::with(['product', 'shipment', 'landingPage'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('tracking.show', compact('order'));
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::with(['product', 'shipment'])
            ->where('order_number', $request->order_number)
            ->first();

        if (!$order) {
            return back()->with('error', 'Order tidak ditemukan. Periksa kembali nomor order Anda.');
        }

        return view('tracking.show', compact('order'));
    }
}
