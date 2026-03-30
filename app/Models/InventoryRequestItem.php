<?php

namespace App\Models;

use App\Models\Admins\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_request_id',
        'product_id',
        'quantity',
        'unit',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventoryRequest()
    {
        return $this->belongsTo(InventoryRequest::class);
    }
}