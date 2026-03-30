<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contact';
    protected $fillable = [
        'name',
        'email',
        'meg',
        'created_at',
        'updated_at',
        'phone',
        'company',
        'category',
        'country',
        'model_type',
        'estimated_investment_budget',
        'shop_count',
        'monthly_kilo_order',
        'organization_name',
        'event_location',
        'event_type',
        'estimated_attendance',
        'preferred_product_types',
        'contact_type',
        'inquiring',
        'influencer_platform', 
        'follower_count',
         'username'
    ];
    
}
