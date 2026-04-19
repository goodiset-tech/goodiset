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

if (! function_exists('homeVideoPublicUrl')) {
    /**
     * Public URL for a home-page video or poster path stored in the DB (e.g. videos/home-page/x.mp4).
     * Uses HOME_VIDEO_PUBLIC_URL when set (CDN / bucket / volume URL); otherwise Laravel asset().
     */
    function homeVideoPublicUrl(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }
        $base = config('home_videos.public_url');
        if (is_string($base) && $base !== '') {
            return rtrim($base, '/').'/'.ltrim($path, '/');
        }

        return asset($path);
    }
}
