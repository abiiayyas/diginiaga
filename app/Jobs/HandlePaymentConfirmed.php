<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\MetaPixelService;
use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class HandlePaymentConfirmed implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 300;

    public function __construct(
        public Order $order,
    ) {}

    public function handle(WhatsAppService $whatsapp, MetaPixelService $meta): void
    {
        $whatsapp->sendPaymentConfirmed($this->order);
        $whatsapp->sendOperatorNotification($this->order);
        $meta->sendPurchaseEvent($this->order);
    }
}
