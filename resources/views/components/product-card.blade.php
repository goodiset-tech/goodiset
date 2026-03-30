@php
    use App\Models\Admins\Rating;
@endphp

<div class="card">
    <div class="card_container" style="background-color: white">

        <a href="{{ url('/') }}/product/{{ $product->slug }}">
            <div class="card_image">
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
                    <button class="floating-btn">Save {{ $discount_percentage }}%</button>
                @endif

                <div class="product_slider" style="z-index: 1;">
                    <img src="{{ asset($product->image_one) }}?v={{ strtotime($product->updated_at) }}"
                        title="{{ app()->isLocale('ar') ? $product->name_ar : $product->product_name }}"
                        alt="{{ app()->isLocale('ar') ? $product->name_ar : $product->product_name }}"
                        class="product_slider_image active" loading="lazy">
                </div>
            </div>
        </a>

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

            @if (request()->is('cart'))
                <div class="quantity quantity-controls quantity_btn_box{{ $product->id }}" id="quantity_btn_box"
                    style="{{ App\Helpers\Cart::has_pro($product->id) ? '' : 'display:none;' }}">
                    <div class="button_spin_overlay" id="button_loader{{ $product->id }}" style="display: none">
                        <div class="loader_dots"></div>
                    </div>
                    <button class="del_btn ion-close" productId="{{ $product->id }}">

                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                    @php
                        $quantity = App\Helpers\Cart::product_qty($product->id);
                        $quantity = $quantity ?? 1;
                    @endphp
                    <i class="fa-solid fa-minus minus_quantity minus_1" productId="{{ $product->id }}"
                        productprice="{{ $product->discount_price }}" id="minus"></i>
                    <input type="hidden" class="form-control form-control-sm bg-secondary text-center"
                        id="spec{{ $product->id }}" id="qty" name="qty" value="1">
                    <span class="quantity_cart" id="quantity{{ $product->id }}">
                        @if ($product->format == 1)
                            {{ $quantity * 100 }} g
                        @else
                            {{ $quantity * 1 }}
                        @endif
                    </span>
                    <i class="fa-solid fa-plus add_quantity plus_1" productId="{{ $product->id }}"
                        productprice="{{ $product->discount_price }}" id="plus"></i>
                </div>

                <div class=" add-to-cart{{ $product->id }}"
                    style="{{ App\Helpers\Cart::has_pro($product->id) ? 'display:none;' : '' }}">
                    <button class="add-to-cart-item1"
                        onclick="addToCart({{ $product->id }}, {{ $product->discount_price }})"
                        @if ($product->product_quantity < 1) disabled @endif id="{{ $product->id }}"
                        data-id="{{ $product->id }}" data-price="{{ $product->discount_price }}">
                        @if ($product->product_quantity < 1)
                            {{ __('home.product.button.soldout') }}
                        @else
                            {{ __('home.product.button.add') }}
                        @endif
                    </button>
                </div>
            @else
                <div class="quantity quantity-controls quantity_btn_box{{ $product->id }}" id="quantity_btn_box"
                    style="{{ App\Helpers\Cart::has_pro($product->id) ? '' : 'display:none;' }}">
                    <div class="button_spin_overlay" id="button_loader{{ $product->id }}" style="display: none">
                        <div class="loader_dots"></div>
                    </div> <button class="del_btn ion-close" productId="{{ $product->id }}"> <i
                            class="fa-regular fa-trash-can"></i> </button> @php
                                $quantity = App\Helpers\Cart::product_qty($product->id);
                                $quantity = $quantity ?? 1;
                            @endphp <i
                        class="fa-solid fa-minus minus_quantity minus" productId="{{ $product->id }}"
                        productprice="{{ $product->discount_price }}" id="minus"></i> <input type="hidden"
                        class="form-control form-control-sm bg-secondary text-center" id="spec{{ $product->id }}"
                        name="qty" value="1"> <span class="quantity_cart" id="quantity{{ $product->id }}">
                        @if ($product->format == 1)
                            {{ $quantity * 100 }} g
                        @else
                            {{ $quantity * 1 }}
                        @endif
                    </span> <i class="fa-solid fa-plus add_quantity plus" productId="{{ $product->id }}"
                        productprice="{{ $product->discount_price }}" id="plus"></i>
                </div>

                <div class=" add-to-cart{{ $product->id }}"
                    style="{{ App\Helpers\Cart::has_pro($product->id) ? 'display:none;' : '' }}">
                    <button class="add-to-cart"
                        onclick="addToCart({{ $product->id }}, {{ $product->discount_price }})"
                        @if ($product->product_quantity < 1) disabled @endif id="{{ $product->id }}"
                        data-id="{{ $product->id }}" data-price="{{ $product->discount_price }}">
                        @if ($product->product_quantity < 1)
                            {{ __('home.product.button.soldout') }}
                        @else
                            {{ __('home.product.button.add') }}
                        @endif
                    </button>
                </div>
            @endif


        </div>

    </div>
</div>
