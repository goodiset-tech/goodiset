<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_warehouse_id',
        'dropoff_warehouse_id',
        'status',
        'users',
    ];
    protected $casts = [
        'users' => 'array', // Cast the users column to an array
    ];

    public function pickupWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'pickup_warehouse_id');
    }

    public function dropoffWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'dropoff_warehouse_id');
    }

    public function items()
    {
        return $this->hasMany(InventoryRequestItem::class);
    }
}