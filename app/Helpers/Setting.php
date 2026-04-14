<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getSetting')) {
    /**
     * Retrieve the value of a given setting column.
     *
     * @param string $column
     * @return mixed
     */
    function getSetting(string $column)
    {
        return DB::table('setting')->value($column);
    }
}

if (!function_exists('pixelCurrency')) {
    /**
     * ISO 4217 code for Meta/TikTok/Snap payloads (not for UI display).
     */
    function pixelCurrency(): string
    {
        $code = config('shop.pixel_currency', 'AED');
        if (! is_string($code)) {
            return 'AED';
        }
        $code = strtoupper(trim($code));

        return preg_match('/^[A-Z]{3}$/', $code) === 1 ? $code : 'AED';
    }
}
