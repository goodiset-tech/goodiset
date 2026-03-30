<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'address',
        'latitude',
        'longitude',
        'location_name', 
        'contact_name',
        'contact_email',
        'contact_phone',
    ];
}
