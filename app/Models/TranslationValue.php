<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationValue extends Model
{
    protected $fillable = ['language_id','translation_key_id','value'];

    public function language()  { return $this->belongsTo(Language::class); }
    public function tkey()      { return $this->belongsTo(TranslationKey::class,'translation_key_id'); }
}
