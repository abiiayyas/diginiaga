<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku_supplier',
        'description',
        'sell_price',
        'cost_price',
        'images',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'sell_price' => 'integer',
        'cost_price' => 'integer',
        'is_active' => 'boolean',
    ];

    public function landingPages()
    {
        return $this->hasMany(LandingPage::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
