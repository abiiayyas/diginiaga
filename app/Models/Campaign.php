<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'ad_spend',
        'notes',
    ];

    protected $casts = [
        'ad_spend' => 'integer',
    ];
}
