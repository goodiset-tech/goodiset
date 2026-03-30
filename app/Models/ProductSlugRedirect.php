<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSlugRedirect extends Model
{
    protected $fillable = ['product_id', 'old_slug'];
}
