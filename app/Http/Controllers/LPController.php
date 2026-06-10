<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\Order;
use App\Services\BiteshipService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class LPController extends Controller
{
    public function show(string $slug)
    {
        $landingPage = LandingPage::with('product')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $landingPage->increment('visits');

        return view('lp.show', compact('landingPage'));
    }

    public function getShippingOptions(Request $request, BiteshipService $biteship)
    {
        $request->validate([
            'destination_city' => 'required|string',
        ]);

        $couriers = $biteship->getShippingRates(
            ['area_id' => config('services.biteship.origin_area_id', 'IDCGK101')],
            [
                'city' => $request->destination_city,
                'couriers' => ['jne', 'jnt', 'sicepat'],
            ],
            [[
                'name' => 'Produk',
                'weight' => 1000,
                'quantity' => 1,
                'value' => 100000,
            ]]
        );

        return response()->json(['couriers' => $couriers]);
    }

    public function createOrder(Request $request, WhatsAppService $whatsapp)
    {
        $validated = $request->validate([
            'landing_page_id' => 'required|exists:landing_pages,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_city' => 'required|string|max:100',
            'customer_province' => 'required|string|max:100',
            'customer_postal_code' => 'required|string|max:10',
            'shipping_courier' => 'required|string|max:50',
            'shipping_service' => 'nullable|string|max:50',
            'shipping_cost' => 'nullable|numeric|min:0',
            'qty' => 'nullable|integer|min:1',
        ]);

        $landingPage = LandingPage::with('product')->findOrFail($validated['landing_page_id']);

        $qty = $validated['qty'] ?? 1;
        $shippingCost = $validated['shipping_cost'] ?? 0;
        $unitPrice = $landingPage->product->sell_price;
        $totalAmount = ($unitPrice * $qty) + $shippingCost;

        $order = Order::create([
            'landing_page_id' => $landingPage->id,
            'product_id' => $landingPage->product_id,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'customer_city' => $validated['customer_city'],
            'customer_province' => $validated['customer_province'],
            'customer_postal_code' => $validated['customer_postal_code'],
            'qty' => $qty,
            'unit_price' => $unitPrice,
            'shipping_courier' => $validated['shipping_courier'],
            'shipping_service' => $validated['shipping_service'],
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'utm_source' => $request->input('utm_source'),
            'utm_medium' => $request->input('utm_medium'),
            'utm_campaign' => $request->input('utm_campaign'),
            'utm_content' => $request->input('utm_content'),
        ]);

        $paymentUrl = route('checkout.payment', ['order' => $order->order_number]);
        $whatsapp->sendOrderConfirmation($order, $paymentUrl);

        return redirect()->route('checkout.payment', ['order' => $order->order_number]);
    }
}
