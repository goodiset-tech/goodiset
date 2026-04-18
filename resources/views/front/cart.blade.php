@extends('layout.app')

<?php
use App\Models\Admins\Category;
use App\Models\Admins\SubCategory;
use App\Models\Childcatagorie;
use App\Models\product;
use App\Models\Admins\Gallerie;
use App\Models\BoxCustomize;
use App\Models\PaymentMethod;
use App\Models\Admins\Rating;

?>
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @if (Session::has('cart'))
        <!-- stepper -->
        <div class="add_cart_container" id="cart_data">
            <div class="stepper_outer">
                <!-- step names for mobile  -->
                <div class="active_step_label" data-step="1" id="datam1">
                    <h1>
                        {{ __('checkout.headings.your_cart') }}
                        <span>{{ __('cart.stepper.step_n', ['n' => 1]) }}</span>
                    </h1>
                </div>
                <div class="active_step_label" data-step="2" id="datam2">
                    <h1>
                        {{ __('cart.stepper.shipping_details') }}
                        <span>{{ __('cart.stepper.step_n', ['n' => 2]) }}</span>
                    </h1>
                </div>
                <div class="active_step_label" data-step="3" id="datam3">
                    <h1>
                        {{ __('cart.stepper.payment_method') }}
                        <span>{{ __('cart.stepper.step_n', ['n' => 3]) }}</span>
                    </h1>
                </div>
                <div class="active_step_label" data-step="4" id="datam4">
                    <h1>
                        {{ __('cart.stepper.done') }}
                        <span>{{ __('cart.stepper.step_n', ['n' => 4]) }}</span>
                    </h1>
                </div>

                <!-- stepper  -->
                <div class="stepper">
                    <div class="step active" data-step="1" id="data1">
                        <div class="step-number"><span class="number">1</span> <i class="fa-solid fa-check"></i></div>
                        <p>{{ __('checkout.headings.your_cart') }}</p>
                    </div>
                    <div class="step_connector"></div>
                    <div class="step" data-step="2" id="data2">
                        <div class="step-number"><span class="number">2</span> <i class="fa-solid fa-check"></i></div>
                        <p>{{ __('cart.stepper.shipping_details') }}</p>
                    </div>
                    <div class="step_connector"></div>
                    <div class="step" data-step="3" id="data3">
                        <div class="step-number"><span class="number">3</span> <i class="fa-solid fa-check"></i></div>
                        <p>{{ __('cart.stepper.payment_method') }}</p>
                    </div>
                </div>
            </div>

            <h1 class="step_label" data-step="1"></h1>
            <div class="step_label" data-step="2">
            </div>
            <div class="step_label" data-step="3">
            </div>
            <div class="step_label" data-step="4">
            </div>

            <div class="step-content">
                <div class="content content_cart" data-step="1" id="datac1">
                    <div class="content1">
                        <div class="column" style="display:flex; flex-direction:column; width:100%; gap:16px;">
                            <div class="product-total-container"
                                style="width:100%; padding:12px 6px; background-color:#FAFAFA; border-radius:8px;">
                                <span>{{ __('cart.product.header.product') }}</span>
                                <span>{{ __('cart.product.header.total') }}</span>
                            </div>

                            <div class="added_products">
                                @if (count(App\Helpers\Cart::products()) > 0)
                                    @foreach (collect(App\Helpers\Cart::products())->reverse() as $product)
                                        <div class="product" id="product-row-{{ $product->id }}">
                                            <img src="{{ asset('') }}{{ $product->image_one }}"
                                                title="{{ $product->product_name }}" alt="{{ $product->product_name }}">
                                            <div class="detail">
                                                <div class="info">
                                                    <h1>{{ $product->product_name }}</h1>
                                                </div>
                                                <div class="operations">
                                                    @if ($product->name == 'Free Product')
                                                        <h3>{{ __('cart.product.free_product') }}</h3>
                                                    @else
                                                        <h3>
                                                            @php
                                                                $discount_price = $product->discount_price;
                                                                $selling_price = $product->selling_price;
                                                                if ($selling_price > 0) {
                                                                    $discount_percentage = round(
                                                                        (($selling_price - $discount_price) /
                                                                            $selling_price) *
                                                                            100,
                                                                    );
                                                                } else {
                                                                    $discount_percentage = 0;
                                                                }
                                                            @endphp
                                                            <span class="icon-aed">{{ getSetting('currency') }}</span>
                                                            <span>{{ $product->discount_price }}</span> &nbsp;
                                                            @if ($selling_price > 0)
                                                                {{-- <del><span
                                                                        class="icon-aed">{{ getSetting('currency') }}</span>
                                                                    <span>{{ $product->selling_price }}</span></del> --}}
                                                                &nbsp;
                                                                <span style="color: #e92827;">{{ $discount_percentage }}%
                                                                    Off</span>
                                                            @endif
                                                        </h3>
                                                    @endif

                                                    @if ($product->name != 'Free Product')
                                                        <div class="quantity-controls"
                                                            data-qty-grams="{{ (int) $product->format === 1 ? '1' : '0' }}"
                                                            data-product-qty-max="{{ (int) $product->product_quantity }}">
                                                            <div class="button_spin_overlay"
                                                                id="button_loader{{ $product->id }}" style="display:none">
                                                                <div class="loader_dots"></div>
                                                            </div>

                                                            <button class="del_btn ion-close-cart1"
                                                                productId="{{ $product->id }}">
                                                                <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                                                                <span class="sr-only">Delete</span>
                                                            </button>

                                                            <button class="quantity-btn minus1 decrement"
                                                                productId="{{ $product->id }}"
                                                                productprice="{{ $product->price }}"
                                                                id="minus">-</button>

                                                            <input type="hidden"
                                                                class="form-control form-control-sm bg-secondary text-center"
                                                                id="spec{{ $product->id }}" name="qty"
                                                                value="{{ $product['qty'] }}">

                                                            <span id="quantity{{ $product->id }}" class="quantity_cart">
                                                                @if ($product->format == 1)
                                                                    {{ $product['qty'] * 100 }} g
                                                                @else
                                                                    {{ $product['qty'] }}
                                                                @endif
                                                            </span>

                                                            <button class="quantity-btn plus1 increment"
                                                                productId="{{ $product->id }}"
                                                                productprice="{{ $product->price }}"
                                                                id="plus">+</button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <hr id="hr{{ $product->id }}"> -->
                                    @endforeach
                                @endif

                                @if (count(App\Helpers\Cart::package()) > 0)
                                    @foreach (App\Helpers\Cart::package() as $product)
                                        @if ($product['package_type'] != null)
                                            @php
                                                $boxes = BoxCustomize::where('package_id', $product['package_type'])
                                                    ->where('size_id', $product['package_size'])
                                                    ->first();
                                            @endphp
                                            <div class="product" id="box-row{{ $boxes->id }}">
                                                <img src="{{ asset('') }}{{ $boxes->image }}"
                                                    title="{{ $product['package_name'] }}"
                                                    alt="{{ $product['package_name'] }}">
                                                <div class="detail">
                                                    <div class="info">
                                                        <h1>{{ $product['package_name'] }}</h1>
                                                        <h3>{{ $boxes->price }} {{ getSetting('currency') }}</h3>
                                                    </div>
                                                    <div class="operations">
                                                        <div class="quantity-controls" data-qty-grams="0">
                                                            <div class="button_spin_overlay"
                                                                id="button_loader{{ $boxes->id }}"
                                                                style="display:none">
                                                                <div class="loader_dots"></div>
                                                            </div>

                                                            <button class="del_btn ion-close-cart1"
                                                                boxId="{{ $boxes->id }}">
                                                                <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                                                                <span class="sr-only">Delete</span>
                                                            </button>

                                                            <button class="quantity-btn minus decrement"
                                                                boxId="{{ $boxes->id }}"
                                                                productprice="{{ $boxes->price }}"
                                                                id="minus">-</button>

                                                            <input type="hidden"
                                                                class="form-control form-control-sm bg-secondary text-center"
                                                                id="spec{{ $boxes->id }}" name="qty"
                                                                value="{{ $product['qty'] }}">

                                                            <span id="quantity{{ $boxes->id }}" class="quantity_cart">
                                                                {{ $product['qty'] }}
                                                            </span>

                                                            <button class="quantity-btn plus increment"
                                                                boxId="{{ $boxes->id }}"
                                                                productprice="{{ $boxes->price }}"
                                                                id="plus">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr id="hr{{ $boxes->id }}">
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="column"
                            style="display:flex; flex-direction:column; max-width:390px; width:100%; gap:12px; position:sticky; top:142px;">
                            <div class="free-shipping summary_card">
                                <div class="min-order"
                                    style="flex-direction:column; align-items:flex-end !important; gap:6px !important;">
                                    <h1 style="align-self:flex-start;">{{ __('cart.free_shipping.title') }}</h1>

                                    <div class="free_shipping_text"
                                        style="border:1px solid #e92827; background-color:#fff5f5; padding:10px; border-radius:8px; display:none; gap:4px;">
                                        <p style="text-align:left; font-weight:600; font-size:12px;">
                                            {!! __('cart.free_shipping.almost_there', [
                                                'currency' => '<span class="icon-aed">' . getSetting('currency') . '</span>',
                                                'amount' => '<span class="pending_amount"></span>',
                                            ]) !!}
                                        </p>
                                    </div>

                                    <hr>

                                    <div class="content"
                                        style="align-items:center; gap:5px; flex-direction:row; width:60%">
                                        <span
                                            class="min_shipping icon-aed">{{ __('cart.free_shipping.min_order') }}</span>
                                        <span
                                            class="max_free_shipping icon-aed">{{ __('cart.free_shipping.free_shipping') }}</span>
                                    </div>

                                    <div class="slider" style="align-items:center; gap:0px; width:100%">
                                        <div style="display:flex !important; gap:0px; align-items:center;"
                                            id="rider-stepper">
                                            <div style="display:flex !important; gap:0px; align-items:center; width:100%">
                                                <div class="connector"
                                                    style="background:#e92827; border-radius:0px; border-top-left-radius:8px; border-bottom-left-radius:8px; width:100%; height:8px">
                                                </div>
                                            </div>
                                            <img src="{{ asset('') }}front/assets/images/rider.gif" width="24"
                                                height="24" title="{{ __('cart.alt.rider') }}"
                                                alt="{{ __('cart.alt.rider') }}">
                                        </div>
                                        <div class="candy-loading-bar animate" style="width:100%;"><span></span></div>
                                    </div>

                                    <div class="content" style="flex-direction:row; width:70%">
                                        <span>{{ __('cart.free_shipping.min_order') }}</span>
                                        <span>{{ __('cart.free_shipping.free_shipping') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="summary_card">
                                <h1>{{ __('cart.summary.title') }}</h1>
                                <hr>
                                <div class="coupon-form">
                                    <form id="applyCouponForm">
                                        @csrf
                                        <input type="text" id="myInput" name="coupon_code"
                                            placeholder="{{ __('cart.coupon.placeholder') }}" required>
                                        <button id="myButton" type="submit" class="btn btn-primary"
                                            style="opacity:0; transition:opacity .3s ease;">
                                            {{ __('cart.coupon.apply') }}
                                        </button>
                                    </form>
                                </div>
                                <p class="coupon-error" id="coupon_error"></p>
                                <p class="" id="coupon_error_1"></p>

                                <div class="sutotal">
                                    <h2>{{ __('cart.totals.subtotal') }}</h2>
                                    <span></span>
                                    <span class="price cartTotal1 icon-aed" id="cartTotal1">
                                        {{ getSetting('currency') }} {{ Session::get('cart')['amount'] }}
                                    </span>
                                </div>

                                <div class="shipping">
                                    <h2>{{ __('cart.totals.shipping') }}</h2>
                                    <span></span>
                                    <span class="price shipping_fee icon-aed"></span>
                                </div>

                                <div class="shipping">
                                    @if (getSetting('tax_value') > 0)
                                        <h2>{{ __('cart.totals.vat_with_rate', ['percent' => getSetting('tax_value')]) }}
                                        </h2>
                                        <span></span>
                                        <span class="vat icon-aed">
                                            {{ getSetting('currency') }}
                                            {{ (Session::get('cart')['amount'] * getSetting('tax_value')) / 100 }}
                                        </span>
                                    @else
                                        <h2>{{ __('cart.totals.vat_label') }}</h2>
                                        <span></span>
                                        <span class="vat ">{{ __('cart.totals.vat_included') }}</span>
                                    @endif
                                </div>

                                <div class="shipping">
                                    <h2>{{ __('cart.totals.discount') }}</h2>
                                    <span></span>
                                    <span class="price discount icon-aed">
                                        {{ getSetting('currency') }} {{ Session::get('cart')['discount'] ?? 0 }}
                                    </span>
                                </div>

                                <hr>
                                <div class="total">
                                    <h2>{{ __('cart.totals.total') }}</h2>
                                    <span></span>
                                    <span class="price cartTotal icon-aed" id="cartTotal">
                                        {{ getSetting('currency') }}
                                        {{ Session::get('cart')['amount'] - Session::get('cart')['discount'] + (Session::get('cart')['amount'] * getSetting('tax_value')) / 100 }}
                                    </span>
                                </div>

                                @php
                                    $total =
                                        Session::get('cart')['amount'] -
                                        Session::get('cart')['discount'] +
                                        getSetting('shipping') +
                                        (Session::get('cart')['amount'] * getSetting('tax_value')) / 100;
                                @endphp

                                @if ($total < getSetting('min_order_value'))
                                    <p id="show_meaaage" style="color:#e92827;">
                                        {!! __('cart.min_order.message', [
                                            'currency' => '<span class="icon-aed">' . getSetting('currency') . '</span>',
                                            'amount' => getSetting('min_order_value'),
                                        ]) !!}
                                    </p>
                                    <a href="{{ url('/') }}/checkout">
                                        <button id="next_btn1" class="checkout checkout1" style="width:100%;" disabled>
                                            {{ __('cart.cta.proceed_checkout') }}
                                        </button>
                                    </a>
                                @else
                                    <p id="show_meaaage" style="display:none; color:#e92827;">
                                        {!! __('cart.min_order.message', [
                                            'currency' => '<span class="icon-aed">' . getSetting('currency') . '</span>',
                                            'amount' => getSetting('min_order_value'),
                                        ]) !!}
                                    </p>
                                    <a href="{{ url('/') }}/checkout">
                                        <button id="next_btn1" onclick="InitiateCheckout()" class="checkout"
                                            style="width:100%;">
                                            {{ __('cart.cta.proceed_checkout') }}
                                        </button>
                                    </a>
                                @endif

                                <button class="continue_shopping">
                                    <a href="{{ url('/') }}">{{ __('cart.cta.continue_shopping') }}</a>
                                </button>

                                <div class="cards">
                                    <svg xmlns="http://www.w3.org/2000/svg" role="img"
                                        aria-labelledby="pi-american_express" viewBox="0 0 38 24" width="43"
                                        height="29">
                                        <title id="pi-american_express">American Express</title>
                                        <path fill="#000"
                                            d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3Z"
                                            opacity=".07"></path>
                                        <path fill="#006FCF"
                                            d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32Z">
                                        </path>
                                        <path fill="#FFF"
                                            d="M22.012 19.936v-8.421L37 11.528v2.326l-1.732 1.852L37 17.573v2.375h-2.766l-1.47-1.622-1.46 1.628-9.292-.02Z">
                                        </path>
                                        <path fill="#006FCF"
                                            d="M23.013 19.012v-6.57h5.572v1.513h-3.768v1.028h3.678v1.488h-3.678v1.01h3.768v1.531h-5.572Z">
                                        </path>
                                        <path fill="#006FCF"
                                            d="m28.557 19.012 3.083-3.289-3.083-3.282h2.386l1.884 2.083 1.89-2.082H37v.051l-3.017 3.23L37 18.92v.093h-2.307l-1.917-2.103-1.898 2.104h-2.321Z">
                                        </path>
                                        <path fill="#FFF"
                                            d="M22.71 4.04h3.614l1.269 2.881V4.04h4.46l.77 2.159.771-2.159H37v8.421H19l3.71-8.421Z">
                                        </path>
                                        <path fill="#006FCF"
                                            d="m23.395 4.955-2.916 6.566h2l.55-1.315h2.98l.55 1.315h2.05l-2.904-6.566h-2.31Zm.25 3.777.875-2.09.873 2.09h-1.748Z">
                                        </path>
                                        <path fill="#006FCF"
                                            d="M28.581 11.52V4.953l2.811.01L32.84 9l1.456-4.046H37v6.565l-1.74.016v-4.51l-1.644 4.494h-1.59L30.35 7.01v4.51h-1.768Z">
                                        </path>
                                    </svg>
                                    <svg width="43" height="29" viewBox="0 0 43 29" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M38.7177 0.887756H3.80836C3.66294 0.887756 3.51727 0.887756 3.37211 0.888527C3.24956 0.889555 3.12726 0.890839 3.00471 0.894179C2.73777 0.901373 2.46851 0.917302 2.20491 0.964576C1.94055 1.00987 1.68441 1.0943 1.44493 1.21508C0.963501 1.45994 0.572187 1.85126 0.327319 2.33269C0.206323 2.57226 0.121887 2.8286 0.0768198 3.09318C0.0290322 3.35704 0.01336 3.62604 0.00616614 3.89272C0.00303492 4.01517 0.00115073 4.13764 0.000513845 4.26012C0 4.40502 0 4.55044 0 4.69612V24.3039C0 24.4496 0 24.5948 0.000513845 24.7404C0.00128461 24.8627 0.00282615 24.9853 0.00616614 25.1078C0.01336 25.374 0.0292892 25.6433 0.0768198 25.9069C0.121795 26.1714 0.206145 26.4278 0.327062 26.6674C0.448634 26.9066 0.607321 27.1251 0.79723 27.3148C0.986815 27.5048 1.20535 27.6635 1.44467 27.785C1.68798 27.9091 1.9372 27.9879 2.20517 28.036C2.46851 28.083 2.73777 28.0989 3.00471 28.1061C3.12726 28.1089 3.24956 28.1105 3.37211 28.1113C3.51727 28.1123 3.66294 28.1123 3.80836 28.1123H38.7177C38.8629 28.1123 39.0085 28.1123 39.1537 28.1113C39.276 28.1107 39.3983 28.1089 39.5214 28.1061C39.7878 28.0989 40.057 28.083 40.3212 28.036C40.5856 27.9906 40.8417 27.906 41.0811 27.785C41.5623 27.5398 41.9535 27.1485 42.1987 26.6674C42.3228 26.424 42.4015 26.1748 42.449 25.9069C42.4968 25.6433 42.5122 25.374 42.5194 25.1078C42.5227 24.9853 42.5245 24.8627 42.525 24.7404C42.5261 24.5948 42.5261 24.4496 42.5261 24.3039V4.69637C42.5261 4.5507 42.5261 4.40528 42.525 4.25986C42.5245 4.13747 42.5227 4.01508 42.5194 3.89272C42.5122 3.62604 42.4968 3.35704 42.449 3.09318C42.4042 2.82855 42.3199 2.57218 42.1987 2.33269C41.9538 1.85134 41.5625 1.46006 41.0811 1.21508C40.8416 1.09442 40.5855 1.01008 40.3212 0.964833C40.057 0.917302 39.7878 0.90163 39.5214 0.894436C39.3988 0.891324 39.2763 0.88944 39.1537 0.888784C39.0085 0.887756 38.8629 0.887756 38.7177 0.887756Z"
                                            fill="black" />
                                        <path
                                            d="M38.7177 1.79492L39.1473 1.79569C39.2634 1.79646 39.3798 1.79775 39.4967 1.80083C39.7004 1.80648 39.9384 1.81753 40.1603 1.85735C40.353 1.89204 40.5149 1.94471 40.6701 2.02384C40.9806 2.18173 41.2329 2.4343 41.3905 2.74502C41.4691 2.89917 41.5215 3.06001 41.5562 3.2545C41.5958 3.47391 41.6068 3.71259 41.6122 3.91736C41.6155 4.03297 41.6171 4.14859 41.6173 4.26677C41.6186 4.40988 41.6186 4.55273 41.6186 4.69609V24.3039C41.6186 24.4473 41.6186 24.5901 41.6176 24.736C41.6171 24.8517 41.6155 24.9673 41.6125 25.0829C41.6068 25.2874 41.5958 25.5261 41.5557 25.7481C41.5265 25.9246 41.4707 26.0957 41.39 26.2555C41.2321 26.5663 40.9794 26.8189 40.6685 26.9767C40.5144 27.0553 40.353 27.108 40.1621 27.1424C39.9358 27.1827 39.6876 27.1938 39.5008 27.1989C39.3834 27.2015 39.2665 27.2033 39.1465 27.2038C39.0039 27.2048 38.8606 27.2048 38.7177 27.2048H3.80273C3.66142 27.2048 3.52011 27.2048 3.37624 27.2038C3.26061 27.2033 3.14499 27.2017 3.02939 27.1992C2.83824 27.194 2.59006 27.1827 2.36551 27.1426C2.18797 27.1131 2.01593 27.0567 1.85526 26.9756C1.70113 26.8973 1.56046 26.795 1.43853 26.6725C1.31621 26.5504 1.21405 26.4096 1.13587 26.2555C1.05514 26.0948 0.999178 25.9229 0.969903 25.7455C0.929823 25.5238 0.918518 25.2861 0.91338 25.0831C0.910477 24.9671 0.908764 24.8511 0.908241 24.735L0.907471 24.3941V4.60617L0.907985 4.26575C0.908515 4.14952 0.910228 4.0333 0.913123 3.9171C0.918775 3.71362 0.929823 3.47597 0.97016 3.25244C0.999493 3.07539 1.05545 2.90379 1.13613 2.74348C1.21424 2.58984 1.31598 2.44956 1.4393 2.32649C1.56153 2.20407 1.70235 2.10175 1.85654 2.02333C2.01683 1.9428 2.18832 1.88685 2.36525 1.85735C2.58749 1.81753 2.82565 1.80648 3.02965 1.80083C3.14578 1.79775 3.26216 1.79646 3.37752 1.79569L3.80838 1.79492H38.7177Z"
                                            fill="white" />
                                        <path
                                            d="M11.1776 10.0781C11.5383 9.62719 11.7829 9.02162 11.7184 8.40295C11.1907 8.42916 10.5469 8.75108 10.1738 9.2025C9.83903 9.58891 9.5428 10.2197 9.61988 10.8124C10.2123 10.8638 10.8043 10.5164 11.1776 10.0781Z"
                                            fill="black" />
                                        <path
                                            d="M11.7112 10.9285C10.8505 10.8771 10.1193 11.4167 9.70849 11.4167C9.29742 11.4167 8.66821 10.9542 7.98763 10.9668C7.10202 10.9796 6.28038 11.4806 5.83076 12.2771C4.90636 13.87 5.58669 16.2337 6.48592 17.5311C6.92243 18.1735 7.4486 18.88 8.14178 18.8546C8.79693 18.8289 9.0536 18.4306 9.84954 18.4306C10.6452 18.4306 10.8765 18.8546 11.5699 18.8417C12.2888 18.8289 12.7384 18.1994 13.1749 17.5571C13.6759 16.8249 13.8807 16.1183 13.8935 16.0798C13.8807 16.0669 12.5071 15.54 12.4943 13.9599C12.4815 12.6368 13.5729 12.0073 13.6242 11.9685C13.0079 11.057 12.0449 10.9542 11.7109 10.9285"
                                            fill="black" />
                                        <path
                                            d="M20.29 9.13812C22.1598 9.13812 23.4622 10.4271 23.4622 12.3037C23.4622 14.1869 22.1331 15.4826 20.2432 15.4826H18.1729V18.7753H16.6771V9.13812H20.29ZM18.1729 14.227H19.8892C21.1918 14.227 21.9327 13.5258 21.9327 12.3103C21.9327 11.0951 21.1915 10.4004 19.8958 10.4004H18.1729V14.227Z"
                                            fill="black" />
                                        <path
                                            d="M23.8335 16.7782C23.8335 15.5426 24.7751 14.8348 26.5114 14.7279L28.3746 14.6144V14.08C28.3746 13.2989 27.8605 12.8714 26.9456 12.8714C26.1908 12.8714 25.643 13.2586 25.53 13.8528H24.1806C24.2209 12.6042 25.3961 11.696 26.9857 11.696C28.6952 11.696 29.8105 12.5908 29.8105 13.98V18.775H28.4283V17.6196H28.3949C28.0008 18.3742 27.1324 18.8482 26.1908 18.8482C24.8018 18.8482 23.8335 18.0204 23.8335 16.7782ZM28.3746 16.1572V15.6161L26.7118 15.723C25.7766 15.7831 25.2895 16.1302 25.2895 16.7378C25.2895 17.3257 25.7969 17.7064 26.5916 17.7064C27.6064 17.7064 28.3746 17.0585 28.3746 16.1572Z"
                                            fill="black" />
                                        <path
                                            d="M31.0808 21.3521V20.1969C31.1743 20.2101 31.4012 20.2234 31.5214 20.2234C32.1825 20.2234 32.5566 19.9434 32.7837 19.2217L32.9173 18.7944L30.3861 11.7822H31.9487L33.712 17.472H33.7454L35.5084 11.7822H37.0311L34.4064 19.1482C33.8052 20.838 33.1174 21.3924 31.6617 21.3924C31.5482 21.3924 31.1808 21.3791 31.0808 21.3521Z"
                                            fill="black" />
                                    </svg>
                                    <svg width="43" height="29" viewBox="0 0 43 29" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <path
                                            d="M39.0502 0.887756H4.14088C3.99546 0.887756 3.84979 0.887756 3.70463 0.888527C3.58207 0.889555 3.45978 0.890839 3.33723 0.894179C3.07029 0.901373 2.80103 0.917302 2.53743 0.964576C2.27307 1.00987 2.01693 1.0943 1.77745 1.21508C1.29602 1.45994 0.904706 1.85126 0.659839 2.33269C0.538843 2.57226 0.454407 2.8286 0.409339 3.09318C0.361552 3.35704 0.345879 3.62604 0.338686 3.89272C0.335554 4.01517 0.33367 4.13764 0.333033 4.26012C0.33252 4.40502 0.33252 4.55044 0.33252 4.69612V24.3039C0.33252 24.4496 0.33252 24.5948 0.333033 24.7404C0.333804 24.8627 0.335346 24.9853 0.338686 25.1078C0.345879 25.374 0.361809 25.6433 0.409339 25.9069C0.454314 26.1714 0.538664 26.4278 0.659582 26.6674C0.781153 26.9066 0.93984 27.1251 1.12975 27.3148C1.31933 27.5048 1.53787 27.6635 1.77719 27.785C2.0205 27.9091 2.26971 27.9879 2.53768 28.036C2.80103 28.083 3.07029 28.0989 3.33723 28.1061C3.45978 28.1089 3.58207 28.1105 3.70463 28.1113C3.84979 28.1123 3.99546 28.1123 4.14088 28.1123H39.0502C39.1954 28.1123 39.3411 28.1123 39.4862 28.1113C39.6085 28.1107 39.7308 28.1089 39.8539 28.1061C40.1203 28.0989 40.3896 28.083 40.6537 28.036C40.9181 27.9906 41.1742 27.906 41.4137 27.785C41.8948 27.5398 42.2861 27.1485 42.5313 26.6674C42.6554 26.424 42.734 26.1748 42.7815 25.9069C42.8293 25.6433 42.8447 25.374 42.8519 25.1078C42.8552 24.9853 42.857 24.8627 42.8576 24.7404C42.8586 24.5948 42.8586 24.4496 42.8586 24.3039V4.69637C42.8586 4.5507 42.8586 4.40528 42.8576 4.25986C42.8571 4.13747 42.8552 4.01508 42.8519 3.89272C42.8447 3.62604 42.8293 3.35704 42.7815 3.09318C42.7368 2.82855 42.6524 2.57218 42.5313 2.33269C42.2863 1.85134 41.895 1.46006 41.4137 1.21508C41.1741 1.09442 40.918 1.01008 40.6537 0.964833C40.3896 0.917302 40.1203 0.90163 39.8539 0.894436C39.7313 0.891324 39.6088 0.88944 39.4862 0.888784C39.3411 0.887756 39.1954 0.887756 39.0502 0.887756Z"
                                            fill="#E9E9E9"></path>
                                        <path
                                            d="M39.0502 1.79492L39.4798 1.79569C39.5959 1.79646 39.7123 1.79775 39.8292 1.80083C40.033 1.80648 40.2709 1.81753 40.4929 1.85735C40.6855 1.89204 40.8474 1.94471 41.0026 2.02384C41.3131 2.18173 41.5654 2.4343 41.723 2.74502C41.8016 2.89917 41.854 3.06001 41.8887 3.2545C41.9283 3.47391 41.9393 3.71259 41.9447 3.91736C41.9481 4.03297 41.9496 4.14859 41.9499 4.26677C41.9511 4.40988 41.9511 4.55273 41.9511 4.69609V24.3039C41.9511 24.4473 41.9511 24.5901 41.9501 24.736C41.9496 24.8517 41.9481 24.9673 41.945 25.0829C41.9393 25.2874 41.9283 25.5261 41.8882 25.7481C41.8591 25.9246 41.8032 26.0957 41.7225 26.2555C41.5646 26.5663 41.3119 26.8189 41.001 26.9767C40.8469 27.0553 40.6856 27.108 40.4947 27.1424C40.2683 27.1827 40.0201 27.1938 39.8333 27.1989C39.7159 27.2015 39.599 27.2033 39.479 27.2038C39.3364 27.2048 39.1931 27.2048 39.0502 27.2048H4.13525C3.99394 27.2048 3.85263 27.2048 3.70876 27.2038C3.59313 27.2033 3.47751 27.2017 3.36191 27.1992C3.17076 27.194 2.92258 27.1827 2.69802 27.1426C2.52049 27.1131 2.34845 27.0567 2.18778 26.9756C2.03365 26.8973 1.89298 26.795 1.77105 26.6725C1.64873 26.5504 1.54657 26.4096 1.46839 26.2555C1.38766 26.0948 1.3317 25.9229 1.30242 25.7455C1.26234 25.5238 1.25104 25.2861 1.2459 25.0831C1.243 24.9671 1.24128 24.8511 1.24076 24.735L1.23999 24.3941V4.60617L1.2405 4.26575C1.24103 4.14952 1.24275 4.0333 1.24564 3.9171C1.25129 3.71362 1.26234 3.47597 1.30268 3.25244C1.33201 3.07539 1.38797 2.90379 1.46865 2.74348C1.54676 2.58984 1.6485 2.44956 1.77182 2.32649C1.89405 2.20407 2.03487 2.10175 2.18906 2.02333C2.34935 1.9428 2.52083 1.88685 2.69777 1.85735C2.92001 1.81753 3.15817 1.80648 3.36217 1.80083C3.4783 1.79775 3.59468 1.79646 3.71004 1.79569L4.1409 1.79492H39.0502Z"
                                            fill="white"></path>
                                        <rect x="6.00049" y="8" width="32" height="12.72"
                                            fill="url(#pattern0_300_17073)"></rect>
                                        <defs>
                                            <pattern id="pattern0_300_17073" patternContentUnits="objectBoundingBox"
                                                width="1" height="1">
                                                <use xlink:href="#image0_300_17073" transform="scale(0.0025 0.00628931)">
                                                </use>
                                            </pattern>
                                            <image id="image0_300_17073" width="400" height="159"
                                                preserveAspectRatio="none"
                                                xlink:href="data:image/png;base64,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">
                                            </image>
                                        </defs>
                                    </svg>
                                    <svg width="44" height="29" viewBox="0 0 44 29" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_300_16886)">
                                            <path opacity="0.07"
                                                d="M40.3677 0.887695H4.06802C2.13959 0.887695 0.664917 2.36237 0.664917 4.29079V24.7094C0.664917 26.6378 2.25303 28.1125 4.06802 28.1125H40.3677C42.2962 28.1125 43.7708 26.6378 43.7708 24.7094V4.29079C43.7708 2.36237 42.1827 0.887695 40.3677 0.887695Z"
                                                fill="black" />
                                            <path
                                                d="M40.3681 2.02197C41.6159 2.02197 42.6369 3.0429 42.6369 4.2907V24.7093C42.6369 25.9571 41.6159 26.978 40.3681 26.978H4.06842C2.82061 26.978 1.79968 25.9571 1.79968 24.7093V4.2907C1.79968 3.0429 2.82061 2.02197 4.06842 2.02197H40.3681Z"
                                                fill="white" />
                                            <path
                                                d="M17.6797 22.4407C22.0652 22.4407 25.6203 18.8856 25.6203 14.5001C25.6203 10.1147 22.0652 6.55957 17.6797 6.55957C13.2942 6.55957 9.73914 10.1147 9.73914 14.5001C9.73914 18.8856 13.2942 22.4407 17.6797 22.4407Z"
                                                fill="#EB001B" />
                                            <path
                                                d="M26.7559 22.4407C31.1413 22.4407 34.6964 18.8856 34.6964 14.5001C34.6964 10.1147 31.1413 6.55957 26.7559 6.55957C22.3704 6.55957 18.8153 10.1147 18.8153 14.5001C18.8153 18.8856 22.3704 22.4407 26.7559 22.4407Z"
                                                fill="#F79E1B" />
                                            <path
                                                d="M25.6215 14.5001C25.6215 11.7776 24.2603 9.39542 22.2184 8.03418C20.1765 9.50886 18.8153 11.891 18.8153 14.5001C18.8153 17.1091 20.1765 19.6047 22.2184 20.966C24.2603 19.6047 25.6215 17.2225 25.6215 14.5001Z"
                                                fill="#FF5F00" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_300_16886">
                                                <rect width="43.1059" height="27.2248" fill="white"
                                                    transform="translate(0.664917 0.887695)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <svg width="44" height="29" viewBox="0 0 44 29" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_300_16892)">
                                            <path opacity="0.07"
                                                d="M40.2802 0.887695H3.98049C2.05207 0.887695 0.577393 2.36237 0.577393 4.29079V24.7094C0.577393 26.6378 2.16551 28.1125 3.98049 28.1125H40.2802C42.2086 28.1125 43.6833 26.6378 43.6833 24.7094V4.29079C43.6833 2.36237 42.0952 0.887695 40.2802 0.887695Z"
                                                fill="black" />
                                            <path
                                                d="M40.2805 2.02197C41.5283 2.02197 42.5492 3.0429 42.5492 4.2907V24.7093C42.5492 25.9571 41.5283 26.978 40.2805 26.978H3.98077C2.73297 26.978 1.71204 25.9571 1.71204 24.7093V4.2907C1.71204 3.0429 2.73297 2.02197 3.98077 2.02197H40.2805Z"
                                                fill="white" />
                                            <path
                                                d="M32.6799 12.3451H32.3396C31.8858 13.4794 31.5455 14.0466 31.2052 15.7482H33.3605C33.0202 14.0466 33.0202 13.2526 32.6799 12.3451ZM35.9695 19.0378H34.0411C33.9277 19.0378 33.9277 19.0378 33.8142 18.9244L33.5874 17.9035L33.4739 17.6766H30.7515C30.638 17.6766 30.5246 17.6766 30.5246 17.9035L30.1843 18.9244C30.1843 19.0378 30.0708 19.0378 30.0708 19.0378H27.6887L27.9155 18.4706L31.2052 10.7569C31.2052 10.1898 31.5455 9.96289 32.1127 9.96289H33.8142C33.9277 9.96289 34.0411 9.96289 34.0411 10.1898L35.6292 17.5631C35.7427 18.0169 35.8561 18.3572 35.8561 18.8109C35.9695 18.9244 35.9695 18.9244 35.9695 19.0378ZM20.769 18.6975L21.2228 16.6557C21.3362 16.6557 21.4496 16.7691 21.4496 16.7691C22.2437 17.1094 23.0378 17.3363 23.8318 17.2228C24.0587 17.2228 24.399 17.1094 24.6259 16.996C25.1931 16.7691 25.1931 16.2019 24.7393 15.7482C24.5124 15.5213 24.1721 15.4078 23.8318 15.181C23.3781 14.9541 22.9243 14.7272 22.584 14.3869C21.2228 13.2526 21.6765 11.6644 22.4706 10.8704C23.1512 10.4166 23.4915 9.96289 24.399 9.96289C25.7602 9.96289 27.2349 9.96289 27.9155 10.1898H28.029C27.9155 10.8704 27.8021 11.4376 27.5752 12.1182C27.008 11.8913 26.4409 11.6644 25.8737 11.6644C25.5334 11.6644 25.1931 11.6644 24.8527 11.7779C24.6259 11.7779 24.5124 11.8913 24.399 12.0048C24.1721 12.2316 24.1721 12.5719 24.399 12.7988L24.9662 13.2526C25.4199 13.4794 25.8737 13.7063 26.214 13.9332C26.7812 14.2735 27.3484 14.8407 27.4618 15.5213C27.6887 16.5422 27.3484 17.4497 26.4409 18.1303C25.8737 18.5841 25.6468 18.8109 24.8527 18.8109C23.2646 18.8109 22.0168 18.9244 20.9959 18.5841C20.8825 18.8109 20.8825 18.8109 20.769 18.6975ZM16.7987 19.0378C16.9122 18.2438 16.9122 18.2438 17.0256 17.9035C17.5928 15.4078 18.16 12.7988 18.6137 10.3032C18.7272 10.0763 18.7272 9.96289 18.954 9.96289H20.9959C20.769 11.3241 20.5422 12.3451 20.2018 13.5929C19.8615 15.2944 19.5212 16.996 19.0675 18.6975C19.0675 18.9244 18.954 18.9244 18.7272 18.9244M6.24915 10.1898C6.24915 10.0763 6.47602 9.96289 6.58946 9.96289H10.4463C11.0135 9.96289 11.4672 10.3032 11.5807 10.8704L12.6016 15.8616C12.6016 15.975 12.6016 15.975 12.715 16.0885C12.715 15.975 12.8285 15.975 12.8285 15.975L15.2106 10.1898C15.0972 10.0763 15.2106 9.96289 15.3241 9.96289H17.7062C17.7062 10.0763 17.7062 10.0763 17.5928 10.1898L14.0763 18.4706C13.9628 18.6975 13.9628 18.8109 13.8494 18.9244C13.736 19.0378 13.5091 18.9244 13.2822 18.9244H11.5807C11.4672 18.9244 11.3538 18.9244 11.3538 18.6975L9.53881 11.6644C9.31193 11.4376 8.97162 11.0973 8.51788 10.9838C7.83726 10.6435 6.58946 10.4166 6.36258 10.4166L6.24915 10.1898Z"
                                                fill="#142688" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_300_16892">
                                                <rect width="43.1059" height="27.2248" fill="white"
                                                    transform="translate(0.577271 0.887695)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="add_cart_container" @if (Session::has('cart')) style="display: none;" @endif id="cart_empty_dev">
        <div class="content" id="content">
            <div class="compelete">
                <img src="{{ asset('') }}empty_cart.jpg" title="{{ __('cart.empty.image_title') }}"
                    alt="{{ __('cart.empty.image_alt') }}">
                <div class="text_section" style="gap: 2px">
                    <h1>{{ __('cart.empty.heading') }}</h1>
                    <p style="margin-top: 16px">{{ __('cart.empty.subheading') }}</p>
                    <p>{{ __('cart.empty.cta_hint') }}</p>
                </div>
                <button class="continue_shopping">
                    <a href="{{ url('/') }}">{{ __('cart.cta.continue_shopping') }}</a>
                </button>
            </div>
        </div>
    </div>
    <!-- CONTAINER END -->

    {{-- <div class="trending_section" style="background-color: #FFFAFA; padding-bottom:0px; display:;">
        <h3 class="trending-heading">{{ __('cart.trending.title') }}</h3>

        <div class="gift_box_outer" style="background-color:#FFFAFA;">
            <div class="gift_box_section">
                <div class="gift_boxes" style="padding:20px 0px; "> --}}
    <?php
                $cate = DB::table('categories')->where('show_on_cart', 1)->get();

                foreach ($cate as $v) {
                    $searchObj = DB::table('category_conditions')
                        ->where('category_id', $v->id)
                        ->select('type', 'condition', 'condition_value')->get();
                    $pro = DB::table('products');

                    if (isset($v->is_manual) && $v->is_manual == 2) {
                        if ($searchObj->count() > 0) {
                            foreach ($searchObj as $key => $val) {
                                $method = $v->is_condition == 2 ? 'orWhere' : 'where';

                                if (trim($val->type) == 'Price') {
                                    $pro->$method('discount_price', $val->condition, intval($val->condition_value));
                                }

                                if (trim($val->type) == 'Format') {
                                    $pro->$method('format', $val->condition, intval($val->condition_value));
                                }

                                if (trim($val->type) == 'Tag') {
                                    $conditionValues = explode(',', $val->condition_value);
                                    $tagValues = array_map(fn($value) => str_replace(' ', '', trim($value)), $conditionValues);
                                    foreach ($tagValues as $tag) {
                                        $pro->$method('tags', 'LIKE', '%' . $tag . '%');
                                    }
                                }

                                if (trim($val->type) == 'Title') {
                                    $pro->$method('product_name', $val->condition, $val->condition_value);
                                }

                                if (trim($val->type) == 'Made in') {
                                    $pro->$method('country', $val->condition, intval($val->condition_value));
                                }

                                if (trim($val->type) == 'Brand') {
                                    $pro->$method('brand_id', $val->condition, intval($val->condition_value));
                                }

                                if (trim($val->type) == 'Products') {
                                    if ($val->condition_value) {
                                        $conditionValues = explode(',', $val->condition_value);
                                        $pro->whereIn('id', $conditionValues);
                                    }
                                }

                                if (trim($val->type) == 'Theme') {
                                    $pro->$method('theme_id', $val->condition, intval($val->condition_value));
                                }

                                if (trim($val->type) == 'Flavour') {
                                    $pro->$method('flavour_id', $val->condition, intval($val->condition_value));
                                }

                                if (trim($val->type) == 'Color') {
                                    $pro->$method('product_color', $val->condition, intval($val->condition_value));
                                }

                                if (trim($val->type) == 'Allergens') {
                                    $pro->$method('allergen', $val->condition, intval($val->condition_value));
                                }

                                if (trim($val->type) == 'Weight') {
                                    $pro->$method('weight', $val->condition, $val->condition_value);
                                }
                            }
                        }
                    } else {
                        $pro = $pro->whereRaw("? = ANY(string_to_array(category_id, ','))", [$v->id]);
                    }

                    $pro = $pro->where('status', 1)->limit(10)->get();
                ?>

    <section class="section bg_light_red">
        <div class="container">
            <h2 class="section_heading center red n_m_b">{{ __('cart.trending.title') }}</h2>
            <div class="c-slider js-slider">
                <button class="c-slider__arrow c-slider__arrow--prev" type="button" aria-label="Previous">
                    <svg width="16" height="28" viewBox="0 0 16 28" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2L2 14L14 26" stroke-opacity="0.4" stroke-width="4" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>

                </button>

                <div class="c-slider__track js-slider-track">
                    @foreach ($pro as $k => $v)
                        <div class="c-slider__item">
                            <x-product-card :product="$v" />
                        </div>
                    @endforeach
                </div>

                <button class="c-slider__arrow c-slider__arrow--next" type="button" aria-label="Next">
                    <svg width="16" height="28" viewBox="0 0 16 28" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 26L14 14L2 2" stroke-opacity="0.4" stroke-width="4" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </section>
    <?php } ?>
    {{-- </div>
            </div>
        </div>
    </div> --}}

    <script src="{{ asset('') }}front/addCart.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function() {
            $('#myInput').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $('#myButton').addClass('visible');
                } else {
                    $('#myButton').removeClass('visible');
                }
            });
        });
        $(document).ready(function() {
            $('.plus1').click(function() {
                id = $(this).attr('productId');
                var boxid = $(this).attr('boxId');
                price = $(this).attr('productprice');
                $('#button_loader' + id).css('display', 'flex').show();
                $('#button_loader' + boxid).css('display', 'flex').show();
                $('#loader_container_overlay').css('display', 'flex').show();
                $.ajax({
                    url: "{{ url('cart/increment') }}",
                    type: "POST",
                    data: {
                        id: id,
                        boxid: boxid,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.error) {
                            alert('Item out of stock');
                        } else {
                            qty = $('#spec' + id).val();
                            // let item = response.cart.items.find(item => item.id == id);
                            // if (item) {
                            //     // document.getElementById("quantity" + id).textContent = item.qty;
                            // } else {
                            //     console.error("Item with id " + id + " not found in the cart.");
                            // }
                            updateView(response, price);
                            setTimeout(() => {
                                $('#button_loader' + id).hide();
                                $('#button_loader' + boxid).hide();
                                $('#loader_container_overlay').hide();
                            }, 1000);
                        }
                    }
                });
            });

            $('.minus1').click(function() {
                id = $(this).attr('productId');
                var boxid = $(this).attr('boxId');
                price = $(this).attr('productprice');
                $('#button_loader' + id).css('display', 'flex').show();
                $('#button_loader' + boxid).css('display', 'flex').show();
                $('#loader_container_overlay').css('display', 'flex').show();
                $.ajax({
                    url: "{{ url('cart/decrement') }}",
                    type: "POST",
                    data: {
                        id: id,
                        boxid: boxid,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (qty > 0) {
                            $('#spec' + id).val(qty);
                            // let item = response.cart.items.find(item => item.id == id);
                            // if (item) {
                            //     // document.getElementById("quantity" + id).textContent = item.qty;
                            // } else {
                            //     console.error("Item with id " + id + " not found in the cart.");
                            // }
                        } else {
                            //   removeFromView(id,response);
                        }
                        updateView(response, price);


                        setTimeout(() => {
                            $('#loader_container_overlay').hide();
                            $('#button_loader' + id).hide();
                            $('#button_loader' + boxid).hide();
                        }, 1000);
                    }
                });
            });
            $('.plus_1').click(function() {
                id = $(this).attr('productId');
                var boxid = $(this).attr('boxId');
                price = $(this).attr('productprice');
                $('#button_loader' + id).css('display', 'flex').show();
                $('#button_loader' + boxid).css('display', 'flex').show();
                $('#loader_container_overlay').css('display', 'flex').show();
                $.ajax({
                    url: "{{ url('cart/increment') }}",
                    type: "POST",
                    data: {
                        id: id,
                        boxid: boxid,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.error) {
                            alert('Item out of stock');
                        } else {
                            qty = $('#spec' + id).val();
                            // let item = response.cart.items.find(item => item.id == id);
                            // if (item) {
                            //     // document.getElementById("quantity" + id).textContent = item.qty;
                            // } else {
                            //     console.error("Item with id " + id + " not found in the cart.");
                            // }
                            // updateView(response, price);
                            location.reload();
                            setTimeout(() => {
                                $('#button_loader' + id).hide();
                                $('#button_loader' + boxid).hide();
                                $('#loader_container_overlay').hide();
                            }, 1000);
                        }
                    }
                });
            });

            $('.minus_1').click(function() {
                id = $(this).attr('productId');
                var boxid = $(this).attr('boxId');
                price = $(this).attr('productprice');
                $('#button_loader' + id).css('display', 'flex').show();
                $('#button_loader' + boxid).css('display', 'flex').show();
                $('#loader_container_overlay').css('display', 'flex').show();
                $.ajax({
                    url: "{{ url('cart/decrement') }}",
                    type: "POST",
                    data: {
                        id: id,
                        boxid: boxid,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (qty > 0) {
                            $('#spec' + id).val(qty);
                            // let item = response.cart.items.find(item => item.id == id);
                            // if (item) {
                            //     // document.getElementById("quantity" + id).textContent = item.qty;
                            // } else {
                            //     console.error("Item with id " + id + " not found in the cart.");
                            // }
                        } else {
                            //   removeFromView(id,response);
                        }
                        // updateView(response, price);
                        location.reload();


                        setTimeout(() => {
                            $('#loader_container_overlay').hide();
                            $('#button_loader' + id).hide();
                            $('#button_loader' + boxid).hide();
                        }, 1000);
                    }
                });
            });

            $('.ion-close-cart1').click(function(e) {
                e.preventDefault();
                id = $(this).attr('productId');
                var boxId = $(this).attr('boxId');
                $('#button_loader' + id).css('display', 'flex').show();
                $('#button_loader' + boxId).css('display', 'flex').show();
                $('#loader_container_overlay').css('display', 'flex').show();
                $.ajax({
                    url: "{{ url('cart/remove') }}",
                    type: "POST",
                    data: {
                        id: id,
                        boxId: boxId,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.cart === null) {
                            $(`#cart_data`).remove();
                            setTimeout(() => {
                                $('#loader_container_overlay').hide();
                                $('#button_loader' + id).hide();
                            }, 1000);
                        }
                        if (response.cart === null) {
                            $('#cart_empty_dev').css('display', 'block');
                            $('#content').css('display', 'block');
                            $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(0);
                            setTimeout(() => {
                                $('#loader_container_overlay').hide();
                                $('#button_loader' + id).hide();
                                $('#button_loader' + boxId).hide();
                            }, 1000);
                        }
                        location.reload();
                        console.log(response);
                        updateView(response);
                        $(`#product-row-${id}`).remove();
                        $(`#hr${id}`).remove();
                        $(`#box-row${boxId}`).remove();
                        $(`#hr${boxId}`).remove();
                        $('#loader_container_overlay').hide();

                    }
                });
            });

            function updateView(response) {
                productTotal = parseInt(qty * price);
                $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(response.cart.qty);

                var minvalur = {{ getSetting('min_order_value') }};
                var total = parseFloat(response.cart.amount) +
                    parseFloat({{ getSetting('shipping') }}) +
                    (parseFloat(response.cart.amount) * parseFloat({{ getSetting('tax_value') }}) / 100);

                if (total < minvalur) {
                    $('.checkout').prop('disabled', true);
                    $('#show_meaaage').show();
                } else {

                    $('.checkout').prop('disabled', false);
                    $('#show_meaaage').hide();

                }
                // if (total > 90) {
                //         document.querySelector("#rider-stepper").style.minWidth="100%";
                // }
                // if (total < 90) {
                //         document.querySelector("#rider-stepper").style.minWidth="0%";
                // }
                $('.cartTotal').html('{{ getSetting('currency') }} ' +
                    (
                        (response.cart.amount - response.cart.discount) +
                        (response.cart.amount * {{ getSetting('tax_value') }} / 100)
                    ).toFixed(2)
                );
                // $('.vat').html('{{ getSetting('currency') }} ' +
                //     (
                //         (response.cart.amount * {{ getSetting('tax_value') }} / 100)
                //     ).toFixed(2)
                // );
                $('.cartTotal1').html('{{ getSetting('currency') }} ' + response.cart.amount + '');
                $('#productTotal' + id).html(productTotal);
                $('.discount').html('{{ getSetting('currency') }} ' + response.cart.discount + '.00');
                fetchShippingRules();
                if (response.cart.item_removed === 1) {
                    location.reload();
                }



            }

            function updatecart() {
                $('.checkout1').prop('disabled', true);
            }
            $('#country').on('change', function() {
                let countryId = $(this).val();
                if (countryId) {
                    // Fetch cities
                    $.ajax({
                        url: `/get-cities/${countryId}`,
                        type: 'GET',
                        success: function(response) {
                            let citySelect = $('#city');
                            citySelect.empty();
                            citySelect.append('<option value="">Select City</option>');
                            $.each(response, function(index, city) {
                                citySelect.append(
                                    `<option value="${city.name}">${city.name}</option>`
                                );
                            });
                        },
                        error: function() {
                            console.log('Error fetching cities.');
                        }
                    });

                    // Fetch shipping rates based on country
                    const userCityId = "";
                    $.ajax({
                        url: `/get-shipping-rules/${userCityId || 'null'}/${countryId || 'null'}`,
                        method: 'GET',
                        success: function(response) {
                            updateShippingUI(response);
                        },
                        error: function() {
                            console.log("Error fetching shipping rules.");
                        }
                    });
                }
            });
            $('#city').on('change', function() {
                let cityId = $('#city').val();
                let countryId = $('#country').val();
                $.ajax({
                    url: `/get-shipping-rules/${cityId || 'null'}/${countryId || 'null'}`,
                    method: 'GET',
                    success: function(response) {
                        updateShippingUI(response);
                    },
                    error: function() {
                        console.log("Error fetching shipping rules.");
                    }
                });
            });





            const userCityId = ""; // Get city ID from backend
            const userCountryId = "{{ $userCountry }}"; // Get country ID from backend
            const currency = "{{ getSetting('currency') }}"; // Store currency as JS variable
            const taxValue = {{ getSetting('tax_value') }}; // Store tax value as JS variable

            function fetchShippingRules() {
                $.ajax({
                    url: `/get-shipping-rules/${userCityId || 'null'}/${userCountryId || 'null'}`,
                    method: 'GET',
                    success: function(response) {
                        updateShippingUI(response);
                    },
                    error: function() {
                        console.log("Error fetching shipping rules.");
                    }
                });
            }

            function updateShippingUI(rules) {
                const cartTotal = parseFloat($('#cartTotal1').text().replace(/[^0-9.]/g, ''));
                const minOrder = rules.minOrder;
                const name = rules.name;
                const shippingCost = rules.shippingCost;
                const freeShippingThreshold = rules.freeShippingThreshold;
                const discount = rules.discount;
                if (cartTotal < freeShippingThreshold) {
                    $('.free_shipping_text').show();
                    const total_pending = freeShippingThreshold - cartTotal;
                    $('.pending_amount').text(total_pending);
                    // $('.free_shipping_no').text(`${total_pending}`);
                } else {
                    $('.free_shipping_text').hide();
                }

                // Update UI elements
                $('#minOrderMessage').html(`Minimum Order: <span class="icon-aed">${currency} ${minOrder} </span>`);
                $('.min_shipping').html(`<span class="icon-aed">${currency} ${minOrder} </span>`);
                $('.max_free_shipping').html(
                    `<span class="icon-aed"> ${currency} ${freeShippingThreshold} </span>`);


                // Disable checkout if below min order
                if (cartTotal < minOrder) {


                    $('#next-step').prop('disabled', true);
                    $('#show_meaaage').html(`Minimum Order: <span class="icon-aed">${currency} ${minOrder} </span>`)
                        .show();
                    $('#next_btn1').prop('disabled', true);
                    $('#show_meaaage1').html(
                            `Minimum Order for ${name} : <span class="icon-aed">${currency} ${minOrder}</span>`)
                        .show();
                } else {
                    $('#next-step').prop('disabled', false);
                    $('#show_meaaage').hide();
                    $('#next_btn1').prop('disabled', false);
                    $('#show_meaaage1').hide();
                }





                // Shipping cost and tax calculations
                if (cartTotal >= freeShippingThreshold) {
                    $('#shippingCost').text(`Free Shipping`);

                    $('.shipping_fee').text(`${currency} 0.00`);
                    $('.shipping_value').text(`${currency} 0.00`);
                    $('.upto_value').text(`Above ${freeShippingThreshold}`);
                    const cartTotalWithVAT = (cartTotal - discount) + (cartTotal * taxValue) / 100;
                    $('.cartTotal').text(
                        `${currency} ${cartTotalWithVAT.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} `
                    );
                } else {

                    $('#shippingCost').text(`Shipping Cost: ${shippingCost} ${currency}`);
                    $('.shipping_fee').text(`${currency} ${shippingCost}`);

                    $('.shipping_value').text(`${currency} ${shippingCost}`);
                    $('.upto_value').text(`Up to ${freeShippingThreshold}`);
                    const cartTotalWithVAT = (cartTotal - discount) + (cartTotal * taxValue) / 100;
                    const cartTotalWithVATshipping = (cartTotalWithVAT + shippingCost);
                    $('.cartTotal').text(
                        `${currency} ${cartTotalWithVATshipping.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} `
                    );
                }

                // for rider animation in percentage

                let progressPercentage;
                if (cartTotal < minOrder) {
                    progressPercentage = (cartTotal / minOrder) * 50; // Moving between 0% - 50%
                } else {
                    progressPercentage = 50 + ((cartTotal - minOrder) / (freeShippingThreshold - minOrder)) *
                        50; // Moving between 50% - 100%
                }

                progressPercentage = Math.min(progressPercentage, 100);
                document.querySelectorAll("#rider-stepper").forEach((e) => {
                    e.style.minWidth = `${progressPercentage}%`;
                })
                // Update the final total display
                //const totalWithShipping = response.cart.amount + shippingCost;
                //const totalWithTax = totalWithShipping + (totalWithShipping * taxValue / 100);
                //$('.finaltotal').text(`${currency} ${totalWithTax.toFixed(2)}`);

                // Trigger cart updated event
                // $(document).trigger('cartUpdated');

            }
            fetchShippingRules();

            $(document).on('cartUpdated', function() {
                updatePaymentRequest();
                fetchShippingRules();
            });


            let stripe, elements, card, paymentRequest;
            let paymentRequestButton = null; // Track the payment request button instance

            // Initialize Stripe Elements
            function initializeStripe() {
                if (!stripe) {
                    stripe = Stripe("{{ getSetting('stripe_public_key') }}");
                    elements = stripe.elements();
                    card = elements.create('card');
                    card.mount('#card-element');

                    const submitButton = document.getElementById('submitOrder');
                    const cardErrors = document.getElementById('card-errors');

                    // Disable the button initially
                    submitButton.disabled = true;

                    card.addEventListener('change', function(event) {
                        if (event.error) {
                            cardErrors.textContent = event.error.message;
                            submitButton.disabled = true;
                        } else {
                            cardErrors.textContent = "";
                            submitButton.disabled = !event
                                .complete; // Only enable if card details are complete
                        }
                    });
                }
                updatePaymentRequest(); // Initialize payment request when Stripe loads
            }


            // Update Payment Request with latest total
            function updatePaymentRequest() {
                const finaltotal = parseFloat($('.finaltotal').text().replace(/[^0-9.]/g, ''));

                // Destroy previous payment request button if exists
                if (paymentRequestButton) {
                    paymentRequestButton.unmount();
                }

                paymentRequest = stripe.paymentRequest({
                    country: 'AE',
                    currency: 'aed',
                    total: {
                        label: 'Total',
                        amount: Math.round(finaltotal * 100), // Amount in cents
                    },
                    requestPayerName: true,
                    requestPayerEmail: true,
                    disableWallets: ['link']
                });

                paymentRequestButton = elements.create('paymentRequestButton', {
                    paymentRequest
                });

                paymentRequest.canMakePayment().then(result => {
                    const prButton = document.getElementById('payment-request-button');
                    prButton.innerHTML = ''; // Clear previous content
                    if (result) {
                        paymentRequestButton.mount('#payment-request-button');
                    } else {
                        prButton.style.display = 'none';
                    }
                });
                paymentRequest.on('paymentmethod', async (event) => {
                    try {
                        // Fetch clientSecret from the backend
                        const finaltotal = parseFloat($('.finaltotal').text().replace(/[^0-9.]/g, '')) *
                            100;
                        const response = await fetch('/create-payment-intent', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                amount: finaltotal
                            })
                        });

                        const {
                            clientSecret
                        } = await response.json();
                        if (!clientSecret) throw new Error('Missing clientSecret');

                        const {
                            error
                        } = await stripe.confirmPayment({
                            clientSecret,
                            payment_method: event.paymentMethod.id,
                        });

                        if (error) {
                            event.complete('fail');
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Payment Failed',
                                text: error.message
                            });
                        } else {
                            event.complete('success');
                            Swal.fire({
                                icon: 'success',
                                title: 'Payment Successful',
                                text: 'Your payment has been processed successfully.'
                            });

                            // Submit order
                            const formData = new FormData(document.getElementById('paymentForm'));
                            formData.append('payment_method', 'apple_google_pay');
                            await submitOrder(formData);
                        }
                    } catch (err) {
                        console.error('Error confirming payment:', err);
                        event.complete('fail');
                    }
                });

            }

            // Handle payment method changes
            function handlePaymentMethodChange() {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
                const submitButton = document.getElementById('submitOrder');

                document.querySelector('.card_details').style.display =
                    (selectedMethod === 'stripe') ? 'block' : 'none';

                if (selectedMethod === 'stripe') {
                    initializeStripe();
                    submitButton.disabled = true;
                } else {
                    submitButton.disabled = false;
                }
            }

            // Update payment request when cart changes
            $(document).on('cartUpdated', function() {
                if (stripe) {
                    updatePaymentRequest();
                }
            });

            // Initial setup
            document.addEventListener('DOMContentLoaded', function() {
                handlePaymentMethodChange();
                document.querySelectorAll('input[name="payment_method"]').forEach(input => {
                    input.addEventListener('change', handlePaymentMethodChange);
                });
            });

            // Submit Order
            async function submitOrder(formData) {
                const spinner = document.getElementById('spinner');
                const submitButton = document.getElementById('submitOrder');
                submitButton.disabled = true;
                $('#loader_container').css('display', 'flex').show();

                try {
                    const response = await fetch("{{ route('order_submit') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        try {
                            if (window.dataLayer) { // Ensure dataLayer exists
                                const productDetail = Array.isArray(data.cart.product_detail) ?
                                    data.cart.product_detail :
                                    JSON.parse(data.cart.product_detail || '[]');

                                if (productDetail.length > 0) { // Ensure productDetail is not empty
                                    window.dataLayer.push({
                                        event: "purchase",
                                        ecommerce: {
                                            transaction_id: data.cart.order_no,
                                            value: data.cart.amount,
                                            currency: "AED",
                                            payment_method: data.cart.payment_method,
                                            items: productDetail.map(item => ({
                                                item_id: item.id,
                                                item_name: item.name,
                                                price: item.price,
                                                quantity: item.qty,
                                            })),
                                        },
                                    });
                                    console.log("DataLayer pushed:", window.dataLayer);
                                }
                            } else {
                                console.warn("dataLayer is not defined.");
                            }
                        } catch (datalayerError) {
                            console.error("Error pushing to dataLayer:", datalayerError);
                        }
                        if (data.payment_method === 'ngenius') {

                            const ngeniusResponse = await fetch("{{ route('ngenius.createOrder') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    order_no: data.order_no
                                })
                            });

                            const ngeniusData = await ngeniusResponse.json();
                            $('#submitOrder').prop('disabled', false);
                            $('#spinner').hide();
                            $('#loader_container').hide();

                            window.location.href = ngeniusData.paymentLink || "{{ url('/thanks') }}/" + data
                                .order_no;
                        } else {

                            $('#submitOrder').prop('disabled', false);
                            $('#spinner').hide();
                            $('#loader_container').hide();
                            window.location.href = "{{ url('/thanks') }}/" + data.order_no;
                        }
                    } else {
                        throw new Error(data.message || 'An error occurred while submitting your order.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: error.message || 'An unexpected error occurred.',
                    });
                    spinner.style.display = 'none';
                    submitButton.disabled = false;
                    $('#loader_container').hide();
                } finally {
                    spinner.style.display = 'none';
                    submitButton.disabled = false;
                }
            }

            document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
                input.addEventListener('change', handlePaymentMethodChange);
            });

            document.addEventListener('DOMContentLoaded', handlePaymentMethodChange);

            document.getElementById('submitOrder').addEventListener('click', async (e) => {
                e.preventDefault();
                const submitButton = document.getElementById('submitOrder');
                submitButton.disabled = true;
                $('#loader_container').css('display', 'flex').show();

                const selectedMethod = document.querySelector('input[name="payment_method"]:checked')
                    .value;
                const formData = new FormData(document.getElementById('paymentForm'));
                formData.append('payment_method', selectedMethod);

                if (selectedMethod === 'stripe') {
                    const {
                        token,
                        error
                    } = await stripe.createToken(card);

                    if (error) {
                        document.getElementById('card-errors').textContent = error.message;
                        return;
                    }

                    formData.append('stripeToken', token.id);
                }

                await submitOrder(formData);
            });
            // initializeStripe();

        });
    </script>
    <script>
        function getCities() {
            let countryId = $('#country').val();
            if (countryId) {
                // Fetch cities
                $.ajax({
                    url: `/get-cities/${countryId}`,
                    type: 'GET',
                    success: function(response) {
                        let citySelect = $('#city');
                        citySelect.empty();
                        citySelect.append('<option value="">Select City</option>');
                        $.each(response, function(index, city) {
                            citySelect.append(
                                `<option value="${city.name}">${city.name}</option>`
                            );
                        });
                    },
                    error: function() {
                        console.log('Error fetching cities.');
                    }
                });

                // Fetch shipping rates based on country
                const userCityId = "";
                $.ajax({
                    url: `/get-shipping-rules/${userCityId || 'null'}/${countryId || 'null'}`,
                    method: 'GET',
                    success: function(response) {
                        // updateShippingUI(response);
                    },
                    error: function() {
                        console.log("Error fetching shipping rules.");
                    }
                });
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            // Load session data on page load
            fetchSessionData();

            document.getElementById("next_btn").addEventListener("click", function() {
                storeFormData();
            });
        });

        function storeFormData() {
            let formData = {
                fname: document.querySelector("input[name='fname']").value,
                lname: document.querySelector("input[name='lname']").value,
                email: document.querySelector("input[name='email']").value,
                phone: document.querySelector("input[name='phone']").value,
                country: document.querySelector("select[name='country']").value,
                city: document.querySelector("select[name='city']").value,
                address: document.querySelector("input[name='address']").value,
                unit: document.querySelector("input[name='unit']").value,
                postal_code: document.querySelector("input[name='postal_code']").value,
                order_note: document.querySelector("textarea[name='order_note']").value
            };

            // Send data to Laravel via AJAX
            fetch("{{ route('store.checkout.session') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(formData)
            }).then(response => response.json()).then(data => {
                console.log("Session stored successfully", data);
                // Redirect to payment page if needed
            }).catch(error => console.error("Error:", error));
        }

        function fetchSessionData() {
            fetch("{{ route('get.checkout.session') }}")
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.querySelector("input[name='fname']").value = data.fname || "";
                        document.querySelector("input[name='lname']").value = data.lname || "";
                        document.querySelector("input[name='email']").value = data.email || "";
                        document.querySelector("input[name='phone']").value = data.phone || "";
                        document.querySelector("select[name='country']").value = data.country || "";
                        document.querySelector("select[name='city']").value = data.city || "";
                        document.querySelector("input[name='address']").value = data.address || "";
                        document.querySelector("input[name='unit']").value = data.unit || "";
                        document.querySelector("input[name='postal_code']").value = data.postal_code || "";
                        document.querySelector("textarea[name='order_note']").value = data.order_note || "";
                    }
                    getCities();
                }).catch(error => console.error("Error fetching session:", error));

        }
    </script>

    <script>
        document.getElementById('applyCouponForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $('#loader_container').css('display', 'flex').show();
            fetch('{{ route('applyCoupon') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#loader_container').hide();
                        document.getElementById('coupon_error_1').textContent = data.message;
                        location.reload();
                    } else {
                        $('#loader_container').hide();
                        document.getElementById('coupon_error').textContent = data.message;
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <!-- TikTok AddToCart Event -->
    <!-- <script>
        @php
            use App\Helpers\TikTokTracking;
            $cartItems = App\Helpers\Cart::products() ?? [];
            $totalValue = 0;
            $currency = "aed";
            $cartContents = [];
            
            // Get user email and phone for hashing
            $userEmail = session('user')['email'] ?? session('cart')['email'] ?? '';
            $userPhone = session('user')['phone'] ?? session('cart')['phone'] ?? '';
            $hashedEmail = $userEmail ? TikTokTracking::hashEmail($userEmail) : '';
            $countryHint = session('cart')['country'] ?? null;
            $hashedPhone = $userPhone ? TikTokTracking::hashPhoneNumber($userPhone, $countryHint) : '';
            
            if (!empty($cartItems)) {
                foreach ($cartItems as $item) {
                    $itemPrice = $item->discount_price ?? $item->selling_price ?? 0;
                    $totalValue += ($itemPrice * $item->qty);
                    $cartContents[] = [
                        'content_id' => $item->id,
                        'content_type' => 'product',
                        'content_name' => $item->product_name,
                        'quantity' => $item->qty,
                        'price' => $itemPrice
                    ];
                }
            }
            $eventId = TikTokTracking::generateEventId();
        @endphp

        @if (!empty($cartContents))
            function trackTikTokAddToCart() {
                try {
                    console.log("🔍 TikTok pixel check - ttq defined:", typeof ttq !== 'undefined');
                    
                    if (typeof ttq !== 'undefined') {
                        const tiktokPayload = {
                            "contents": {!! json_encode($cartContents) !!},
                            "value": {{ $totalValue }},
                            "currency": "{{ $currency }}"
                        };
                        
                        @if ($hashedEmail)
                        tiktokPayload.user_data = tiktokPayload.user_data || {};
                        tiktokPayload.user_data.em = "{{ $hashedEmail }}";
                        @endif
                        
                        @if ($hashedPhone)
                        tiktokPayload.user_data = tiktokPayload.user_data || {};
                        tiktokPayload.user_data.ph = "{{ $hashedPhone }}";
                        @endif
                        
                        const tiktokOptions = {
                            "event_id": "{{ $eventId }}"
                        };
                        
                        console.log("📊 TikTok AddToCart Event Payload:", tiktokPayload);
                        console.log("🎯 TikTok Event Options:", tiktokOptions);
                        
                        ttq.track('AddToCart', tiktokPayload, tiktokOptions);
                        console.log("✅ TikTok AddToCart tracked successfully with {{ count($cartContents) }} items");
                    } else {
                        console.warn("⚠️ TikTok ttq is NOT defined yet - retrying in 500ms");
                        setTimeout(trackTikTokAddToCart, 500);
                    }
                } catch (e) {
                    console.error("❌ Error tracking TikTok AddToCart event:", e);
                }
            }

            // Wait for DOM to be ready, then track
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', trackTikTokAddToCart);
            } else {
                trackTikTokAddToCart();
            }
        @else
            console.log("ℹ️ No cart items to track");
        @endif
    </script> -->

@endsection
