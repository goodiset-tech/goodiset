@php
    $currency = getSetting('currency');
    $pkgCount = 0;
    foreach (App\Helpers\Cart::package() as $p) {
        if (!empty($p['package_type'])) {
            $pkgCount++;
        }
    }
    $hasItems = count(App\Helpers\Cart::products()) > 0 || $pkgCount > 0;
@endphp

<div class="cart-drawer-inner">
    <div class="cart-drawer-inner__head">
        <h2 class="cart-drawer-inner__title">{{ __('cart.drawer.title', ['count' => $cartQty]) }}</h2>
    </div>

    @if (!$hasItems)
        <div class="cart-drawer-empty">
            <p class="cart-drawer-empty__lead">{{ __('cart.empty.subheading') }}</p>
            <p class="cart-drawer-empty__hint">{{ __('cart.empty.cta_hint') }}</p>
            <a href="{{ url('/') }}" class="cart-drawer-btn cart-drawer-btn--outline">{{ __('cart.cta.continue_shopping') }}</a>
        </div>
    @else
        @if ($aproducts->count() > 0)
            <div class="cart-drawer-upsell">
                <p class="cart-drawer-upsell__title">{{ __('cart.trending.title') }}</p>
                <div class="cart-drawer-upsell__track">
                    @foreach ($aproducts as $rec)
                        <div class="cart-drawer-upsell-card" data-upsell-product-id="{{ $rec->id }}">
                            <a href="{{ url('/') }}/product/{{ $rec->slug ?? $rec->id }}"
                                class="cart-drawer-upsell-card__img">
                                <img src="{{ asset('') }}{{ $rec->image_one }}" alt="{{ $rec->product_name }}"
                                    loading="lazy" width="72" height="72">
                            </a>
                            <div class="cart-drawer-upsell-card__body">
                                <a href="{{ url('/') }}/product/{{ $rec->slug ?? $rec->id }}"
                                    class="cart-drawer-upsell-card__name">{{ $rec->product_name }}</a>
                                <div class="cart-drawer-upsell-card__row">
                                    <span class="cart-drawer-upsell-card__price"><span
                                            class="icon-aed">{{ $currency }}</span>
                                        {{ number_format((float) $rec->discount_price, 2) }}</span>
                                    <button type="button" class="cart-drawer-upsell-add"
                                        data-product-id="{{ $rec->id }}">{{ __('cart.product.add_to_bag') }}</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="cart-drawer-lines">
            @foreach (collect(App\Helpers\Cart::products())->reverse() as $product)
                @continue(!$product || !$product->id)
                @php
                    $lineTotal =
                        $product->name == 'Free Product'
                            ? 0
                            : (float) $product->discount_price * (int) $product->qty;
                @endphp
                <div class="cart-drawer-line" data-drawer-line="product" data-product-id="{{ $product->id }}">
                    <a href="{{ url('/') }}/product/{{ $product->slug ?? $product->id }}"
                        class="cart-drawer-line__img">
                        <img src="{{ asset('') }}{{ $product->image_one }}" alt="{{ $product->product_name }}"
                            loading="lazy" width="64" height="64">
                    </a>
                    <div class="cart-drawer-line__main">
                        <a href="{{ url('/') }}/product/{{ $product->slug ?? $product->id }}"
                            class="cart-drawer-line__name">{{ $product->product_name }}</a>
                        @if ($product->name == 'Free Product')
                            <div class="cart-drawer-line__price">{{ __('cart.product.free_product') }}</div>
                        @else
                            <div class="cart-drawer-line__meta">
                                <span class="cart-drawer-line__price"><span
                                        class="icon-aed">{{ $currency }}</span>
                                    {{ number_format($lineTotal, 2) }}</span>
                                <div class="cart-drawer-qty" data-qty-grams="{{ (int) $product->format === 1 ? '1' : '0' }}"
                                    data-product-qty-max="{{ (int) $product->product_quantity }}">
                                    <button type="button" class="cart-drawer-qty__btn cart-drawer-remove-prod"
                                        data-product-id="{{ $product->id }}" title="{{ __('cart.drawer.remove') }}">
                                        <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="cart-drawer-qty__btn cart-drawer-dec-prod"
                                        data-product-id="{{ $product->id }}">−</button>
                                    <span class="cart-drawer-qty__val">
                                        @if ($product->format == 1)
                                            {{ $product->qty * 100 }} g
                                        @else
                                            {{ $product->qty }}
                                        @endif
                                    </span>
                                    <button type="button" class="cart-drawer-qty__btn cart-drawer-inc-prod"
                                        data-product-id="{{ $product->id }}">+</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            @foreach (App\Helpers\Cart::package() as $pkg)
                @if ($pkg['package_type'] != null)
                    @php
                        $boxes = \App\Models\BoxCustomize::where('package_id', $pkg['package_type'])
                            ->where('size_id', $pkg['package_size'])
                            ->first();
                    @endphp
                    @continue(!$boxes)
                    @php
                        $pkgLine = (float) $boxes->price * (int) $pkg['qty'];
                    @endphp
                    <div class="cart-drawer-line" data-drawer-line="package" data-box-id="{{ $boxes->id }}">
                        <div class="cart-drawer-line__img">
                            <img src="{{ asset('') }}{{ $boxes->image }}" alt="{{ $pkg['package_name'] }}"
                                loading="lazy" width="64" height="64">
                        </div>
                        <div class="cart-drawer-line__main">
                            <span class="cart-drawer-line__name">{{ $pkg['package_name'] }}</span>
                            <div class="cart-drawer-line__meta">
                                <span class="cart-drawer-line__price"><span
                                        class="icon-aed">{{ $currency }}</span>
                                    {{ number_format($pkgLine, 2) }}</span>
                                <div class="cart-drawer-qty" data-qty-grams="0">
                                    <button type="button" class="cart-drawer-qty__btn cart-drawer-remove-box"
                                        data-box-id="{{ $boxes->id }}" title="{{ __('cart.drawer.remove') }}">
                                        <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="cart-drawer-qty__btn cart-drawer-dec-box"
                                        data-box-id="{{ $boxes->id }}">−</button>
                                    <span class="cart-drawer-qty__val">{{ $pkg['qty'] }}</span>
                                    <button type="button" class="cart-drawer-qty__btn cart-drawer-inc-box"
                                        data-box-id="{{ $boxes->id }}">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="cart-drawer-footer">
            <a href="{{ url('/') }}/cart" class="cart-drawer-btn cart-drawer-btn--primary">
                {!! __('cart.drawer.checkout_cta') !!}               
                <span class="cart-drawer-line__price"><span
                                        class="icon-aed">{{ $currency }}</span>
                                    {{ number_format($cartAmount, 2) }}</span>
            </a>
            <button type="button" class="cart-drawer-link" data-cart-drawer-continue>
                {{ __('cart.drawer.or_continue') }}
            </button>
        </div>
    @endif
</div>
