@extends('layout.app')
@section('content')
    <?php
    use App\Models\Admins\Category;
    $cate = Category::limit('6')->get();
    ?>
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
            max-width: 200px;
        }

        .progress-bar {
            height: 10px;
            background-color: #000;
            border-radius: 5px;
        }

        .load-more-btn {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            color: #000;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .load-more-btn:hover {
            background-color: #e0e0e0;
        }
    </style>

    <div class="main-container">

        <x-hero-section :title="isset($category_id)
            ? (app()->isLocale('ar')
                ? $category_id->name_ar
                : $category_id->name)
            : (isset($slugs)
                ? $slugs
                : __('page_shop.hero.shop_title'))" :backgroundImage="isset($category_id) && $category_id->banner
            ? asset($category_id->banner)
            : asset('front/assets/images/faqsheroimage.webp')" :subTitle="isset($category_id)
            ? (app()->isLocale('ar')
                ? $category_id->sub_title_ar
                : $category_id->sub_title)
            : ''" />

        <div class="product_listing">
            <div class="container">
                <div class="">
                    <div class="row" style="display: none">
                        <div class="filters-container">
                            <div class="filters">
                                @if (count($categories) > 0)
                                    <div class="filter_dropdown">
                                        <button class="filter_dropdown-btn">
                                            <p>{{ isset($category_id) && isset($cateid) && $cateid == $category_id->id ? $category_id->name : __('page_shop.filters.select_category') }}
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
                                            <p>{{ __('page_shop.filters.product_type') }}</p>
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
                                            <p>{{ isset($category_id) && isset($themeid) && $category_id->id == $themeid ? $category_id->name : __('page_shop.filters.theme') }}
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
                                            <p>{{ __('page_shop.filters.package_type') }}</p>
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
                                            <p>{{ __('page_shop.filters.flavour') }}</p>
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
                                            <p>{{ __('page_shop.filters.brand') }}</p>
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
                                            <p>{{ __('page_shop.filters.color') }}</p>
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
                                            <p>{{ __('page_shop.filters.basket_type') }}</p>
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
                                            <p>{{ __('page_shop.filters.size') }}</p>
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
                                            <p>{{ __('page_shop.filters.format') }}</p>
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
                                @if (isset($cateid))
                                    <div class="filter_dropdown" style="display:none;">
                                        <button class="filter_dropdown-btn">
                                            <p>{{ __('page_shop.filters.selected_category') }}</p>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="filter_dropdown-menu">

                                            <li class="filter_dropdown-item selected" data-filter="selected_cate"
                                                data-value="{{ $cateid }}">
                                                {{ $cateid }}</li>
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($slugs))
                                    <div class="filter_dropdown" style="display:none;">
                                        <button class="filter_dropdown-btn">
                                            <p>{{ __('page_shop.filters.selected_category') }}</p>
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

            <div class="container">
                <div class="row" id="product-container"></div>
            </div>




            <div id="pagination-container" style="margin: 0px auto 40px auto;">
                <!-- Pagination buttons will be dynamically rendered here -->
            </div>

            <div class="container">
                <div class="category_detail">
                    <div class="category_detail_body">

                        {!! isset($category_id)
                            ? (app()->isLocale('ar')
                                ? $category_id->description_ar
                                : $category_id->description)
                            : '' !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Shop End -->
    <script>
        /* ============================================================
                                                               GLOBAL VARIABLES
                                                            ============================================================ */
        const productContainer = document.getElementById('product-container');
        const paginationContainer = document.getElementById('pagination-container');
        const filters = {};

        const i18n = {
            add_to_bag: @json(__('page_shop.buttons.add_to_bag')),
            sold_out: @json(__('page_shop.buttons.sold_out')),
            no_product_title: @json(__('page_shop.no_products.title')),
            no_product_desc: @json(__('page_shop.no_products.description')),
            viewed_prefix: @json(__('page_shop.pagination.viewed_prefix')),
            viewed_of: @json(__('page_shop.pagination.viewed_of')),
            viewed_suffix: @json(__('page_shop.pagination.viewed')),
            load_more: @json(__('page_shop.pagination.load_more')),
        };


        /* ============================================================
           FETCH PRODUCTS (API)
        ============================================================ */
        function fetchProducts(page = 1) {
            const params = new URLSearchParams({
                ...filters,
                page
            }).toString();

            fetch(`{{ url('/') }}/api/fetch-products?${params}`)
                .then(res => res.json())
                .then(data => {
                    renderProducts(data.html, page === 1);
                    renderPagination(data.pagination);
                });
        }


        /* ============================================================
           RENDER PRODUCT CARDS
        ============================================================ */
        function renderProducts(html, replace = false) {
            if (replace) productContainer.innerHTML = html;
            else productContainer.insertAdjacentHTML("beforeend", html);

            attachProductEvents();
            initQuantityControls();
        }


        /* ============================================================
           PAGINATION / LOAD MORE
        ============================================================ */
        function renderPagination(p) {
            const viewed = Math.min(p.current_page * p.per_page, p.total);
            const progress = (viewed / p.total) * 100;

            const viewedText =
                `${i18n.viewed_prefix} ${viewed} ${i18n.viewed_of} ${p.total} ${i18n.viewed_suffix}`;

            if (p.current_page < p.last_page) {
                paginationContainer.innerHTML = `
            <div class="pagination-wrapper">
                <div class="viewed-text">${viewedText}</div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width:${progress}%"></div>
                </div>
                <button id="load-more-btn" class="load-more-btn">${i18n.load_more}</button>
            </div>`;

                document.getElementById("load-more-btn").onclick = () =>
                    fetchProducts(p.current_page + 1);
            } else {
                paginationContainer.innerHTML = `
            <div class="pagination-wrapper"><div class="viewed-text"></div></div>
        `;
            }
        }


        /* ============================================================
           ATTACH EVENTS (cart + sliders)
        ============================================================ */
        function attachProductEvents() {

            /* ADD TO CART */
            document.querySelectorAll(".add-to-cart").forEach(btn => {
                btn.onclick = () =>
                    addToCartShop(btn.dataset.id, btn.dataset.price);
            });

            /* PLUS (shop cards on /cart use plus_1) */
            document.querySelectorAll(".plus, .plus_1").forEach(btn => {
                btn.onclick = () =>
                    increment(btn.getAttribute("productId"));
            });

            /* MINUS */
            document.querySelectorAll(".minus, .minus_1").forEach(btn => {
                btn.onclick = () =>
                    decrement(btn.getAttribute("productId"));
            });

            /* REMOVE (product-card trash uses layout .ion-close delegation) */
            document.querySelectorAll(".del_btn").forEach(btn => {
                if (btn.classList.contains("product-card__pre-del")) return;
                btn.onclick = () =>
                    remove(btn.getAttribute("productId"));
            });

            /* IMAGE SLIDER HOVER */
            document.querySelectorAll(".product_slider").forEach(slider => {
                const imgs = slider.querySelectorAll(".product_slider_image");
                if (imgs.length < 2) return;

                slider.onmouseover = () => {
                    imgs[0].classList.remove("active");
                    imgs[1].classList.add("active");
                };

                slider.onmouseout = () => {
                    imgs[1].classList.remove("active");
                    imgs[0].classList.add("active");
                };
            });
        }


        /* ============================================================
           QUANTITY CONTROL WITH GRAM LOGIC
        ============================================================ */
        function initQuantityControls() {
            const controllers = document.querySelectorAll(".quantity-controls");

            controllers.forEach(controller => {
                const minusBtn = controller.querySelector(".minus, .minus_1");
                const plusBtn = controller.querySelector(".plus, .plus_1");
                const delBtn = controller.querySelector(".del_btn");
                const qtyDisplay = controller.querySelector(".quantity_cart");

                if (!minusBtn || !plusBtn || !delBtn || !qtyDisplay) return;

                const isGram = controller.dataset.qtyGrams === "1";

                const readQty = () => {
                    const raw =
                        qtyDisplay.tagName === "INPUT"
                            ? qtyDisplay.value
                            : qtyDisplay.textContent.trim().replace(/\s*g\s*$/i, "");
                    let n = parseInt(raw, 10);
                    if (Number.isNaN(n)) {
                        n = isGram ? 100 : 1;
                    }
                    return n;
                };

                const writeQty = (n) => {
                    if (qtyDisplay.tagName === "INPUT") {
                        qtyDisplay.value = String(n);
                    } else if (isGram) {
                        qtyDisplay.textContent = `${n} g`;
                    } else {
                        qtyDisplay.textContent = String(n);
                    }
                };

                function updateVisibility() {
                    const qty = readQty();

                    if (isGram) {
                        if (qty > 100) {
                            minusBtn.style.display = "inline";
                            delBtn.style.display = "none";
                        } else {
                            minusBtn.style.display = "none";
                            delBtn.style.display = "inline";
                        }
                    } else {
                        if (qty > 1) {
                            minusBtn.style.display = "inline";
                            delBtn.style.display = "none";
                        } else {
                            minusBtn.style.display = "none";
                            delBtn.style.display = "inline";
                        }
                    }
                }

                updateVisibility();

                /* MINUS */
                minusBtn.addEventListener("click", () => {
                    let qty = readQty();

                    if (isGram) {
                        if (qty > 100) qty -= 100;
                    } else if (qty > 1) {
                        qty -= 1;
                    }

                    writeQty(qty);
                    updateVisibility();
                });

                /* PLUS */
                plusBtn.addEventListener("click", () => {
                    let qty = readQty();

                    if (isGram) {
                        qty += 100;
                    } else {
                        qty += 1;
                    }

                    const maxAttr = qtyDisplay.getAttribute("max");
                    const maxVal = maxAttr !== null ? parseInt(maxAttr, 10) : NaN;
                    if (!Number.isNaN(maxVal) && qty > maxVal) {
                        qty = maxVal;
                    }

                    writeQty(qty);
                    updateVisibility();
                });
            });
        }


        /* ============================================================
           CART FUNCTIONS
        ============================================================ */
        function addToCartShop(productId, price) {
            const buyStackEl = document.querySelector(".add-to-cart" + productId);
            if (buyStackEl && buyStackEl.getAttribute("data-line-in-cart") === "1" &&
                typeof window.productCardSyncCartLine === "function") {
                window.productCardSyncCartLine(productId).then(function(data) {
                    if (data && data.cart && typeof data.cart.qty !== "undefined") {
                        updateCartCount(data.cart.qty);
                    }
                });
                return;
            }
            const specEl = document.getElementById("spec" + productId);
            const qtyVal = specEl ? (parseInt(specEl.value, 10) || 1) : 1;
            const doConfettiShop = true;
            fetch("{{ url('/cart/add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId,
                        qty: qtyVal
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        if (typeof showToastr === "function") {
                            showToastr(data.error_data || "Unable to add to cart", "danger");
                        }
                        return;
                    }
                    if (typeof showToastr === "function" && data.msg) {
                        showToastr(data.msg, data.msg_type || "success");
                    }
                    if (data.cart && data.cart.items) {
                        const rawItems = data.cart.items;
                        const list = Array.isArray(rawItems) ? rawItems : Object.values(rawItems);
                        const row = list.find((x) => String(x.id) === String(productId));
                        const pcOk = row && typeof window.productCardSetLineState === "function" &&
                            window.productCardSetLineState(productId, true, row);
                        if (!pcOk && row && specEl) {
                            specEl.value = String(row.qty);
                            const preBar = document.querySelector(
                                '.product-card__pre-qty[data-product-id="' + productId + '"]');
                            const isGram = preBar && preBar.getAttribute("data-qty-grams") === "1";
                            const disp = isGram ? String(parseInt(row.qty, 10) * 100) : String(row.qty);
                            const preEl = document.getElementById("product-pre-qty-in-" + productId);
                            if (preEl) preEl.value = disp;
                            const qEl = document.getElementById("quantity" + productId);
                            if (qEl) qEl.value = disp;
                        }
                    }
                    if (doConfettiShop) {
                        const button = document.querySelector(".add-to-cart" + productId +
                                ".product-card__buy-stack") ||
                            document.querySelector(".add-to-cart" + productId) || document.querySelector(
                                `.quantity_btn_box${productId}`);
                        if (button) {
                            const rect = button.getBoundingClientRect();
                            const x = rect.left + rect.width / 2;
                            const y = rect.top + rect.height / 2;

                            confetti({
                                particleCount: 50,
                                startVelocity: 15,
                                spread: 360,
                                gravity: 0,
                                ticks: 100,
                                origin: {
                                    x: x / window.innerWidth,
                                    y: y / window.innerHeight,
                                },
                                scalar: 0.8,
                            });
                        }
                    }

                    updateCartCount(data.qty);
                })
                .catch(() => {
                    if (typeof showToastr === "function") {
                        showToastr("Unable to add to cart", "danger");
                    }
                });
        }


        function increment(productId) {
            $('#button_loader' + productId).css('display', 'flex').show();
            $('#loader_container_overlay').css('display', 'flex').show();
            fetch("{{ url('/cart/increment') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    let el = document.getElementById("quantity" + productId);
                    if (!el) return;
                    setTimeout(() => {
                        $('#loader_container_overlay').hide();
                        $('#button_loader' + productId).hide();
                    }, 1000);

                    let qty = parseInt(el.innerHTML);


                    updateCartCount(data.cart.qty);
                });
        }


        function decrement(productId) {
            $('#button_loader' + productId).css('display', 'flex').show();
            $('#loader_container_overlay').css('display', 'flex').show();
            fetch("{{ url('/cart/decrement') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    let el = document.getElementById("quantity" + productId);
                    if (!el) return;
                    setTimeout(() => {
                        $('#loader_container_overlay').hide();
                        $('#button_loader' + productId).hide();
                    }, 1000);

                    let qty = parseInt(el.innerHTML);
                    qty -= 1;

                    if (qty <= 0) return remove(productId);

                    updateCartCount(data.cart.qty);
                });
        }


        function remove(productId) {
            fetch("{{ url('/cart/remove') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (typeof window.productCardSetLineState === "function") {
                        window.productCardSetLineState(productId, false);
                    }
                    const qtyBox = document.querySelector(".quantity_btn_box" + productId);
                    const addBtn = document.querySelector(".add-to-cart" + productId);
                    if (qtyBox) qtyBox.style.display = "none";
                    if (addBtn && !addBtn.classList.contains("product-card__buy-stack")) {
                        addBtn.style.display = "block";
                    }

                    updateCartCount(data.cart?.qty ?? 0);
                });
        }

        function updateCartCount(qty) {
            document.querySelectorAll("#cartValue, #cartValue1, #cartValue2, #cartValueFab")
                .forEach(x => x.innerHTML = qty);
        }


        /* ============================================================
           FILTERS
        ============================================================ */
        document.querySelectorAll(".filter_dropdown-item").forEach(item => {
            item.onclick = () => {
                const filter = item.dataset.filter;
                const value = item.dataset.value;

                if (value) filters[filter] = value;
                else delete filters[filter];

                fetchProducts();
            };
        });


        /* ============================================================
           INIT PAGE
        ============================================================ */
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".filter_dropdown-item.selected").forEach(i => {
                filters[i.dataset.filter] = i.dataset.value;
            });

            fetchProducts();
        });
    </script>




@endsection
