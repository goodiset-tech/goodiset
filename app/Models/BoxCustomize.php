<?php

namespace App\Models;

use App\Models\Admins\Size;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxCustomize extends Model
{
    use HasFactory;

    protected $table = 'box_customize';

    protected $fillable = [
        'package_id',
        'size_id',
        'price',
    ];

    // Add relationships if needed
    // public function package()
    // {
    //     return $this->belongsTo(PackageType::class, 'package_id');
    // }

    // public function size()
    // {
    //     return $this->belongsTo(Size::class, 'size_id');
    // }
}
