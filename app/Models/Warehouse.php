<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'province',
        'postal_code',
        'mengantar_area_id',
        'mengantar_address_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
