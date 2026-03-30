<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = ['box_name', 'box_weight', 'max_boxes'];

    public function products()
    {
        return $this->hasMany(BoxProduct::class);
    }
}