@extends('layout.app')

<?php
use App\Models\Catagorie;
use App\Models\Subcatagorie;
use App\Models\Childcatagorie;
use App\Models\Admins\Category;
use App\Models\Admins\Gallerie;
use App\Models\Admins\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Admins\Setting;
use App\Models\Admins\Rating;
?>


@section('content')
    <!-- Page Header Start -->
    <style>
        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .viewed-text {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .progress-bar-container {
            width: 80%;
            background-color: #e0e0e0;
            height: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .progress-bar {
            height: 10px;
            background-color: #000;
            border-radius: 5px;
        }

        .load-more-btn {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 10px 20px;
            cursor: pointer;
            color: #000 border-radius: 5px;
        }

        .load-more-btn:hover {
            background-color: #e0e0e0;
        }
    </style>

    <div class="main-container">
        <div class="hero-image">
            <div class="headings">
                <h1 class="hero-title">{{ isset($category_id) ? $category_id->name : 'Search' }}</h1>
                <div class="breadcrumbs">
                    <i class="fa fa-home" style="color: white;"></i>
                    <a href="{{ url('/') }}">Home</a>
                    <i class="fa fa-angle-right" style="color: white;"></i>
                    <a href="#" target="_blank">Search</a>
                </div>
            </div>
        </div>

        <div class="limited-container"  style="max-width:unset; background-color: white; z-index: 1; position: relative;">
            <div class="container " >
                <div class="listing_container" style="display: flex; justify-content: center;">
                    <div class="row row-gap30" style="display: none; width:100%;">
                        <div class="filters-container col-12">
                            <div class="filters">
                                @if (count($categories) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>{{ isset($category_id) && isset($cateid) && $cateid == $category_id->id ? $category_id->name : 'Select Category' }}
                                            </p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($categories as $category)
                                                <li class="filter_dropdown-item {{ isset($cateid) && $cateid == $category->id ? 'selected' : '' }}"
                                                    data-filter="category_id" data-value="{{ $category->id }}">
                                                    {{ $category->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (count($product_type) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>Product Type</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($product_type as $v)
                                                <li class="filter_dropdown-item" data-filter="product_type_id"
                                                    data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (count($theme) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>{{ isset($category_id) && isset($themeid) && $category_id->id == $themeid ? $category_id->name : 'Theme' }}
                                            </p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($theme as $v)
                                                <li class="filter_dropdown-item {{ isset($themeid) && $themeid == $v->id ? 'selected' : '' }}"
                                                    data-filter="theme_id" data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (count($package_type) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>Package Type</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($package_type as $v)
                                                <li class="filter_dropdown-item" data-filter="package_type_id"
                                                    data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach


                                        </ul>
                                    </div>
                                @endif
                                @if (count($flavour) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>Flavour</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($flavour as $v)
                                                <li class="filter_dropdown-item {{ isset($flavourid) && $flavourid == $v->id ? 'selected' : '' }}"
                                                    data-filter="flavour_id" data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (count($brand) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>Brand</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($brand as $v)
                                                <li class="filter_dropdown-item" data-filter="brand_id"
                                                    data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (count($color) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>Color</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($color as $v)
                                                <li class="filter_dropdown-item" data-filter="color_id"
                                                    data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach


                                        </ul>
                                    </div>
                                @endif
                                @if (count($basket_type) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>Basket Type</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($basket_type as $v)
                                                <li class="filter_dropdown-item" data-filter="basket_type_id"
                                                    data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach

                                        </ul>
                                    </div>
                                @endif
                                @if (count($size) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>Size</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($size as $v)
                                                <li class="filter_dropdown-item" data-filter="size_id"
                                                    data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach

                                        </ul>
                                    </div>
                                @endif
                                @if (count($format) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>Format</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">
                                            @foreach ($format as $v)
                                                <li class="filter_dropdown-item {{ isset($formatid) && $formatid == $v->id ? 'selected' : '' }}"
                                                    data-filter="format_id" data-value="{{ $v->id }}">
                                                    {{ $v->name }}</li>
                                            @endforeach

                                        </ul>
                                    </div>
                                @endif
                                @if ($slugs)
                                    <div class="filter_dropdown" style="display:none;">
                                        <button class="filter_dropdown-btn">
                                            <p>Slug</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">

                                            <li class="filter_dropdown-item selected" data-filter="slug"
                                                data-value="{{ $slugs }}">
                                                {{ $slugs }}</li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            {{-- <button id="clear-filters" {{ isset($cateid) ? 'disabled' : '' }} class="clear_filters">
                                Clear <i class="fa-solid fa-filter-circle-xmark"></i>
                            </button> --}}
                        </div>
                    </div>

                </div>
            </div>

            {{-- <div class=" container listing_continer" id="search">
                <div class="row row-gap30">
                    @if (!empty($rproducts) && $rproducts->count())
                    @foreach ($rproducts as $k => $v)
                        @if ($v->status == 1)
                            <div class="card-container col-6  col-xs-6 col-sm-4 col-md-4 col-lg-3" style="margin-bottom:32px;">
                                        <div class="card-container">
                                            <a href="<?php echo url('/'); ?>/product/{{ $v->slug }}">
                                                <div class="image">
                                                    <div class="product_slider" style="z-index: 1;">
                                                        <img src="{{ asset($v->image_one) }}" title="" alt="Background Image 1"
                                                            class="product_slider_image active">
                                                        <img src="{{ asset($v->image_one) }}" title="" alt="Background Image 2"
                                                            class="product_slider_image">
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="content">
                                                <a href="<?php echo url('/'); ?>/product/{{ $v->slug }}">
                                                    <p class="product-name">
                                                        {{ $v->product_name }}
                                                    </p>
                                                </a>
                                                <div class="stars rating_stars">
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                </div>
                                                <p class="rats">
                                                    <?php
                                                    $discount_price = $v->discount_price;
                                                    $selling_price = $v->selling_price;

                                                    if ($selling_price > 0) {
                                                        $discount_percentage = round((($selling_price - $discount_price) / $selling_price) * 100);
                                                    } else {
                                                        $discount_percentage = 0;
                                                    }
                                                    ?>
                                                    {{ $v->discount_price }} {{getSetting('currency')}} @if ($selling_price > 0) <del class="ml">{{ $v->selling_price }} {{getSetting('currency')}}</del>
                                                    <span class="red-text">({{$discount_percentage}}% Off)</span>@endif
                                                </p>
                                            </div>
                                            <div class="quantity quantity-controls quantity_btn_box{{$v->id}}" id="quantity_btn_box" style="{{ App\Helpers\Cart::has_pro($v->id) ? '' : 'display:none;' }}" >
                                                <button class="del_btn ion-close" productId="{{$v->id}}">

                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                                @php
                                                    $quantity = App\Helpers\Cart::product_qty($v->id);
                                                    $quantity =  $quantity ?? 1;
                                                @endphp
                                                <i class="fa-solid fa-minus minus_quantity minus" productId="{{$v->id}}" productprice="{{$v->discount_price}}" id="minus"></i>
                                                <input type="hidden" class="form-control form-control-sm bg-secondary text-center" id="spec{{$v->id}}" id="qty" name="qty" value="1">
                                                <span class="quantity_cart" id="quantity{{$v->id}}">@if ($v->format == 1) {{$quantity * 100}} g @else {{$quantity * 1}} @endif</span>
                                                <i class="fa-solid fa-plus add_quantity plus" productId="{{$v->id}}" productprice="{{$v->discount_price}}" id="plus"></i>
                                            </div>
                                            <div class="button" style="{{ App\Helpers\Cart::has_pro($v->id) ? 'display:none;' : '' }}">
                                                <button class="add-to-cart add-to-cart{{$v->id}}" <?php if ($v->product_quantity < 1) {
                                                    echo 'disabled';
                                                } ?>
                                                    id="{{ $v->id }}"><?php if ($v->product_quantity < 1) {
                                                        echo 'Slod Out';
                                                    } else {
                                                        echo 'Add to Bag';
                                                    } ?></button>
                                            </div>
                                        </div>

                            </div>
                        @endif
                        @endforeach
                        <!-- Shop End -->
                    @else
                        <div class="no_product ">
                            <img src="{{ asset('') }}/no_product.png" title="" alt="">

                            <div class="text_section">
                                <h1>No Product Found</h1>
                                <p>There is no product related to your search.
                                    please search something else</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div> --}}
            <div class=" container " style="background: white;
    z-index: 1;max-width:1230px;">
                <div class="listing_continer" style="display: flex; justify-content: center;">
                    <div class="row row-gap30" style="width:100%" id="product-container">

                    </div>
                </div>
            </div>


            <div id="pagination-container" style="margin: 20px auto 40px auto;">
                <!-- Pagination buttons will be dynamically rendered here -->
            </div>

        </div>
    </div>
    <script src="{{ asset('') }}front/product.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {


        const filters = {};
        const productContainer = document.getElementById('product-container');
        const paginationContainer = document.getElementById('pagination-container');

        // Fetch products with filters and pagination
        function fetchProducts(page = 1) {
            const params = new URLSearchParams({
                ...filters,
                page
            }).toString();
            fetch(`{{ url('/') }}/api/fetch-products?${params}`)
                .then(response => response.json())
                .then(data => {
                    renderProducts(data.products, page === 1);
                    renderPagination(data.pagination);
                });
        }

        // Render products dynamically
        function renderProducts(products, replace = false) {
            // document.getElementById("search").style.display = 'none';
            function generateStars(rate) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (rate >= i) {
                        stars += '<i class="fa fa-star checked"></i>'; // Fully filled star
                    } else if (rate > i - 1) {
                        stars +=
                        '<i class="fa fa-star-half-o checked" style="font-size: 16px; font-weight: bolder;"></i>'; // Half-filled star
                    } else {
                        stars += '<i class="fa fa-star"></i>'; // Empty star
                    }
                }
                return stars;
            }
            if (products && products.length > 0) {
                const baseUrl = '<?php echo asset(''); ?>';
                // If replace is true, clear the existing products. Else, append new ones
                if (replace) {
                    productContainer.innerHTML = products.map(product => `
                             <div class=" col-6  col-xs-6 col-sm-4 col-md-4 col-lg-3" >
                                <div class="card-container">
                                 <a href="<?php echo url('/'); ?>/product/${product.slug}">
                                     <div class="image">
                                         <div class="product_slider" style="z-index: 1;">
                                                 <img src="${baseUrl}${product.image_one}?v=${product.updated_at ? new Date(product.updated_at).getTime() / 1000 : ''}" 
                                         title="${product.product_name}" 
                                         alt="${product.product_name}" 
                                         class="product_slider_image active">
                                    <img src="${baseUrl}${product.image_two || product.image_one}?v=${product.updated_at ? new Date(product.updated_at).getTime() / 1000 : ''}" 
                                         title="${product.product_name}" 
                                         alt="${product.product_name}" 
                                         class="product_slider_image">
                                         </div>
                                     </div>
                                 </a>
                                 <div class="content">
                                     <a href="<?php echo url('/'); ?>/product/${product.slug}">
                                         <p class="product-name">${product.product_name}</p>
                                     </a>
                                     <div class="stars rating_stars">
                                         ${generateStars(product.average_rating)}
                                     </div>
                                     <p class="rats">${product.discount_price} {{ getSetting('currency') }} ${product.selling_price > 0 ? `<del>${product.selling_price} {{ getSetting('currency') }}</del>` : ''}</p>
                                 </div>
                                 <div class="quantity quantity-controls quantity_btn_box${product.id}" id="quantity_btn_box" style="${product.in_cart ? '' : 'display:none;'}">
                            <div class="button_spin_overlay" id="button_loader${product.id}" style="display:none;">
                                <div class="loader_dots"></div>
                            </div>
                            <button class="del_btn ion-close" productId="${product.id}" style="${product.cart_quantity == 1 ? 'display:none;' : ''}">

                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <i class="fa-solid fa-minus minus_quantity minus" productId="${product.id}" productprice="${product.selling_price}" id="minus"></i>
                            <input type="hidden" class="form-control form-control-sm bg-secondary text-center" id="spec${product.id}" id="qty" name="qty" value="1">
                            <span class="quantity_cart" id="quantity${product.id}">${product.in_cart_quantity }</span>
                            <i class="fa-solid fa-plus add_quantity plus" productId="${product.id}" productprice="${product.selling_price}" id="plus"></i>
                        </div>
                        <div class="button add-to-cart${product.id}" style="${product.in_cart ? 'display:none;' : ''}">
                            <button class="add-to-cart " data-id="${product.id}" ${product.product_quantity < 1 ? 'disabled' : ''}>
                                ${product.product_quantity < 1 ? 'Sold Out' : 'Add to Bag'}
                            </button>
                        </div>
                             </div> </div>
                         `).join('');
                } else {
                    productContainer.innerHTML += products.map(product => `
                             <div class=" col-6  col-xs-6 col-sm-4 col-md-4 col-lg-3" >
                                <div class="card-container">
                                 <a href="<?php echo url('/'); ?>/product/${product.slug}">
                                     <div class="image">
                                         <button class="floating-btn">Sale</button>
                                         <div class="product_slider" style="z-index: 1;">
                                                 <img src="${baseUrl}${product.image_one}?v=${product.updated_at ? new Date(product.updated_at).getTime() / 1000 : ''}" 
                                         title="${product.product_name}" 
                                         alt="${product.product_name}" 
                                         class="product_slider_image active">
                                    <img src="${baseUrl}${product.image_two || product.image_one}?v=${product.updated_at ? new Date(product.updated_at).getTime() / 1000 : ''}" 
                                         title="${product.product_name}" 
                                         alt="${product.product_name}" 
                                         class="product_slider_image">
                                         </div>
                                     </div>
                                 </a>
                                 <div class="content">
                                     <a href="<?php echo url('/'); ?>/product/${product.slug}">
                                         <p class="product-name">${product.product_name}</p>
                                     </a>
                                     <div class="stars rating_stars">
                                         ${generateStars(product.average_rating)}
                                     </div>
                                     <p class="rats">${product.discount_price} {{ getSetting('currency') }} ${product.selling_price > 0 ? `<del>${product.selling_price} {{ getSetting('currency') }}</del>` : ''}</p>
                                 </div>
                                 <div class="quantity quantity-controls quantity_btn_box${product.id}" id="quantity_btn_box" style="${product.in_cart ? '' : 'display:none;'}">
                                    <div class="button_spin_overlay" id="button_loader${product.id}" style="display:none;">
                                        <div class="loader_dots"></div>
                                    </div>
                                    <button class="del_btn ion-close" productId="${product.id}"
                                        style="${product.cart_quantity == 1 ? 'display:none;' : 'display:inline;'}">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                    <i class="fa-solid fa-minus minus_quantity minus" productId="${product.id}"
                                        style="${product.cart_quantity > 1 ? 'display:none;' : 'display:inline;'}"
                                        productprice="${product.selling_price}" id="minus"></i>
                                    <input type="hidden" class="form-control form-control-sm bg-secondary text-center" id="spec${product.id}" id="qty" name="qty" value="1">
                                    <span class="quantity_cart" id="quantity${product.id}">${product.in_cart_quantity }</span>
                                    <i class="fa-solid fa-plus add_quantity plus" productId="${product.id}" productprice="${product.selling_price}" id="plus"></i>
                                </div>
                                <div class="button add-to-cart${product.id}" style="${product.in_cart ? 'display:none;' : ''}">
                                    <button class="add-to-cart " data-id="${product.id}" ${product.product_quantity < 1 ? 'disabled' : ''}>
                                        ${product.product_quantity < 1 ? 'Sold Out' : 'Add to Bag'}
                                    </button>
                                </div>
                             </div> </div>
                         `).join('');
                }

                const quantityControls = document.querySelectorAll(".quantity-controls");

                quantityControls.forEach((controller) => {
                    const minusBtn = controller.querySelector("#minus");
                    const delBtn = controller.querySelector(".del_btn");
                    const plusBtn = controller.querySelector("#plus");
                    const quantityDisplay = controller.querySelector(".quantity_cart");
                    const originalQuantity = quantityDisplay.innerHTML;

                    let quantity = parseInt(quantityDisplay.innerHTML);

                    const updateVisibility = () => {
                        if (originalQuantity.endsWith("g")) {
                            if (quantity > 100) {
                                delBtn.style.display = "none";
                                minusBtn.style.display = "inline";
                            } else {
                                delBtn.style.display = "inline";
                                minusBtn.style.display = "none";
                            }
                        } else {
                            if (quantity > 1) {
                                delBtn.style.display = "none";
                                minusBtn.style.display = "inline";
                            } else {
                                delBtn.style.display = "inline";
                                minusBtn.style.display = "none";
                            }
                        }
                    };

                    updateVisibility();

                    minusBtn.addEventListener("click", () => {
                        if (originalQuantity.endsWith("g")) {
                            if (quantity > 100) {
                                quantity -= 100;
                                quantityDisplay.textContent = `${quantity} g`;
                                updateVisibility();
                            }
                        } else {
                            quantity--;
                            quantityDisplay.textContent = quantity;
                            updateVisibility();
                        }
                    });

                    plusBtn.addEventListener("click", () => {
                        if (originalQuantity.endsWith("g")) {
                            quantity += 100;
                            quantityDisplay.textContent = `${quantity} g`;
                        } else {
                            quantity++;
                            quantityDisplay.textContent = quantity;
                        }
                        updateVisibility();
                    });
                });

                // Reattach click events to new elements
                const addToCartButtons = document.querySelectorAll(".add-to-cart");
                addToCartButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        const productId = this.getAttribute("data-id");
                        addToCartShop(productId);
                    });
                });

                const plus = document.querySelectorAll(".plus");
                plus.forEach(button => {
                    button.addEventListener("click", function() {
                        const productId = this.getAttribute("productId");
                        increment(productId);
                    });
                });

                const minus = document.querySelectorAll(".minus");
                minus.forEach(button => {
                    button.addEventListener("click", function() {
                        const productId = this.getAttribute("productId");
                        decrement(productId);
                    });
                });

                const close = document.querySelectorAll(".ion-close");
                close.forEach(button => {
                    button.addEventListener("click", function() {
                        const productId = this.getAttribute("productId");
                        remove(productId);
                    });
                });

                const product_slider = document.querySelectorAll(".product_slider");
                product_slider.forEach((slide) => {
                    slide.addEventListener("mouseover", () => {
                        const slider_images = slide.querySelectorAll(".product_slider_image");
                        slider_images[0].classList.remove("active");
                        slider_images[1].classList.add("active");
                    });

                    slide.addEventListener("mouseout", () => {
                        const slider_images = slide.querySelectorAll(".product_slider_image");
                        slider_images[1].classList.remove("active");
                        slider_images[0].classList.add("active");
                    });
                });
            } else {
                productContainer.innerHTML = `
                         <div class="no_product" style="margin:10px auto;">
                             <img src="{{ asset('') }}/no_product.png" title="no_product" alt="no_product">
                             <div class="text_section">
                                 <h1>No Product Found</h1>
                                 <p>There is no product.</p>
                             </div>
                         </div>
                     `;
            }
        }

        function addToCartShop(productId) {
            fetch("<?php echo url('/'); ?>/cart/add", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        // Handle error case
                        console.error("Error adding to cart:", data.error);
                    } else {
                        // Update cart UI
                        $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(data.qty);
                        $('.quantity_btn_box' + productId).show();
                        $('.add-to-cart' + productId).hide();

                        // Quantity controls logic
                        const quantityControls = document.querySelectorAll(".quantity-controls");

                        quantityControls.forEach((controller) => {
                            const minusBtn = controller.querySelector("#minus");
                            const delBtn = controller.querySelector(".del_btn");
                            const plusBtn = controller.querySelector("#plus");
                            const quantityDisplay = controller.querySelector(".quantity_cart");
                            const originalQuantity = quantityDisplay.innerHTML;

                            let quantity = parseInt(quantityDisplay.innerHTML);

                            const updateVisibility = () => {
                                if (originalQuantity.endsWith("g")) {
                                    if (quantity > 100) {
                                        delBtn.style.display = "none";
                                        minusBtn.style.display = "inline";
                                    } else {
                                        delBtn.style.display = "inline";
                                        minusBtn.style.display = "none";
                                    }
                                } else {
                                    if (quantity > 1) {
                                        delBtn.style.display = "none";
                                        minusBtn.style.display = "inline";
                                    } else {
                                        delBtn.style.display = "inline";
                                        minusBtn.style.display = "none";
                                    }
                                }
                            };

                            updateVisibility();

                            minusBtn.addEventListener("click", () => {
                                if (originalQuantity.endsWith("g")) {
                                    if (quantity > 100) {
                                        quantity -= 100;
                                        quantityDisplay.textContent = `${quantity} g`;
                                        updateVisibility();
                                    }
                                } else {
                                    quantity--;
                                    quantityDisplay.textContent = quantity;
                                    updateVisibility();
                                }
                            });

                            plusBtn.addEventListener("click", () => {
                                if (originalQuantity.endsWith("g")) {
                                    quantity += 100;
                                    quantityDisplay.textContent = `${quantity} g`;
                                } else {
                                    quantity++;
                                    quantityDisplay.textContent = quantity;
                                }
                                updateVisibility();
                            });
                        });

                        // Trigger confetti
                        const button = document.querySelector(`.quantity_btn_box${productId}`);
                        if (button) {
                            const rect = button.getBoundingClientRect();
                            const x = rect.left + rect.width / 2; // Button's center x
                            const y = rect.top + rect.height / 2; // Button's center y

                            confetti({
                                particleCount: 50, // Fewer particles
                                startVelocity: 15, // Lower velocity
                                spread: 360, // Full spread
                                gravity: 0, // Prevent confetti from falling down
                                ticks: 100, // Short lifespan
                                origin: {
                                    x: x / window.innerWidth, // Relative x position
                                    y: y / window.innerHeight, // Relative y position
                                },
                                scalar: 0.8, // Smaller particle size
                            });
                        }
                    }
                })
                .catch(error => {
                    // Handle fetch error
                    console.error("Error adding to cart:", error);
                });
        }


        function increment(productId) {
            let id, qty, price, productTotal;
            $('#button_loader' + productId).css('display', 'flex').show();
            $('#loader_container_overlay').css('display', 'flex').show();
            fetch("{{ url('cart/increment') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    setTimeout(() => {

                        $('#button_loader' + productId).hide();
                        $('#loader_container_overlay').hide();
                    }, 1000);
                    if (data.error) {

                    } else {
                        qty = $('#spec' + id).val();
                        let item = data.cart.items.find(item => item.id == productId);
                        if (item) {
                            // document.getElementById("quantity" + productId).textContent = item.qty;
                        } else {
                            console.error("Item with id " + id + " not found in the cart.");
                        }
                        // showToastr(data.msg, data.msg_type);
                        document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab').forEach(
                            function(el) {
                                el.innerHTML = data.cart.qty;
                            });
                        // Quantity controls logic
                        const quantityControls = document.querySelectorAll(".quantity-controls");

                        console.log(quantityControls, ">>>>");
                        quantityControls.forEach((controller) => {

                            const minusBtn = controller.querySelector("#minus");
                            const delBtn = controller.querySelector(".del_btn");
                            const plusBtn = controller.querySelector("#plus");
                            const quantityDisplay = controller.querySelector(".quantity_cart");
                            let quantity = parseInt(quantityDisplay.innerHTML);

                            const updateVisibility = () => {
                                if (quantity > 1) {
                                    delBtn.style.display = "none";
                                    minusBtn.style.display = "inline";
                                } else {
                                    delBtn.style.display = "inline";
                                    minusBtn.style.display = "none";
                                }
                            };

                            updateVisibility();

                            minusBtn.addEventListener("click", () => {
                                if (quantity > 1) {
                                    quantity--;
                                    quantityDisplay.textContent = quantity;
                                    updateVisibility();
                                }
                            });

                            plusBtn.addEventListener("click", () => {
                                quantity++;
                                quantityDisplay.textContent = quantity;
                                updateVisibility();
                            });
                        });
                    }
                })
                .catch(error => {
                    // console.error("Error adding to cart:", error);
                    // alert("An error occurred while adding the product to the cart.");
                });

        }

        function decrement(productId) {
            let id, qty, price, productTotal;
            $('#button_loader' + productId).css('display', 'flex').show();
            $('#loader_container_overlay').css('display', 'flex').show();
            fetch("{{ url('cart/decrement') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    setTimeout(() => {

                        $('#button_loader' + productId).hide();
                        $('#loader_container_overlay').hide();
                    }, 1000);
                    if (data.error) {

                    } else {
                        let item = data.cart.items.find(item => item.id == productId);
                        if (item) {
                            // document.getElementById("quantity" + productId).textContent = item.qty;
                        } else {
                            console.error("Item with id " + id + " not found in the cart.");
                        }
                        document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab').forEach(
                            function(el) {
                                el.innerHTML = data.cart.qty;
                            });
                        // Quantity controls logic
                        const quantityControls = document.querySelectorAll(".quantity-controls");

                        console.log(quantityControls, ">>>>");
                        quantityControls.forEach((controller) => {
                            // console.log(controller, "hello");

                            const minusBtn = controller.querySelector("#minus");
                            const delBtn = controller.querySelector(".del_btn");
                            const plusBtn = controller.querySelector("#plus");
                            const quantityDisplay = controller.querySelector(".quantity_cart");
                            let quantity = parseInt(quantityDisplay.innerHTML);

                            const updateVisibility = () => {
                                if (quantity > 1) {
                                    delBtn.style.display = "none";
                                    minusBtn.style.display = "inline";
                                } else {
                                    delBtn.style.display = "inline";
                                    minusBtn.style.display = "none";
                                }
                            };

                            updateVisibility();

                            minusBtn.addEventListener("click", () => {
                                if (quantity > 1) {
                                    quantity--;
                                    quantityDisplay.textContent = quantity;
                                    updateVisibility();
                                }
                            });

                            plusBtn.addEventListener("click", () => {
                                quantity++;
                                quantityDisplay.textContent = quantity;
                                updateVisibility();
                            });
                        });
                    }
                })
                .catch(error => {
                    // console.error("Error adding to cart:", error);
                    // alert("An error occurred while adding the product to the cart.");
                });
        }

        function remove(productId) {
            let id, qty, price, productTotal;
            // $('#loader_container').css('display', 'flex').show();
            $('#loader_container_overlay').css('display', 'flex').show();
            $('#button_loader' + productId).css('display', 'flex').show();
            fetch("{{ url('cart/remove') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {

                    if (data.error) {

                    } else {
                        if (data.cart === null) {
                            document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab')
                                .forEach(function(el) {
                                    el.innerHTML = 0;
                                });
                            document.querySelector(".quantity_btn_box" + productId).style.display = "none";
                            document.querySelector(".add-to-cart" + productId).style.display = "unset";
                            $('#loader_container_overlay').hide();
                            $('#button_loader' + productId).hide();
                            // $('#loader_container').hide();
                        } else {
                            document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab')
                                .forEach(function(el) {
                                    el.innerHTML = data.cart.qty;
                                });
                            document.querySelector(".quantity_btn_box" + productId).style.display = "none";
                            document.querySelector(".add-to-cart" + productId).style.display = "unset";
                            $('#loader_container_overlay').hide();
                            $('#button_loader' + productId).hide();
                            // $('#loader_container').hide();
                        }

                    }
                })
                .catch(error => {
                    // console.error("Error adding to cart:", error);
                    // alert("An error occurred while adding the product to the cart.");
                });
        }

        function renderPagination(pagination) {
            const {
                current_page,
                per_page,
                total
            } = pagination;
            const viewedProducts = current_page * per_page > total ? total : current_page * per_page;
            const progressPercentage = (viewedProducts / total) * 100;

            if (current_page < pagination.last_page) {
                paginationContainer.innerHTML = `
                         <div class="pagination-wrapper">
                             <div class="viewed-text">You've viewed ${viewedProducts} of ${total} products</div>
                             <div class="progress-bar-container">
                                 <div class="progress-bar" style="width: ${progressPercentage}%;"></div>
                             </div>
                             <button id="load-more-btn" class="load-more-btn">Load more</button>
                         </div>
                     `;

                document.getElementById('load-more-btn').addEventListener('click', function() {
                    fetchProducts(current_page + 1);
                });
            } else {
                paginationContainer.innerHTML = `
                         <div class="pagination-wrapper">
                             <div class="viewed-text"></div>
                         </div>
                     `;
            }
        }

        // Event listener for filters
        document.querySelectorAll('.filter_dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const filter = this.dataset.filter;
                const value = this.dataset.value;

                if (value) {
                    filters[filter] = value;
                } else {
                    delete filters[filter];
                }

                fetchProducts();
            });
        });

        function initializeFilter() {
            document.querySelectorAll('.filter_dropdown-item').forEach(item => {
                const filter = item.dataset.filter;
                const value = item.dataset.value;

                if (item.classList.contains('selected')) {
                    filters[filter] = value;
                } else {
                    delete filters[filter];
                }
            });
        }

        function initializeFilters() {
            document.querySelectorAll('.filter_dropdown-item').forEach(item => {
                const filter = item.dataset.filter;
                const value = item.dataset.value;

                if (item.classList.contains('selected')) {
                    filters[filter] = value;
                }
            });
        }

        // Event listener for pagination
        paginationContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('pagination-btn')) {
                const page = e.target.dataset.page;
                fetchProducts(page);
            }
        });

        // Initial fetch
        initializeFilters();
        fetchProducts();

        // document.getElementById('clear-filters').addEventListener('click', function() {
        //     Object.keys(filters).forEach(key => delete filters[key]);
        //     document.querySelectorAll('.filter_dropdown-item.selected').forEach(item => {
        //         item.classList.remove('selected');
        //     });
        //     fetchProducts();
        // });
        // });
    </script>
    <script src="{{ asset('') }}front/product.js"></script>
@endsection
