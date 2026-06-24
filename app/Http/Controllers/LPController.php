<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\Order;
use App\Services\MengantarService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class LPController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $landingPage = LandingPage::with(['product.options.optionValues', 'product.variants.optionValues'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $landingPage->increment('visits');

        $utmParams = [
            'utm_source' => $request->query('utm_source'),
            'utm_medium' => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
            'utm_content' => $request->query('utm_content'),
        ];

        $utmQuery = http_build_query(array_filter($utmParams));

        return view('lp.show', compact('landingPage', 'utmQuery'));
    }

    public function searchArea(Request $request, MengantarService $mengantar)
    {
        $query = $request->input('q');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $areas = $mengantar->searchArea($query);
        return response()->json($areas);
    }

    public function getShippingOptions(Request $request, MengantarService $mengantar)
    {
        $request->validate([
            'destination_area_id' => 'required|string',
            'landing_page_id' => 'required|exists:landing_pages,id',
        ]);

        $landingPage = \App\Models\LandingPage::with('product.warehouse')->find($request->landing_page_id);
        $warehouse = $landingPage->product->warehouse;
        
        $originAreaId = $warehouse && $warehouse->mengantar_area_id 
            ? $warehouse->mengantar_area_id 
            : null;

        $couriers = $mengantar->getShippingRates(
            ['area_id' => $originAreaId],
            [
                'area_id' => $request->destination_area_id,
            ],
            [[
                'name' => $landingPage->product->name,
                'weight' => 1000,
                'quantity' => 1,
                'value' => $landingPage->product->sell_price,
            ]]
        );

        return response()->json(['couriers' => $couriers]);
    }

    public function createOrder(Request $request, WhatsAppService $whatsapp)
    {
        $validated = $request->validate([
            'landing_page_id' => 'required|exists:landing_pages,id',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_city' => 'required|string|max:100',
            'customer_province' => 'required|string|max:100',
            'customer_postal_code' => 'required|string|max:10',
            'destination_area_id' => 'required|string|max:255',
            'shipping_courier' => 'required|string|max:50',
            'shipping_service' => 'nullable|string|max:50',
            'shipping_cost' => 'nullable|numeric|min:0',
            'qty' => 'nullable|integer|min:1',
            'is_cod' => 'nullable|boolean',
        ]);

        $landingPage = LandingPage::with('product')->findOrFail($validated['landing_page_id']);

        $variant = null;
        if ($landingPage->product->has_variants) {
            $request->validate(['product_variant_id' => 'required|exists:product_variants,id']);
            $variant = \App\Models\ProductVariant::findOrFail($validated['product_variant_id']);
            if ($variant->product_id !== $landingPage->product_id) {
                return response()->json(['message' => 'Variant tidak valid.'], 422);
            }
        }

        $qty = $validated['qty'] ?? 1;
        $shippingCost = $validated['shipping_cost'] ?? 0;
        $unitPrice = $variant ? $variant->sell_price : $landingPage->product->sell_price;
        $totalAmount = ($unitPrice * $qty) + $shippingCost;

        $isCod = $request->boolean('is_cod');

        $order = Order::create([
            'landing_page_id' => $landingPage->id,
            'product_id' => $landingPage->product_id,
            'product_variant_id' => $variant ? $variant->id : null,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'customer_city' => $validated['customer_city'],
            'customer_province' => $validated['customer_province'],
            'customer_postal_code' => $validated['customer_postal_code'],
            'customer_area_id' => $validated['destination_area_id'],
            'qty' => $qty,
            'unit_price' => $unitPrice,
            'shipping_courier' => $validated['shipping_courier'],
            'shipping_service' => $validated['shipping_service'],
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'payment_method' => $isCod ? 'cod' : null,
            'is_cod' => $isCod,
            'utm_source' => $request->input('utm_source'),
            'utm_medium' => $request->input('utm_medium'),
            'utm_campaign' => $request->input('utm_campaign'),
            'utm_content' => $request->input('utm_content'),
        ]);

        if ($isCod) {
            $whatsapp->sendOrderConfirmation($order, route('tracking.show', $order->order_number));
            return redirect()->route('checkout.cod', ['order' => $order->order_number]);
        }

        $paymentUrl = route('checkout.payment', ['order' => $order->order_number]);
        $whatsapp->sendOrderConfirmation($order, $paymentUrl);

        return redirect()->route('checkout.payment', ['order' => $order->order_number]);
    }
}
