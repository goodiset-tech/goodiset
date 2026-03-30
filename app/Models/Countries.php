<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'country';
    protected $fillable = ['name','min_order','shipping_cost','free_shipping','shipping_time','status'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}