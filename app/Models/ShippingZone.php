<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = ['name', 'countries', 'cities'];

    protected $casts = [
        'countries' => 'array',
        'cities' => 'array',
    ];

    public function rates()
    {
        return $this->hasMany(ShippingRate::class);
    }
}
