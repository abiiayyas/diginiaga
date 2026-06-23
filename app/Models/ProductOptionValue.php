<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $fillable = [
        'product_option_id',
        'value',
    ];

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_option_value');
    }
}
