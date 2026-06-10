<?php

namespace App\Http\Controllers;

use App\Jobs\HandlePaymentConfirmed;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    protected MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    public function handle(Request $request)
    {
        $payload = $request->all();

        if (! $this->midtrans->verifyWebhookSignature($payload)) {
            Log::warning('Midtrans webhook: invalid signature', $payload);
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 401);
        }

        try {
            $result = $this->midtrans->handlePaymentNotification($payload);

            if ($result['event'] === 'payment_confirmed') {
                HandlePaymentConfirmed::dispatch($result['order']);
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error: ' . $e->getMessage(), $payload);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
