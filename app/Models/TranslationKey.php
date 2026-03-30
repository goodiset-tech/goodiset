<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationKey extends Model
{
    protected $fillable = ['key'];

    public function values() {
        return $this->hasMany(TranslationValue::class);
    }
}
