<?php

namespace App\Models\Admins;


use Illuminate\Database\Eloquent\Model;

class BoxProduct extends Model
{
    protected $fillable = ['box_id', 'product_id', 'percentage', 'pieces'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}