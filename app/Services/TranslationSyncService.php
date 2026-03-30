<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Facades\File;
use App\Models\TranslationKey;
use App\Models\TranslationValue;

class TranslationSyncService
{
    public function rebuildAll(): void
    {
        Language::query()->each(fn($lang) => $this->rebuildOne($lang->code));
    }

    public function rebuildOne(string $locale): void
    {
        $lang = Language::where('code',$locale)->firstOrFail();

        $pairs = TranslationValue::with('tkey')
            ->where('language_id',$lang->id)
            ->get()
            ->mapWithKeys(fn($v) => [$v->tkey->key => (string)($v->value ?? '')])
            ->toArray();

        $dir = resource_path('lang');
        if (!is_dir($dir)) { File::makeDirectory($dir, 0755, true); }

        $path = $dir . DIRECTORY_SEPARATOR . $locale . '.json';
        File::put($path, json_encode($pairs, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }
}