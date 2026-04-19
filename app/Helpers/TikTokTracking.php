<?php

namespace App\Helpers;

use App\Models\Admins\Order;
use App\Models\BoxSize;
use App\Models\Countries;
use App\Models\PackageType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

    /**
     * Stable event_id shared with the browser pixel CompletePayment (dedup with server Events API).
     */
    public static function purchaseEventIdForOrder(Order $order): string
    {
        return 'order_'.(string) ($order->id ?? '');
    }

    public static function purchaseExternalIdRaw(Order $order): string
    {
        if (isset($order->user_id) && $order->user_id !== null && (string) $order->user_id !== '') {
            return (string) $order->user_id;
        }
        if (isset($order->uid) && (int) $order->uid > 0) {
            return (string) $order->uid;
        }

        return (string) ($order->id ?? '');
    }

    /**
     * @return list<array{content_id: string, content_type: string, content_name: string, quantity: int, price: float}>
     */
    public static function purchaseContentsForOrder(Order $order): array
    {
        $purchaseContents = [];

        $products = json_decode($order->product_detail ?? '[]');
        if (! is_array($products) && ! is_object($products)) {
            $products = [];
        }
        foreach ($products as $product) {
            $product = (object) $product;
            if (isset($product->id) && $product->id !== null && $product->id !== '') {
                $purchaseContents[] = [
                    'content_id' => (string) $product->id,
                    'content_type' => 'product',
                    'content_name' => (string) ($product->name ?? ''),
                    'quantity' => (int) ($product->qty ?? 1),
                    'price' => (float) ($product->price ?? 0),
                ];
            }
        }

        $packagesRaw = json_decode($order->package_detail ?? '[]');
        if (! is_array($packagesRaw) && ! is_object($packagesRaw)) {
            $packagesRaw = [];
        }
        foreach ($packagesRaw as $pkgRow) {
            $value = (object) $pkgRow;
            $qty = (int) ($value->qty ?? 1);
            $linePrice = (float) ($value->package_price ?? 0);
            if ($qty < 1) {
                $qty = 1;
            }
            $typeId = $value->package_type ?? null;
            $sizeId = $value->package_size ?? null;
            if ($typeId === null || $typeId === '' || $sizeId === null || $sizeId === '') {
                continue;
            }
            $boxSize = BoxSize::where('id', $sizeId)->first();
            $packageType = PackageType::where('id', $typeId)->first();
            $nameParts = array_filter([
                $packageType?->name,
                $boxSize?->name,
            ]);
            $label = $nameParts !== [] ? implode(' — ', $nameParts) : 'Package';
            $purchaseContents[] = [
                'content_id' => 'pkg_'.$typeId.'_'.$sizeId,
                'content_type' => 'product',
                'content_name' => $label,
                'quantity' => $qty,
                'price' => $linePrice,
            ];
        }

        $totalValue = (float) ($order->amount ?? 0);
        if ($purchaseContents === [] && $totalValue > 0) {
            $purchaseContents[] = [
                'content_id' => 'order_'.(string) ($order->order_no ?? $order->id),
                'content_type' => 'product',
                'content_name' => 'Order',
                'quantity' => 1,
                'price' => $totalValue,
            ];
        }

        return $purchaseContents;
    }

    /**
     * TikTok Pixel server-to-server: {@see https://business-api.tiktok.com/portal/docs?id=1739584860408338}
     * Same event_id as the browser for deduplication.
     *
     * @throws \Throwable On transport errors or 5xx (caller may retry).
     */
    public static function sendServerCompletePaymentForOrder(
        Order $order,
        ?string $ip = null,
        ?string $userAgent = null,
        ?string $pageUrl = null,
        ?string $referrer = null
    ): bool {
        $token = config('services.tiktok.access_token');
        if ($token === null || $token === '') {
            return false;
        }

        $totalValue = (float) ($order->amount ?? 0);
        if ($totalValue <= 0) {
            return false;
        }

        $cacheKey = 'tiktok_server_complete_payment:'.$order->id;
        if (Cache::has($cacheKey)) {
            return true;
        }

        $contents = self::purchaseContentsForOrder($order);
        $currency = strtoupper(pixelCurrency());

        $emailPlain = strtolower(trim((string) ($order->email ?? '')));
        $externalRaw = self::purchaseExternalIdRaw($order);
        $userBlock = array_filter([
            'email' => $emailPlain !== '' ? self::hashEmail($emailPlain) : null,
            'phone_number' => self::hashPhoneNumber($order->phone ?? null, $order->country ?? null) ?: null,
            'external_id' => $externalRaw !== '' ? self::hashExternalId($externalRaw) : null,
        ], static fn ($v) => $v !== null && $v !== '');

        $context = array_filter([
            'ip' => $ip !== null && $ip !== '' ? $ip : null,
            'user_agent' => $userAgent !== null && $userAgent !== '' ? $userAgent : null,
        ], static fn ($v) => $v !== null && $v !== '');

        if ($userBlock !== []) {
            $context['user'] = $userBlock;
        }

        $page = array_filter([
            'url' => $pageUrl !== null && $pageUrl !== '' ? $pageUrl : null,
            'referrer' => $referrer !== null && $referrer !== '' ? $referrer : null,
        ], static fn ($v) => $v !== null && $v !== '');
        if ($page !== []) {
            $context['page'] = $page;
        }

        $ts = $order->created_at
            ? Carbon::parse($order->created_at)->utc()
            : now()->utc();
        $timestamp = $ts->format('Y-m-d\TH:i:s.v\Z');

        $properties = [
            'value' => $totalValue,
            'currency' => $currency,
        ];
        if ($contents !== []) {
            $properties['contents'] = $contents;
        }

        $payload = [
            'pixel_code' => self::PIXEL_ID,
            'event' => 'CompletePayment',
            'event_id' => self::purchaseEventIdForOrder($order),
            'timestamp' => $timestamp,
            'properties' => $properties,
        ];

        if ($context !== []) {
            $payload['context'] = $context;
        }

        $url = 'https://business-api.tiktok.com/open_api/v1.3/pixel/track/?access_token='.rawurlencode((string) $token);

        try {
            $response = Http::timeout(20)
                ->acceptJson()
                ->asJson()
                ->post($url, $payload);
        } catch (\Throwable $e) {
            Log::warning('TikTok server CompletePayment HTTP exception', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }

        if (! $response->successful()) {
            Log::warning('TikTok server CompletePayment HTTP error', [
                'order_id' => $order->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            if ($response->serverError()) {
                throw new \RuntimeException('TikTok pixel track HTTP '.$response->status());
            }

            return false;
        }

        $json = $response->json();
        $code = $json['code'] ?? null;
        if ($code !== 0 && $code !== '0') {
            Log::warning('TikTok server CompletePayment rejected', [
                'order_id' => $order->id,
                'response' => $json,
            ]);

            return false;
        }

        Cache::put($cacheKey, 1, now()->addDays(90));

        return true;
    }
}
