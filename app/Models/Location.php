<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'address',
        'contact_name',
        'contact_email',
        'contact_phone',
        'location_name',
        'latitude',
        'longitude',
        'image' ,
        'open_close_time' ,
        'google_place_id',
    ];
}