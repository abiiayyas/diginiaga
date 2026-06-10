<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaPixelService
{
    public function sendPurchaseEvent(Order $order): void
    {
        $pixelId = $order->landingPage->pixel_id ?? config('services.meta.pixel_id');
        $accessToken = config('services.meta.access_token');

        if (empty($pixelId) || empty($accessToken)) {
            Log::info('Meta CAPI not configured, skipping Purchase event');
            return;
        }

        $payload = [
            'data' => [
                [
                    'event_name' => 'Purchase',
                    'event_time' => now()->timestamp,
                    'event_id' => $order->order_number,
                    'event_source_url' => $order->landingPage
                        ? config('app.url') . '/p/' . $order->landingPage->slug
                        : config('app.url'),
                    'action_source' => 'website',
                    'user_data' => [
                        'em' => null,
                        'ph' => $this->hashPhone($order->customer_phone),
                        'fn' => $this->hashString(explode(' ', $order->customer_name)[0] ?? ''),
                        'ln' => $this->hashString(explode(' ', $order->customer_name)[1] ?? ''),
                        'ct' => $this->hashString($order->customer_city),
                        'zp' => $this->hashString($order->customer_postal_code),
                    ],
                    'custom_data' => [
                        'currency' => 'IDR',
                        'value' => $order->total_amount,
                        'content_name' => $order->product->name,
                        'content_ids' => [(string) $order->product_id],
                        'content_type' => 'product',
                        'num_items' => $order->qty,
                        'order_id' => $order->order_number,
                    ],
                ],
            ],
        ];

        $response = Http::withOptions(['verify' => false])
            ->post("https://graph.facebook.com/v21.0/{$pixelId}/events?access_token={$accessToken}", $payload);

        if (!$response->successful()) {
            Log::error('Meta CAPI Purchase event failed', [
                'order' => $order->order_number,
                'response' => $response->body(),
            ]);
        } else {
            Log::info('Meta CAPI Purchase event sent', [
                'order' => $order->order_number,
            ]);
        }
    }

    protected function hashPhone(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }
        return hash('sha256', preg_replace('/[^0-9]/', '', $phone));
    }

    protected function hashString(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }
        return hash('sha256', strtolower(trim($value)));
    }
}
