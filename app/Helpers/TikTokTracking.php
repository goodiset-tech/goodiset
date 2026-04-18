<?php

namespace App\Helpers;

use App\Models\Countries;
use League\ISO3166\Exception\OutOfBoundsException;
use League\ISO3166\ISO3166;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class TikTokTracking
{
    const PIXEL_ID = 'D6M0V7BC77UE81ODJ4NG';

    private static ?ISO3166 $iso3166 = null;

    private static function iso3166(): ISO3166
    {
        return self::$iso3166 ??= new ISO3166;
    }

    /**
     * Map checkout / DB country labels that differ from league/iso3166 English names.
     *
     * @return array<string, string> lowercase name => ISO 3166-1 alpha-2
     */
    private static function countryNameAliases(): array
    {
        return [
            'congo (congo-brazzaville)' => 'CG',
            'micronesia' => 'FM',
            'south korea' => 'KR',
            'north korea' => 'KP',
            'russia' => 'RU',
            'vietnam' => 'VN',
            'bolivia' => 'BO',
            'palestine state' => 'PS',
            'palestine state of' => 'PS',
            'tanzania' => 'TZ',
            'moldova' => 'MD',
            'venezuela' => 'VE',
            'ivory coast' => 'CI',
            "côte d'ivoire" => 'CI',
            'cote divoire' => 'CI',
            'laos' => 'LA',
            'macau' => 'MO',
            'macao' => 'MO',
            'taiwan' => 'TW',
            'hong kong' => 'HK',
            'uae' => 'AE',
            'u.a.e.' => 'AE',
            'u a e' => 'AE',
            'the uae' => 'AE',
            'emirates' => 'AE',
        ];
    }

    /**
     * Resolve ISO 3166-1 alpha-2 region for libphonenumber (order country id, name, or "AE").
     */
    public static function regionFromCountryHint(mixed $hint): ?string
    {
        if ($hint === null || $hint === '') {
            return null;
        }

        if (is_numeric((string) $hint)) {
            $name = Countries::query()->whereKey((int) $hint)->value('name');
            if (! $name) {
                return null;
            }

            return self::countryNameToAlpha2((string) $name);
        }

        $s = trim((string) $hint);
        if (strlen($s) === 2 && ctype_alpha($s)) {
            $code = strtoupper($s);
            try {
                return self::iso3166()->alpha2($code)['alpha2'];
            } catch (OutOfBoundsException) {
                return null;
            }
        }

        return self::countryNameToAlpha2($s);
    }

    private static function countryNameToAlpha2(string $name): ?string
    {
        $key = mb_strtolower(trim($name));
        $aliases = self::countryNameAliases();
        if (isset($aliases[$key])) {
            return $aliases[$key];
        }

        foreach (self::countryNameCandidates($name) as $candidate) {
            try {
                return self::iso3166()->name($candidate)['alpha2'];
            } catch (OutOfBoundsException) {
                continue;
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private static function countryNameCandidates(string $name): array
    {
        $out = [];
        $n = trim($name);
        if ($n !== '') {
            $out[] = $n;
        }
        $cur = $n;
        while ($cur !== '' && preg_match('/\s*\([^)]*\)\s*$/u', $cur)) {
            $cur = trim((string) preg_replace('/\s*\([^)]*\)\s*$/u', '', $cur));
            if ($cur !== '' && ! in_array($cur, $out, true)) {
                $out[] = $cur;
            }
        }

        return $out;
    }

    public static function hashEmail($email)
    {
        if (empty($email)) {
            return '';
        }

        return hash('sha256', strtolower(trim($email)));
    }

    /**
     * @param  mixed|null  $countryHint  Country id (from DB), ISO2 code, or English country name (e.g. order->country).
     */
    public static function hashPhoneNumber($phone, mixed $countryHint = null)
    {
        if (empty($phone)) {
            return '';
        }
        $raw = trim((string) $phone);

        $hints = [];
        if ($countryHint !== null && trim((string) $countryHint) !== '') {
            $hints[] = $countryHint;
        }
        $fallback = self::phoneFallbackRegion();
        if ($fallback !== null && $fallback !== '') {
            $hints[] = $fallback;
        }
        $hints = array_values(array_unique($hints, SORT_REGULAR));

        $e164 = '';
        if (str_starts_with($raw, '+')) {
            $e164 = self::formatPhoneE164($raw, null);
        } else {
            foreach ($hints as $h) {
                $e164 = self::formatPhoneE164($raw, $h);
                if ($e164 !== '') {
                    break;
                }
            }
            if ($e164 === '') {
                $e164 = self::formatPhoneE164($raw, null);
            }
        }

        if ($e164 === '') {
            return '';
        }
        $digits = preg_replace('/\D+/', '', $e164);

        return $digits === '' ? '' : hash('sha256', $digits);
    }

    private static function phoneFallbackRegion(): ?string
    {
        $r = config('services.tiktok.phone_fallback_region');

        return $r === null || $r === '' ? null : strtoupper(trim((string) $r));
    }

    /**
     * Format to E.164 using Google's libphonenumber and the customer's country when the number is national format.
     *
     * @param  mixed|null  $countryHint  Same as hashPhoneNumber()
     */
    public static function formatPhoneE164(?string $phone, mixed $countryHint = null): string
    {
        if ($phone === null) {
            return '';
        }
        $raw = trim($phone);
        if ($raw === '') {
            return '';
        }

        $util = PhoneNumberUtil::getInstance();
        $region = self::regionFromCountryHint($countryHint);

        if (str_starts_with($raw, '00')) {
            $digits = preg_replace('/\D+/', '', $raw);
            if (strlen($digits) > 2) {
                $raw = '+'.substr($digits, 2);
            }
        }

        try {
            if (str_starts_with($raw, '+')) {
                $proto = $util->parse($raw, null);
            } else {
                if ($region === null) {
                    $digitsOnly = preg_replace('/\D+/', '', $raw);
                    if ($digitsOnly !== '' && strlen($digitsOnly) >= 8) {
                        $proto = $util->parse('+'.$digitsOnly, null);
                    } else {
                        return '';
                    }
                } else {
                    $proto = $util->parse($raw, $region);
                }
            }

            if (! $util->isValidNumber($proto)) {
                return '';
            }

            return $util->format($proto, PhoneNumberFormat::E164);
        } catch (NumberParseException) {
            return '';
        } catch (\Throwable) {
            return '';
        }
    }

    public static function hashExternalId($externalId)
    {
        if (empty($externalId)) {
            return '';
        }

        return hash('sha256', (string) $externalId);
    }

    public static function generateEventId()
    {
        $timestamp = (int) (microtime(true) * 1000);
        $random = random_int(0, 999);

        return $timestamp.'_'.$random;
    }

    public static function getPixelId()
    {
        return self::PIXEL_ID;
    }

    public static function getHashedUserData()
    {
        $email = '';
        $phone = '';
        $userId = '';
        $countryHint = null;

        if (session()->has('user')) {
            $user = session('user');
            $email = $user['email'] ?? '';
            $phone = $user['phone'] ?? '';
            $userId = $user['id'] ?? '';
        } elseif (session()->has('cart')) {
            $cart = session('cart');
            $email = $cart['email'] ?? '';
            $phone = $cart['phone'] ?? '';
            $userId = $cart['customer_id'] ?? '';
            $countryHint = $cart['country'] ?? null;
        }

        return [
            'email' => self::hashEmail($email),
            'phone_number' => self::hashPhoneNumber($phone, $countryHint),
            'external_id' => self::hashExternalId($userId),
        ];
    }
}
