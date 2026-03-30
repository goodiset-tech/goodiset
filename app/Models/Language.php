<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name','code','is_default'];

    public function values() {
        return $this->hasMany(TranslationValue::class);
    }
}
