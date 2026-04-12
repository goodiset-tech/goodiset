<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'product_detail',
        'order_no',
        'customer_name',
        'email',
        'uid',
        'amount',
        'city',
        'phone',
        'country',
        'address',
        'shipping_company',
        'track_url',
        'track_no',
        'note',
        'status',
        'dstatus',
        'state',
        'postal_code',
        'unit',
        'unit_number',
        'company_name',
        'payment_method',
        'payment_status',
        'transaction_id',
        'order_note',
        'package_id',
        'package_size_id',
        'package_name',
        'package_detail',
        'package_qty',
        'payment_ref',
        'shipping_fee',
        'vat',
        'discount',
        'coupon_code',
        'session_id',
        'driver_token',
    ];
    public function getEncryptedOrderNoAttribute()
    {
        return \Illuminate\Support\Facades\Crypt::encryptString($this->order_no);
    }
}
