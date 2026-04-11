@php
    use App\Models\Admins\Rating;
    $product_url = url('/') . '/product/' . $product->slug;
    $product_name = app()->isLocale('ar') ? $product->name_ar : $product->product_name;
    
    $discount_price = $product->discount_price;
    $selling_price = $product->selling_price;
    $discount_percentage = ($selling_price > 0) ? round((($selling_price - $discount_price) / $selling_price) * 100) : 0;
@endphp

<div class="card" style="height: 100%;">
    <a href="{{ $product_url }}" style="display: block; text-decoration: none; color: inherit;">
        <div class="card_container" style="background-color: white">

            <div class="card_image">
                @if ($discount_percentage > 0)
                    <button class="floating-btn" style="pointer-events: none;">Save {{ $discount_percentage }}%</button>
                @endif

                <div class="product_slider">
                    <img src="{{ asset($product->image_one) }}?v={{ strtotime($product->updated_at) }}"
                        title="{{ $product_name }}"
                        alt="{{ $product_name }}"
                        class="product_slider_image active" loading="lazy">
                </div>
            </div>

            <div class="card_content">
                <h4 class="product-name" style="margin-bottom: 5px;">
                    {{ $product_name }}
                </h4>

                <p class="rats">
                    <span class="icon-aed">{{ getSetting('currency') }}</span> <span>{{ $discount_price }}</span>
                    @if ($selling_price > 0)
                        <del class="ml">
                            <span class="icon-aed">{{ getSetting('currency') }}</span><span>{{ $selling_price }}</span>
                        </del>
                    @endif
                </p>
            </div>
        </div>
    </a> 
    {{-- Köp-sektionen ligger utanför <a> så att den inte krockar med produktlänken --}}
    <div class="card_content" style="padding-top: 0;">
        @php
            $has_pro = App\Helpers\Cart::has_pro($product->id);
            $quantity = App\Helpers\Cart::product_qty($product->id) ?? 1;
        @endphp

        <div class="quantity-wrapper" style="min-height: 45px;">
            {{-- Plus/Minus Kontroller --}}
            <div class="quantity quantity-controls quantity_btn_box{{ $product->id }}" 
                 style="{{ $has_pro ? 'display: flex;' : 'display:none;' }}">
                
                <button class="del_btn ion-close" productId="{{ $product->id }}">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
                
                <i class="fa-solid fa-minus minus_quantity" productId="{{ $product->id }}" productprice="{{ $discount_price }}"></i>
                <span class="quantity_cart" id="quantity{{ $product->id }}">
                    {{ $product->format == 1 ? ($quantity * 100) . ' g' : $quantity }}
                </span>
                <i class="fa-solid fa-plus add_quantity" productId="{{ $product->id }}" productprice="{{ $discount_price }}"></i>
            </div>

            {{-- Add to Cart Knapp --}}
            <div class="add-to-cart{{ $product->id }}" style="{{ $has_pro ? 'display:none;' : 'display: block;' }}">
                <button class="add-to-cart" 
                        onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }}, {{ $discount_price }})" 
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
