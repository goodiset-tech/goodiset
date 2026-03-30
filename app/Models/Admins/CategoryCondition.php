<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'type',
        'condition',
        'condition_value',
    ];
}
