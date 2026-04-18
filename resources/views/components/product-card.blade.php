@php
    use App\Models\Admins\Rating;
@endphp

<div class="card">
    <div class="card_container" style="background-color: white">

        <div class="card_image">
            <a href="{{ url('/') }}/product/{{ $product->slug }}" class="product-card__quick-look"
                aria-label="{{ app()->isLocale('ar') ? 'عرض المنتج' : 'View product' }}">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            </a>
            @php
                $discount_price = $product->discount_price;
                $selling_price = $product->selling_price;
                if ($selling_price > 0) {
                    $discount_percentage = round((($selling_price - $discount_price) / $selling_price) * 100);
                } else {
                    $discount_percentage = 0;
                }
            @endphp
            @if ($discount_percentage > 0)
                <button type="button" class="floating-btn">Save {{ $discount_percentage }}%</button>
            @endif

            <div class="product_slider" style="z-index: 1;">
                <img src="{{ asset($product->image_one) }}?v={{ strtotime($product->updated_at) }}"
                    title="{{ app()->isLocale('ar') ? $product->name_ar : $product->product_name }}"
                    alt="{{ app()->isLocale('ar') ? $product->name_ar : $product->product_name }}"
                    class="product_slider_image active" loading="lazy">
            </div>
        </div>

        <div class="card_content">
            <a href="{{ url('/') }}/product/{{ $product->slug }}">
                <h4 class="product-name">
                    {{ app()->isLocale('ar') ? $product->name_ar : $product->product_name }}
                </h4>
            </a>

            @php
                $data = Rating::where('pid', $product->id)->where('status', 1)->sum('rate');
                $count = Rating::where('pid', $product->id)->where('status', 1)->count();
                $rate = $count ? $data / $count : 0;

                $discount_percentage =
                    $product->selling_price > 0
                        ? round((($product->selling_price - $product->discount_price) / $product->selling_price) * 100)
                        : 0;
            @endphp

            <!-- <div class="stars rating_stars">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($rate >= $i)
                    <i class="fa fa-star checked"></i>
                    @elseif ($rate > $i - 1)
                    <i class="fa fa-star-half-o checked" style="font-size: 16px;font-weight: bolder;"></i>
                    @else
                    <i class="fa fa-star"></i>
                    @endif
                    @endfor
            </div> -->

            <p class="rats">
                <span class="icon-aed">{{ getSetting('currency') }}</span> <span>{{ $product->discount_price }}</span>
                @if ($product->selling_price > 0)
                    <del class="ml"><span
                            class="icon-aed">{{ getSetting('currency') }}</span><span>{{ $product->selling_price }}</span>
                    </del>
                    <!-- <span class="red-text">({{ $discount_percentage }}% Off)</span> -->
                @endif
            </p>

            {{-- Quantity Controls --}}
            @once
                <style>
                    .card_image {
                        position: relative;
                    }

                    .product-card__quick-look {
                        position: absolute;
                        top: 0.5rem;
                        inset-inline-end: 0.5rem;
                        z-index: 4;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 2.35rem;
                        height: 2.35rem;
                        border-radius: 50%;
                        background: #f5d4dc;
                        color: #1a1a1a;
                        text-decoration: none;
                        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.08);
                        opacity: 0;
                        visibility: hidden;
                        transform: scale(0.92);
                        transition:
                            opacity 0.2s ease,
                            visibility 0.2s ease,
                            transform 0.2s ease,
                            background-color 0.2s ease,
                            color 0.2s ease;
                    }

                    .card:hover .product-card__quick-look {
                        opacity: 1;
                        visibility: visible;
                        transform: scale(1);
                    }

                    .product-card__quick-look:hover {
                        background: #ebb6c8;
                        color: #111;
                    }

                    .product-card__quick-look:focus-visible {
                        opacity: 1;
                        visibility: visible;
                        transform: scale(1);
                        outline: 2px solid rgba(233, 40, 39, 0.45);
                        outline-offset: 2px;
                    }

                    .quantity_cart_wrap {
                        display: inline-flex;
                        align-items: center;
                        gap: 2px;
                        vertical-align: middle;
                    }

                    .quantity_cart_wrap .quantity_cart {
                        box-sizing: border-box;
                        width: auto;
                        min-width: 7.5rem;
                        max-width: 100%;
                        padding: 2px 10px;
                        font-size: 0.875rem;
                        line-height: 1.25;
                        font-variant-numeric: tabular-nums;
                        border-radius: 0.5rem;
                        transition:
                            border-color 0.2s ease,
                            box-shadow 0.2s ease,
                            background-color 0.2s ease,
                            color 0.2s ease;
                    }

                    .quantity_cart_wrap .quantity_cart:hover {
                        border-color: rgba(0, 0, 0, 0.2);
                    }

                    .quantity_cart_wrap .quantity_cart:focus {
                        outline: none;
                        border-color: rgba(13, 110, 253, 0.55);
                        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.18);
                    }

                    .quantity_cart_wrap .quantity_cart:focus-visible {
                        outline: none;
                    }

                    .quantity_cart_unit {
                        font-size: 0.8rem;
                        white-space: nowrap;
                    }

                    .product-card__buy-stack {
                        position: relative;
                        display: flex;
                        flex-direction: column;
                        gap: 0.65rem;
                        width: 100%;
                        margin-top: 0.35rem;
                    }

                    .product-card__qty-side--hide {
                        display: none !important;
                    }

                    .product-card__pre-del {
                        flex: 0 0 auto;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 2.25rem;
                        height: 2.25rem;
                        padding: 0;
                        margin: 0;
                        border: none;
                        background: transparent;
                        color: #8a8580;
                        cursor: pointer;
                        border-radius: 0.35rem;
                        transition:
                            background-color 0.15s ease,
                            color 0.15s ease;
                    }

                    .product-card__pre-del:hover {
                        background: rgba(0, 0, 0, 0.06);
                        color: #c41e3a;
                    }

                    .product-card__pre-qty {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        gap: 0.5rem;
                        width: 100%;
                        padding: 0.55rem 0.65rem;
                        background: #f7f4ef;
                        border: 1px solid #e5e0d8;
                        border-radius: 0.75rem;
                        box-sizing: border-box;
                    }

                    .product-card__qty-btn {
                        flex: 0 0 auto;
                        width: 2.25rem;
                        height: 2.25rem;
                        padding: 0;
                        border: none;
                        background: transparent;
                        font-size: 1.35rem;
                        line-height: 1;
                        color: #2a2a2a;
                        cursor: pointer;
                        border-radius: 0.35rem;
                        transition: background-color 0.15s ease, color 0.15s ease;
                    }

                    .product-card__qty-btn:hover {
                        background: rgba(0, 0, 0, 0.06);
                    }

                    .product-card__qty-center {
                        flex: 1 1 auto;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        min-width: 0;
                    }

                    .product-card__qty-value-row {
                        display: inline-flex;
                        align-items: baseline;
                        justify-content: center;
                        gap: 0.08rem;
                        max-width: 100%;
                    }

                    .product-card__pre-qty[data-qty-grams='1'] .product-card__qty-value-row {
                        gap: 0.06rem;
                    }

                    .product-card__pre-qty-input {
                        box-sizing: border-box;
                        width: auto;
                        min-width: 4rem;
                        max-width: 100%;
                        margin: 0;
                        padding: 0.2rem 0.35rem;
                        border: none;
                        background: transparent;
                        font-size: 0.95rem;
                        font-weight: 600;
                        font-variant-numeric: tabular-nums;
                        text-align: center;
                        color: #1a1a2e;
                        border-radius: 0.35rem;
                    }

                    .product-card__pre-qty[data-qty-grams='1'] .product-card__pre-qty-input {
                        min-width: 0;
                        width: auto;
                        max-width: 7.5ch;
                        padding: 0.2rem 0.1rem 0.2rem 0.25rem;
                        text-align: end;
                        field-sizing: content;
                    }

                    @supports not (field-sizing: content) {
                        .product-card__pre-qty[data-qty-grams='1'] .product-card__pre-qty-input {
                            width: min(7.5ch, 100%);
                        }
                    }

                    .product-card__qty-unit-g {
                        flex: 0 0 auto;
                        font-size: 0.82rem;
                        font-weight: 500;
                        color: #3d3d4a;
                        line-height: 1;
                    }

                    .product-card__pre-qty-input:focus {
                        outline: none;
                        background: rgba(255, 255, 255, 0.65);
                    }

                    .product-card__pre-qty-input::-webkit-outer-spin-button,
                    .product-card__pre-qty-input::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }

                    .product-card__pre-qty-input[type="number"] {
                        appearance: textfield;
                        -moz-appearance: textfield;
                    }

                    .product-card__add-btn {
                        width: 100%;
                        margin: 0;
                        padding: 0.7rem 1rem;
                        border: 1px solid #d8d8d8;
                        border-radius: 999px;
                        background: #fff;
                        color: #111;
                        font-size: 0.9rem;
                        font-weight: 600;
                        cursor: pointer;
                        transition:
                            background-color 0.2s ease,
                            border-color 0.2s ease,
                            box-shadow 0.2s ease,
                            transform 0.1s ease;
                    }

                    .product-card__add-btn:hover:not(:disabled) {
                        background: #e92827;
                        border-color: #e92827;
                        color: #fff;
                    }

                    .product-card__add-btn:active:not(:disabled) {
                        transform: scale(0.99);
                    }

                    .product-card__add-btn:disabled {
                        opacity: 0.55;
                        cursor: not-allowed;
                    }
                </style>
            @endonce
            @php
                $inCart = App\Helpers\Cart::has_pro($product->id);
                $lineQty = App\Helpers\Cart::product_qty($product->id) ?? 1;
                $atCartMin = $inCart && (int) $lineQty <= 1;
                $isWeightFormat = (int) $product->format === 1;
                $qtyDisplayVal = $isWeightFormat ? $lineQty * 100 : $lineQty;
                $qtyStep = $isWeightFormat ? 100 : 1;
                $qtyMin = $isWeightFormat ? 100 : 1;
                $qtyMaxDisplay = $isWeightFormat
                    ? max(100, (int) $product->product_quantity * 100)
                    : max(1, (int) $product->product_quantity);
                $qtyInputSize = $isWeightFormat
                    ? max(3, min(7, strlen((string) max($qtyDisplayVal, $qtyMaxDisplay)) + 1))
                    : max(6, min(14, strlen((string) max($qtyDisplayVal, $qtyMaxDisplay)) + 1));
                $specFieldValue = $inCart ? $lineQty : 1;
                $prePickerDisplay = $isWeightFormat ? $specFieldValue * 100 : $specFieldValue;
                $addBtnClass = request()->is('cart') ? 'add-to-cart-item1' : 'add-to-cart';
            @endphp

            <input type="hidden" id="spec{{ $product->id }}" name="qty" value="{{ $specFieldValue }}">

            <div class=" add-to-cart{{ $product->id }} product-card__buy-stack"
                data-card-product-id="{{ $product->id }}"
                data-line-in-cart="{{ $inCart ? '1' : '0' }}"
                data-soldout="{{ $product->product_quantity < 1 ? '1' : '0' }}">
                <div class="button_spin_overlay" id="button_loader{{ $product->id }}" style="display: none">
                    <div class="loader_dots"></div>
                </div>
                <div class="product-card__pre-qty" data-product-id="{{ $product->id }}"
                    data-qty-grams="{{ $isWeightFormat ? '1' : '0' }}"
                    data-max-units="{{ (int) $product->product_quantity }}">
                    <button type="button"
                        class="del_btn ion-close product-card__pre-del {{ $atCartMin ? '' : 'product-card__qty-side--hide' }}"
                        productId="{{ $product->id }}" aria-label="Remove">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                    <button type="button"
                        class="product-card__qty-btn product-card__qty-btn--minus {{ $atCartMin ? 'product-card__qty-side--hide' : '' }}"
                        aria-label="Decrease quantity"
                        onclick="productCardStepQty({{ $product->id }},-1); return false;">−</button>
                    <div class="product-card__qty-center">
                        <div class="product-card__qty-value-row">
                            <input type="number" class="product-card__pre-qty-input"
                                id="product-pre-qty-in-{{ $product->id }}" inputmode="numeric"
                                size="{{ $qtyInputSize }}" value="{{ $prePickerDisplay }}" step="{{ $qtyStep }}"
                                min="{{ $qtyMin }}" max="{{ $qtyMaxDisplay }}">
                            @if ($isWeightFormat)
                                <span class="quantity_cart_unit product-card__qty-unit-g">g</span>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="product-card__qty-btn product-card__qty-btn--plus"
                        aria-label="Increase quantity"
                        onclick="productCardStepQty({{ $product->id }},1); return false;">+</button>
                </div>
                <button type="button" class="{{ $addBtnClass }} product-card__add-btn" id="{{ $product->id }}"
                    data-id="{{ $product->id }}" data-price="{{ $product->discount_price }}"
                    @if ($product->product_quantity < 1) disabled @endif>
                    @if ($product->product_quantity < 1)
                        {{ __('home.product.button.soldout') }}
                    @else
                        {{ __('home.product.button.add') }}
                    @endif
                </button>
            </div>


        </div>

    </div>
</div>
