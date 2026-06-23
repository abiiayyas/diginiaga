<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'sell_price',
        'cost_price',
        'stock',
        'is_active',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'sell_price' => 'integer',
        'cost_price' => 'integer',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function optionValues()
    {
        return $this->belongsToMany(ProductOptionValue::class, 'product_variant_option_value');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
