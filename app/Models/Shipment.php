<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'biteship_order_id',
        'courier_name',
        'tracking_number',
        'status',
        'status_history',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'status_history' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
