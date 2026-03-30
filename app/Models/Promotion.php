<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'discount',
        'cart_minimum',
        'product_ids',
        'free_product_ids',
        'customer_type',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'product_ids' => 'array',
        'free_product_ids' => 'array',
    ];
}
