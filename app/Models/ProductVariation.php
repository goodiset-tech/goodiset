<?php

namespace App\Models;

use App\Models\Admins\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    
    use HasFactory;
    protected $fillable = ['product_id', 'sku', 'price', 'stock', 'image'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variation_attributes');
    }
}
