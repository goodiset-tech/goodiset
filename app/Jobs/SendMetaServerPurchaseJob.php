<?php

namespace App\Jobs;

use App\Helpers\MetaPixelTracking;
use App\Models\Admins\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMetaServerPurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 4;

    public function __construct(
        public int $orderId,
        public ?string $ip,
        public ?string $userAgent,
        public ?string $fbc,
        public ?string $fbp,
        public ?string $eventSourceUrl,
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
        if (config('services.meta.access_token') === null || config('services.meta.access_token') === '') {
            return;
        }

        $order = Order::query()->whereKey($this->orderId)->first();
        if ($order === null) {
            return;
        }

        MetaPixelTracking::sendServerPurchaseForOrder(
            $order,
            $this->ip,
            $this->userAgent,
            $this->fbc,
            $this->fbp,
            $this->eventSourceUrl
        );
    }
}
