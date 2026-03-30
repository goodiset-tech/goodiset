<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'discount', 'product_ids', 'status','start_date','end_date'];

    protected $casts = [
        'product_ids' => 'array', // Convert JSON to array automatically
    ];
}

