@php
    use App\Models\Admins\Rating;
    $product_url = url('/') . '/product/' . $product->slug;
    $product_name = app()->isLocale('ar') ? $product->name_ar : $product->product_name;
@endphp

<div class="card" style="position: relative;">
    
    <a href="{{ $product_url }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2;"></a>

    <div class="card_container" style="background-color: white">
        <div class="card_image">
            @php
                $discount_price = $product->discount_price;
                $selling_price = $product->selling_price;
                $discount_percentage = ($selling_price > 0) ? round((($selling_price - $discount_price) / $selling_price) * 100) : 0;
            @endphp
            
            @if ($discount_percentage > 0)
                <button class="floating-btn" style="position: relative; z-index: 3;">Save {{ $discount_percentage }}%</button>
            @endif

            <div class="product_slider" style="z-index: 1;">
                <img src="{{ asset($product->image_one) }}?v={{ strtotime($product->updated_at) }}"
                     title="{{ $product_name }}" alt="{{ $product_name }}"
                     class="product_slider_image active" loading="lazy">
            </div>
        </div>

        <div class="card_content">
            <h4 class="product-name">{{ $product_name }}</h4>

            <p class="rats">
                <span class="icon-aed">{{ getSetting('currency') }}</span> <span>{{ $product->discount_price }}</span>
                @if ($product->selling_price > 0)
                    <del class="ml"><span class="icon-aed">{{ getSetting('currency') }}</span><span>{{ $product->selling_price }}</span></del>
                @endif
            </p>

            <div style="position: relative; z-index: 3;">
                @if (request()->is('cart'))
                    {{-- Quantity controls här (samma som din gamla kod) --}}
                    <div class="quantity quantity-controls">
                        </div>
                @else
                    <div class="add-to-cart{{ $product->id }}">
                        <button class="add-to-cart" onclick="addToCart({{ $product->id }}, {{ $product->discount_price }})">
                            {{ $product->product_quantity < 1 ? __('home.product.button.soldout') : __('home.product.button.add') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
