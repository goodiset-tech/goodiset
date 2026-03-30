<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['country_id', 'name','min_order','shipping_cost','free_shipping','shipping_time'];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
}
