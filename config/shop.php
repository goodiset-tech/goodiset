<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ISO 4217 currency for ad pixels (Meta, TikTok, etc.)
    |--------------------------------------------------------------------------
    |
    | Display prices may still use getSetting('currency') (symbol/HTML) in views.
    | Pixels require a three-letter code (e.g. AED).
    |
    */
    'pixel_currency' => env('PIXEL_CURRENCY', 'AED'),
];
