<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'product_id',
        'slug',
        'headline',
        'subheadline',
        'body_content',
        'cta_text',
        'cta_color',
        'pixel_id',
        'domain',
        'is_active',
        'variant_name',
        'visits',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'visits' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
