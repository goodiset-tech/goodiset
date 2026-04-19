<?php

namespace App\Jobs;

use App\Helpers\TikTokTracking;
use App\Models\Admins\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTikTokServerPurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 4;

    public function __construct(
        public int $orderId,
        public ?string $ip,
        public ?string $userAgent,
        public ?string $pageUrl,
        public ?string $referrer,
    ) {}

    /**
     * @return list<int>
     */
    public function backoff(): array
    {
        return [30, 120, 600];
    }

    public function handle(): void
    {
        if (config('services.tiktok.access_token') === null || config('services.tiktok.access_token') === '') {
            return;
        }

        $order = Order::query()->whereKey($this->orderId)->first();
        if ($order === null) {
            return;
        }

        TikTokTracking::sendServerCompletePaymentForOrder(
            $order,
            $this->ip,
            $this->userAgent,
            $this->pageUrl,
            $this->referrer
        );
    }
}
