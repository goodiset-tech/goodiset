<?php

namespace App\Helpers;

use App\Models\Admins\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaPixelTracking
{
    public static function getPixelId(): string
    {
        $id = config('services.meta.pixel_id');

        return ($id !== null && $id !== '') ? (string) $id : '4013696122240068';
    }

    /**
     * Same stable id as TikTok server/browser for easy log correlation (Meta dedupes only within Meta).
     */
    public static function purchaseEventIdForOrder(Order $order): string
    {
        return 'order_'.(string) ($order->id ?? '');
    }

    /**
     * @param  list<array{content_id: string, content_type?: string, content_name?: string, quantity: int, price: float}>  $tikTokStyleRows
     * @return list<array{id: string, quantity: int, item_price: float}>
     */
    public static function mapToMetaContents(array $tikTokStyleRows): array
    {
        $out = [];
        foreach ($tikTokStyleRows as $row) {
            $id = (string) ($row['content_id'] ?? '');
            if ($id === '') {
                continue;
            }
            $out[] = [
                'id' => $id,
                'quantity' => (int) ($row['quantity'] ?? 1),
                'item_price' => (float) ($row['price'] ?? 0),
            ];
        }

        return $out;
    }

    /**
     * Meta Conversions API (website Purchase).
     *
     * @see https://developers.facebook.com/docs/marketing-api/conversions-api/using-the-api
     *
     * @throws \Throwable On transport errors or Graph 5xx (caller may retry).
     */
    public static function sendServerPurchaseForOrder(
        Order $order,
        ?string $ip = null,
        ?string $userAgent = null,
        ?string $fbc = null,
        ?string $fbp = null,
        ?string $eventSourceUrl = null
    ): bool {
        $token = config('services.meta.access_token');
        if ($token === null || $token === '') {
            return false;
        }

        $totalValue = (float) ($order->amount ?? 0);
        if ($totalValue <= 0) {
            return false;
        }

        $cacheKey = 'meta_server_purchase:'.$order->id;
        if (Cache::has($cacheKey)) {
            return true;
        }

        $pixelId = self::getPixelId();
        $version = (string) (config('services.meta.graph_api_version') ?: 'v21.0');
        $version = ltrim($version, '/');

        $currency = strtoupper(pixelCurrency());
        $contents = self::mapToMetaContents(TikTokTracking::purchaseContentsForOrder($order));

        $emailPlain = strtolower(trim((string) ($order->email ?? '')));
        $externalRaw = TikTokTracking::purchaseExternalIdRaw($order);
        $hashedEmail = $emailPlain !== '' ? TikTokTracking::hashEmail($emailPlain) : '';
        $hashedPhone = TikTokTracking::hashPhoneNumber($order->phone ?? null, $order->country ?? null);
        $hashedExternalId = $externalRaw !== '' ? TikTokTracking::hashExternalId($externalRaw) : '';

        $userData = [];
        if ($hashedEmail !== '') {
            $userData['em'] = [$hashedEmail];
        }
        if ($hashedPhone !== '') {
            $userData['ph'] = [$hashedPhone];
        }
        if ($hashedExternalId !== '') {
            $userData['external_id'] = [$hashedExternalId];
        }
        if ($ip !== null && $ip !== '') {
            $userData['client_ip_address'] = $ip;
        }
        if ($userAgent !== null && $userAgent !== '') {
            $userData['client_user_agent'] = $userAgent;
        }
        if ($fbc !== null && $fbc !== '') {
            $userData['fbc'] = $fbc;
        }
        if ($fbp !== null && $fbp !== '') {
            $userData['fbp'] = $fbp;
        }

        $eventTime = $order->created_at
            ? Carbon::parse($order->created_at)->timestamp
            : now()->timestamp;

        $customData = [
            'value' => $totalValue,
            'currency' => $currency,
            'content_type' => 'product',
            'order_id' => (string) ($order->order_no ?? $order->id),
        ];
        if ($contents !== []) {
            $customData['contents'] = $contents;
        }

        $event = [
            'event_name' => 'Purchase',
            'event_time' => $eventTime,
            'event_id' => self::purchaseEventIdForOrder($order),
            'action_source' => 'website',
            'user_data' => $userData,
            'custom_data' => $customData,
        ];
        if ($eventSourceUrl !== null && $eventSourceUrl !== '') {
            $event['event_source_url'] = $eventSourceUrl;
        }

        $url = sprintf(
            'https://graph.facebook.com/%s/%s/events',
            rawurlencode($version),
            rawurlencode($pixelId)
        );

        try {
            $response = Http::timeout(25)
                ->asForm()
                ->post($url, [
                    'data' => json_encode([$event], JSON_THROW_ON_ERROR),
                    'access_token' => (string) $token,
                ]);
        } catch (\Throwable $e) {
            Log::warning('Meta CAPI Purchase HTTP exception', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }

        if (! $response->successful()) {
            Log::warning('Meta CAPI Purchase HTTP error', [
                'order_id' => $order->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            if ($response->serverError()) {
                throw new \RuntimeException('Meta CAPI HTTP '.$response->status());
            }

            return false;
        }

        $json = $response->json();
        if (isset($json['error'])) {
            Log::warning('Meta CAPI Purchase rejected', [
                'order_id' => $order->id,
                'response' => $json,
            ]);

            return false;
        }

        $received = (int) ($json['events_received'] ?? 0);
        if ($received < 1) {
            Log::warning('Meta CAPI Purchase not recorded', [
                'order_id' => $order->id,
                'response' => $json,
            ]);

            return false;
        }

        Cache::put($cacheKey, 1, now()->addDays(90));

        Log::info('Meta CAPI Purchase succeeded', [
            'order_id' => $order->id,
            'event_id' => self::purchaseEventIdForOrder($order),
            'value' => $totalValue,
            'currency' => $currency,
            'fbtrace_id' => $json['fbtrace_id'] ?? null,
        ]);

        return true;
    }
}
