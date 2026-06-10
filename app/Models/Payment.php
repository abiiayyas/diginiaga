<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'midtrans_transaction_id',
        'payment_type',
        'amount',
        'status',
        'paid_at',
        'webhook_payload',
    ];

    protected $casts = [
        'amount' => 'integer',
        'webhook_payload' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
