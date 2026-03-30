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

    <!-- TikTok Purchase Event -->
    <script>
        @php
            use App\Helpers\TikTokTracking;
            $currency = 'aed';
            $totalValue = $order->amount ?? 0;
            $purchaseContents = [];
            
            // Debug: Log what data we have
            \Log::info('TikTok Purchase Tracking Debug', [
                'order_id' => $order->id ?? 'N/A',
                'email_field' => $order->email ?? 'MISSING',
                'phone_field' => $order->phone ?? 'MISSING',
            ]);
            
            // Get order email and phone - use direct field access
            $userEmail = trim($order->email ?? '');
            $userPhone = trim($order->phone ?? '');
            
            // Hash the data
            $hashedEmail = !empty($userEmail) ? TikTokTracking::hashEmail($userEmail) : '';
            $hashedPhone = !empty($userPhone) ? TikTokTracking::hashPhoneNumber($userPhone) : '';
            
            $products = json_decode($order->product_detail);
            if ($products) {
                foreach ($products as $product) {
                    if ($product->id != null) {
                        $purchaseContents[] = [
                            'content_id' => $product->id,
                            'content_type' => 'product',
                            'content_name' => $product->name ?? '',
                            'quantity' => $product->qty ?? 1,
                            'price' => $product->price ?? 0
                        ];
                    }
                }
            }
            $eventId = TikTokTracking::generateEventId();
        @endphp

        @if (!empty($purchaseContents) && $totalValue > 0)
            function trackTikTokPurchase() {
                try {
                    console.log("🔍 TikTok pixel check - ttq defined:", typeof ttq !== 'undefined');
                    
                    if (typeof ttq !== 'undefined') {
                        const tiktokPayload = {
                            "contents": {!! json_encode($purchaseContents) !!},
                            "value": {{ $totalValue }},
                            "currency": "{{ $currency }}"
                        };
                        
                        @if (!empty($hashedEmail))
                        if (!tiktokPayload.user_data) tiktokPayload.user_data = {};
                        tiktokPayload.user_data.em = "{{ $hashedEmail }}";
                        console.log("📧 Email hashed and added:", "{{ $hashedEmail }}".substring(0, 10) + "...");
                        @else
                        console.warn("⚠️ No email available for TikTok tracking");
                        @endif
                        
                        @if (!empty($hashedPhone))
                        if (!tiktokPayload.user_data) tiktokPayload.user_data = {};
                        tiktokPayload.user_data.ph = "{{ $hashedPhone }}";
                        console.log("📱 Phone hashed and added:", "{{ $hashedPhone }}".substring(0, 10) + "...");
                        @else
                        console.warn("⚠️ No phone available for TikTok tracking");
                        @endif
                        
                        const tiktokOptions = {
                            "event_id": "{{ $eventId }}"
                        };
                        
                        console.log("📊 TikTok Purchase Event Payload:", tiktokPayload);
                        console.log("🎯 TikTok Event Options:", tiktokOptions);
                        
                        ttq.track('Purchase', tiktokPayload, tiktokOptions);
                        console.log("✅ TikTok Purchase tracked successfully with {{ count($purchaseContents) }} items, Total: {{ $totalValue }} {{ strtoupper($currency) }}");
                    } else {
                        console.warn("⚠️ TikTok ttq is NOT defined yet - retrying in 500ms");
                        setTimeout(trackTikTokPurchase, 500);
                    }
                } catch (e) {
                    console.error("❌ Error tracking TikTok Purchase event:", e);
                }
            }

            // Wait for DOM to be ready, then track
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', trackTikTokPurchase);
            } else {
                trackTikTokPurchase();
            }
        @else
            console.log("ℹ️ No purchase data to track");
        @endif
    </script>
@endsection
