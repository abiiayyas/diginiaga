<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'landing_page_id',
        'product_id',
        'product_variant_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_city',
        'customer_province',
        'customer_postal_code',
        'qty',
        'unit_price',
        'shipping_courier',
        'shipping_service',
        'shipping_cost',
        'total_amount',
        'payment_method',
        'is_cod',
        'payment_status',
        'order_status',
        'midtrans_order_id',
        'notes',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'supplier_order_status',
        'supplier_ordered_at',
        'supplier_notes',
    ];

    protected $casts = [
        'unit_price' => 'integer',
        'shipping_cost' => 'integer',
        'total_amount' => 'integer',
        'qty' => 'integer',
        'supplier_ordered_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

    public function landingPage()
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notificationLogs()
    {
        return $this->hasMany(NotificationLog::class);
    }
}
