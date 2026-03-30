<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';

    public function getEncryptedOrderNoAttribute()
    {
        return \Illuminate\Support\Facades\Crypt::encryptString($this->order_no);
    }
}
