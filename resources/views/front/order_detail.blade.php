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
                                if($product){
                    ?>
                    <div class="item">
                        @if (!empty($product->image_one))
                            <img src="{{ asset('') }}{{ $product->image_one }}" alt="">
                        @endif

                        <div class="detail">
                            <h6>{{ $product->product_name }}</h6>
                            <div class="quantity">
                                <span>{{ __('thankyou.items.qty', ['qty' => $v->qty]) }}</span>
                                @if (!empty($v->name) && $v->name == 'Free Product')
                                    <p>{{ __('thankyou.items.free_product') }}</p>
                                @else
                                    <p>{{ $v->qty * $product->discount_price }} <span
                                            class="icon-aed">{{ getSetting('currency') }}</span></p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php } } }?>

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
                                <p>{{ $value->qty * $value->package_price }} <span
                                        class="icon-aed">{{ getSetting('currency') }}</span></p>
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
@endsection
