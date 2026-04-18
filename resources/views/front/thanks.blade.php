@extends('layout.app')
@section('content')
    <!-- Page Header Start -->
    @php
        use App\Models\Admins\Product;
        use App\Models\BoxCustomize;
        use App\Models\BoxSize;
        use App\Models\PackageType;
    @endphp
    <div class="container">
        <div class="thanks_container">
            <h1>{{ __('thankyou.title') }}</h1>
            <p>{{ __('thankyou.subtitle') }}</p>

            <div class="order_detail_card">
                <div class="order_detail_info">
                    <div class="order_summary">
                        <h3>{{ __('thankyou.order_summary.title') }}</h3>
                        <ul>
                            <li>{{ __('thankyou.order_summary.order_no', ['no' => $order->order_no]) }}</li>
                            <li>
                                {{ __('thankyou.order_summary.placed_on', [
                                    'date' => \Carbon\Carbon::parse($order->created_at)->locale(app()->getLocale())->translatedFormat('F d, Y'),
                                    'time' => \Carbon\Carbon::parse($order->created_at)->setTimezone('Asia/Dubai')->format('h:i A'),
                                ]) }}
                            </li>
                            <li>
                                {!! __('thankyou.order_summary.total_line', [
                                    'currency' => '<span class="icon-aed">' . getSetting('currency') . '</span>',
                                    'amount' => $order->amount,
                                    'shipping' => $order->shipping_fee,
                                ]) !!}
                            </li>
                        </ul>
                    </div>

                    <div class="shippment_detail">
                        <h3>{{ __('thankyou.shipment.title') }}</h3>

                        <div class="billing_info">
                            <h5>{{ __('thankyou.shipment.billing_title') }}</h5>
                            <ul>
                                <li>{{ __('thankyou.labels.name') }}: {{ $order->customer_name }}</li>
                                <li>{{ __('thankyou.labels.address') }}: {{ $order->address }}</li>
                                <li>
                                    {{ __('thankyou.labels.payment_method') }}:
                                    @php
                                        $pmKey = 'thankyou.payment.methods.' . $order->payment_method;
                                        $label = \Illuminate\Support\Facades\Lang::has($pmKey)
                                            ? __($pmKey)
                                            : ucfirst(str_replace('_', ' ', $order->payment_method));
                                    @endphp
                                    {{ $label }}
                                </li>
                            </ul>
                        </div>

                        <div class="Shipping_info">
                            <h5>{{ __('thankyou.shipment.shipping_title') }}</h5>
                            <ul>
                                <li>
                                    {{ __('thankyou.shipment.expected_delivery_time') }}:
                                    {{ get_shipping_time($order->city, $order->country) }}
                                </li>
                                <li>
                                    {{ __('thankyou.shipment.shipping_address') }}:
                                    {{ __('thankyou.shipment.same_as_billing') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <h2>{{ __('thankyou.items.title') }}</h2>

                <div class="ordered_items">
                    <?php
                        $pro = json_decode($order->product_detail);
                        foreach ($pro as $v) {
                            if ($v->id != null) {
                                $product = Product::where(['id' => $v->id])->first();
                    ?>
                    <div class="item">
                        <img src="{{ asset('') }}{{ $product->image_one }}" alt="">
                        <div class="detail">
                            <h6>{{ $product->product_name }}</h6>
                            <div class="quantity">
                                <span>{{ __('thankyou.items.qty', ['qty' => $v->qty]) }}</span>
                                @if ($v->name == 'Free Product')
                                    <p>{{ __('thankyou.items.free_product') }}</p>
                                @else
                                    <p><span
                                            class="icon-aed">{!! getSetting('currency') !!}</span>{{ $v->qty * $product->discount_price }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php } } ?>

                    <?php
                        $pack = json_decode($order->package_detail);
                        foreach ($pack as $value) {
                            $package = BoxCustomize::where('package_id', $value->package_type)
                                        ->where('size_id', $value->package_size)
                                        ->first();
                            if ($package) {
                                $box_size    = BoxSize::where('id', $value->package_size)->first();
                                $PackageType = PackageType::where('id', $value->package_type)->first();
                    ?>
                    <div class="item">
                        <img src="{{ asset('') }}{{ $package->image }}" alt="">
                        <div class="detail">
                            <h6>{{ $PackageType->name }}</h6>
                            <span>{{ $box_size->name }}</span>
                            <div class="quantity">
                                <span>{{ __('thankyou.items.qty', ['qty' => $value->qty]) }}</span>
                                <p>{{ $value->qty * $value->package_price }} {{ getSetting('currency') }}</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php } } ?>
                </div>

                <div class="continue_shipping">
                    <p>
                        {{ __('thankyou.cta.need_help') }}
                        <a href="{{ url('/') }}/contact-us">{{ __('thankyou.cta.contact_us') }}</a>
                    </p>

                    <a href="{{ url('/') }}">
                        <button class="btn btn-sm">{{ __('thankyou.cta.continue_shopping') }}</button>
                    </a>

                    @if (isset($order->dstatus) && $order->dstatus >= 1 && $order->track_no != '')
                        <p>{{ __('thankyou.tracking.id', ['no' => $order->track_no]) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @isset($order)
        <!-- TikTok CompletePayment (purchase) + advanced matching -->
        <script>
            @php
                $currencyIso = strtoupper(pixelCurrency());
                $totalValue = (float) ($order->amount ?? 0);
                $purchaseContents = [];

                $emailPlain = strtolower(trim((string) ($order->email ?? '')));
                $externalRaw = null;
                if (isset($order->user_id) && $order->user_id !== null && (string) $order->user_id !== '') {
                    $externalRaw = (string) $order->user_id;
                } elseif (isset($order->uid) && (int) $order->uid > 0) {
                    $externalRaw = (string) $order->uid;
                } else {
                    $externalRaw = (string) $order->id;
                }

                $hashedEmail = $emailPlain !== '' ? \App\Helpers\TikTokTracking::hashEmail($emailPlain) : '';
                $hashedPhone = \App\Helpers\TikTokTracking::hashPhoneNumber($order->phone ?? null, $order->country ?? null);
                $hashedExternalId = $externalRaw !== '' ? \App\Helpers\TikTokTracking::hashExternalId($externalRaw) : '';

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

                if ($purchaseContents === [] && $totalValue > 0) {
                    $purchaseContents[] = [
                        'content_id' => 'order_'.(string) ($order->order_no ?? $order->id),
                        'content_type' => 'product',
                        'content_name' => 'Order',
                        'quantity' => 1,
                        'price' => $totalValue,
                    ];
                }

                $eventId = \App\Helpers\TikTokTracking::generateEventId();
            @endphp

            @if ($totalValue > 0)
                (function() {
                    try {
                        if (typeof loadThirdPartyScripts === 'function') {
                            loadThirdPartyScripts();
                        }
                    } catch (e) {}

                    var contents = {!! json_encode($purchaseContents) !!};
                    var payload = {
                        contents: contents,
                        value: {{ json_encode($totalValue) }},
                        currency: @json($currencyIso)
                    };
                    @if ($hashedEmail !== '' || $hashedPhone !== '' || $hashedExternalId !== '')
                        payload.user_data = {};
                        @if ($hashedEmail !== '')
                            payload.user_data.em = @json($hashedEmail);
                        @endif
                        @if ($hashedPhone !== '')
                            payload.user_data.ph = @json($hashedPhone);
                        @endif
                        @if ($hashedExternalId !== '')
                            payload.user_data.external_id = @json($hashedExternalId);
                        @endif
                    @endif
                    var options = {
                        event_id: @json($eventId)
                    };

                    var purchaseSent = false;
                    var purchaseScheduleStarted = false;

                    function runCompletePayment() {
                        if (purchaseSent) {
                            return;
                        }
                        try {
                            @if ($hashedEmail !== '' || $hashedPhone !== '' || $hashedExternalId !== '')
                                var identifyPayload = {};
                                @if ($hashedEmail !== '')
                                    identifyPayload.email = @json($hashedEmail);
                                @endif
                                @if ($hashedPhone !== '')
                                    identifyPayload.phone_number = @json($hashedPhone);
                                @endif
                                @if ($hashedExternalId !== '')
                                    identifyPayload.external_id = @json($hashedExternalId);
                                @endif
                                if (Object.keys(identifyPayload).length) {
                                    ttq.identify(identifyPayload);
                                }
                            @endif
                            ttq.track('CompletePayment', payload, options);
                            purchaseSent = true;
                        } catch (e) {
                            console.error('TikTok CompletePayment error:', e);
                            purchaseScheduleStarted = false;
                        }
                    }

                    function scheduleCompletePayment() {
                        if (typeof ttq === 'undefined') {
                            return false;
                        }
                        if (purchaseScheduleStarted) {
                            return true;
                        }
                        purchaseScheduleStarted = true;
                        try {
                            if (typeof ttq.ready === 'function') {
                                ttq.ready(runCompletePayment);
                                setTimeout(function() {
                                    if (!purchaseSent) {
                                        runCompletePayment();
                                    }
                                }, 4000);
                            } else {
                                runCompletePayment();
                            }
                        } catch (e) {
                            console.error('TikTok CompletePayment schedule error:', e);
                            purchaseScheduleStarted = false;
                            runCompletePayment();
                        }
                        return true;
                    }

                    if (!scheduleCompletePayment()) {
                        window.addEventListener('third-party-pixel-ready', function() {
                            scheduleCompletePayment();
                        }, {
                            once: true
                        });
                        var n = 0;
                        var t = setInterval(function() {
                            if (!purchaseSent) {
                                scheduleCompletePayment();
                            }
                            if (purchaseSent || ++n >= 160) {
                                clearInterval(t);
                            }
                        }, 250);
                    }
                })();
            @endif
        </script>
    @endisset
@endsection
