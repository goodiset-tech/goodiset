<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory;

    // Specify the table name if it's different from the default 'customers'
    protected $table = 'customers';

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'name',
        'email',
        'phone',
        'otp',
    ];

    // Define any additional relationships or methods if required
}