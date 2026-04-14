        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
        <script>
            var page_link = '{{ $_SERVER['REQUEST_URI'] }}';
            var options = {
                "enabled": true,
                "chatButtonSetting": {
                    "backgroundColor": "#4dc247",
                    "ctaText": "",
                    "borderRadius": "50", // This value will now be used for a circular button
                    "marginLeft": "0",
                    "marginBottom": "10",
                    "marginRight": "20",
                    "position": "right"
                },
                "brandSetting": {
                    "brandName": "{{ $Site->site_title }}",
                    "brandSubTitle": "Typically replies within a day",
                    "brandImg": "{{ asset('') }}{{ getSetting('logo') }}",
                    "welcomeText": "Hi, there!\nHow can I help you?",
                    "messageText": "Hello, I have a question about {{ url('/') . $_SERVER['REQUEST_URI'] }}",
                    "backgroundColor": "#0a5f54",
                    "ctaText": "Start Chat",
                    "borderRadius": "50",
                    "autoShow": false,
                    "phoneNumber": "+971547000534"
                }
            };

            function redirectToWhatsApp() {
                var message = encodeURIComponent(options.brandSetting.messageText);
                var phoneNumber = options.brandSetting.phoneNumber.replace(/\s+/g, '');
                var whatsappUrl = `https://wa.me/${phoneNumber}?text=${message}`;
                window.location.href = whatsappUrl; // Redirects to WhatsApp
            }

            function createWhatsAppButton() {
                var button = document.createElement('button');
                button.innerHTML = `
                   <i class="fab fa-whatsapp" style="color: white; font-size: 20px;"></i>
                `;
                button.setAttribute('title', 'WhatsApp Chat');
                button.style.backgroundColor = options.chatButtonSetting.backgroundColor;
                button.style.borderRadius = "10px"; // Makes the button circular
                button.style.width = "50px"; // Set button width
                button.style.height = "50px"; // Set button height
                button.style.position = "fixed";
                button.style.zIndex = "1000";
                button.style.bottom = options.chatButtonSetting.marginBottom + "px";
                button.style.right = options.chatButtonSetting.marginRight + "px";
                button.style.border = "none";
                button.style.display = "flex";
                button.style.alignItems = "center";
                button.style.justifyContent = "center";
                button.style.cursor = "pointer";
                button.onclick = redirectToWhatsApp;

                document.body.appendChild(button);
            }

            // Defer non-critical DOM manipulation to idle time
            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(createWhatsAppButton);
            } else {
                setTimeout(createWhatsAppButton, 3000);
            }
        </script>




        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/default-passive-events"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        {{-- <script src="{{ asset('') }}front/swiper-bundle.min.js"></script> --}}
        <script src="{{ asset('') }}front/script.js"></script>
        <script src="{{ asset('front/assets/confettis.js') }}"></script>
        <script src="{{ asset('front/assets/slider.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (request()->is('contact-us') ||
                request()->is('login') ||
                request()->is('user_register') ||
                request()->is('about-us') ||
                request()->is('influencers') ||
                request()->is('retailer-reseller') ||
                request()->is('corporate-events') ||
                request()->is('celebrations'))
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif
        {{-- <script>
            document.getElementById('selector-btn').addEventListener('click', function() {
                document.getElementById('lang-dropdown').classList.toggle('show');
            });

            // LOCALE SWITCHER
            document.querySelectorAll('.option.language').forEach(option => {
                option.addEventListener('click', function() {
                    const locale = this.getAttribute('data-locale');

                    fetch('{{ route('locale.switch') }}', {
                            method: 'POST',
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                locale
                            })
                        })
                        .then(res => res.json())
                        .then(() => location.reload())
                        .catch(() => location.reload());
                });
            });

            // Unique IDs
            const selectorBtn = document.getElementById("selector-btn");
            const dropdown = document.getElementById("lang-dropdown");
            const selectedText = document.getElementById("selected-text");
            const selectedFlag = document.getElementById("selected-flag");

            $(selectorBtn).on("click", function() {
                $(dropdown).toggleClass("open");
            });

            // Close when clicking outside
            document.addEventListener("click", (e) => {
                if (!document.getElementById("lang-selector").contains(e.target)) {
                    dropdown.classList.remove("open");
                }
            });

            // Function to handle selection
            function selectOption(type, clickedOption) {
                // Remove selected class from same group
                document.querySelectorAll(`.option.${type}`).forEach(opt => {
                    opt.classList.remove("selected");
                    const tick = opt.querySelector(".tick");
                    if (tick) tick.remove();
                });

                // Add selected class to clicked
                clickedOption.classList.add("selected");

                // Add tick mark if missing
                if (!clickedOption.querySelector(".tick")) {
                    const tick = document.createElement("span");
                    tick.className = "tick";
                    tick.textContent = "✔";
                    clickedOption.appendChild(tick);
                }
            }

            // Country Select
            document.querySelectorAll(".option.country").forEach(option => {
                option.addEventListener("click", () => {
                    selectOption("country", option);
                    const flag = option.getAttribute("data-flag");
                    selectedFlag.src = flag; // Update top flag
                });
            });

            // Language Select
            document.querySelectorAll(".option.language").forEach(option => {
                option.addEventListener("click", () => {
                    selectOption("language", option);
                    const lang = option.getAttribute("data-value");
                    selectedText.textContent = lang; // Update top text
                });
            });
        </script> --}}
        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //     setTimeout(function() {
            //         const loader = document.querySelector('.loader');
            //         loader.style.display = 'none'; // Hides the loader after 0.5 seconds
            //     }, 500); // 500 milliseconds = 0.5 seconds
            // });
        </script>

        <script>
            document.querySelectorAll('.faq-item').forEach(item => {
                item.addEventListener('click', () => item.classList.toggle('active'));
            });

            $(document).ready(function() {
                $('#subscribeForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent the form from submitting normally

                    // Clear previous error messages
                    $('.error-message').hide().text('');

                    // Reset previous error states
                    $('#email').removeClass('error-border');
                    $('#recaptcha').removeClass('error-border');
                    $('#email-error').hide().text('');
                    $('#recaptcha-error').hide().text('');

                    // Validate email
                    var email = $('#email').val().trim();
                    if (email.length === 0) {
                        $('#email').addClass('error-border');
                        $('#error-message').text('Please enter your email.').show();
                        return;
                    }

                    // Validate reCAPTCHA
                    var recaptchaResponse = grecaptcha.getResponse();
                    if (recaptchaResponse.length === 0) {
                        $('#recaptcha').addClass('error-border');
                        $('#error-message').text('Please complete the reCAPTCHA.').show();
                        return;
                    }

                    // Send AJAX request
                    $.ajax({
                        url: '{{ url('/subscribe') }}', // Replace with your backend endpoint
                        type: 'POST',
                        data: {
                            email: email,
                            recaptcha: recaptchaResponse,
                            _token: '{{ csrf_token() }}' // Add CSRF token for Laravel
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#get_off_popup').hide();
                                const popup = document.getElementById('popup');
                                const overlay = document.getElementById('overlay');
                                popup.classList.add('active');
                                overlay.classList.add('active');
                                // Hide the popup
                            } else {
                                $('#error-message').text(response.message)
                                    .show(); // Show error message
                            }
                        },
                        error: function(xhr) {
                            $('#error-message').text('An error occurred. Please try again.').show();
                        }
                    });
                });

                $('#email').on('input', function() {
                    $(this).removeClass('error-border');
                    $('#email-error').hide();
                });
            });
        </script>



        <script>
            $(document).ready(function() {
                // Debounce function to limit AJAX calls
                function debounce(func, wait) {
                    let timeout;
                    return function(...args) {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => func.apply(this, args), wait);
                    };
                }

                const performSearch = debounce(function() {
                    const query = $('#searchBox').val().trim();
                    const MSG_nofound = @json(__('product.not_found'));
                    if (query.length > 2) {
                        $.ajax({
                            url: '{{ url('/') }}/search-products',
                            method: 'GET',
                            data: {
                                text: query
                            },
                            success: function(response) {
                                $('#searchResults').empty().show();
                                if (response.length > 0) {
                                    $("#default_search_products").hide();
                                    $('#searchResults').append(`
                                        <div class="searching_for col-12">
                                            <span>{{ __('header.search.for') }}: <strong style="text-transform: capitalize;">${query}</strong></span>
                                            <button>{{ __('header.search.view_all_button') }}</button>
                                        </div>
                                    `);
                                    response.forEach(product => {
                                        $('#searchResults').append(`
                                            <a href="{{ url('/') }}/product/${product.slug}" class="run_time_search_product col-6 col-sm-3">
                                                <div class="category-card ">
                                                    <div class="image">
                                                        <img loading="lazy" src="{{ asset('') }}${product.thumb}" />
                                                    </div>
                                                    <p class="name">${product.product_name}</p>
                                                </div>
                                            </a>
                                        `);
                                    });
                                } else {
                                    $("#default_search_products").hide();
                                    $('#searchResults').append(
                                        `<div class="no_product_search">${MSG_nofound} <span>${query}</span> </div>`
                                    );
                                }
                            },
                            error: function() {
                                $('#searchResults').empty().show().append(
                                    '<div>Error fetching results</div>');
                            }
                        });
                    } else {
                        $('#searchResults').hide();
                    }
                    if (query == "") {
                        $("#default_search_products").show();
                    }
                }, 300); // 300ms debounce delay

                $('#searchBox').on('input', performSearch);
            });
        </script>


        <script>
            let id, qty, price, productTotal;
            $(document).ready(function() {

                $('.ion-close').click(function(e) {
                    e.preventDefault();
                    id = $(this).attr('productId');
                    $('#loader_container_overlay').css('display', 'flex').show();
                    $('#button_loader' + id).css('display', 'flex').show();
                    $.ajax({
                        url: "{{ url('cart/remove') }}",
                        type: "POST",
                        data: {
                            id: id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            //   location.reload();
                            //   console.log(id);
                            //   removeFromView(id,response);
                            if (response.cart === null) {
                                document.getElementById("cartValue").innerHTML = 0;
                                document.querySelectorAll(".quantity_btn_box" + id).forEach((
                                    el) => {
                                    el.style.display = "none";
                                });
                                document.querySelectorAll(".add-to-cart" + id).forEach((el) => {
                                    el.style.display = "unset";
                                });
                                // $('#loader_container').hide();
                            } else {
                                document.getElementById("cartValue").innerHTML = response.cart.qty;
                                document.querySelectorAll(".quantity_btn_box" + id).forEach((
                                    el) => {
                                    el.style.display = "none";
                                });
                                document.querySelectorAll(".add-to-cart" + id).forEach((el) => {
                                    el.style.display = "unset";
                                });
                                // $('#loader_container').hide();
                            }
                            $('#loader_container_overlay').hide();
                            $('#button_loader' + id).hide();
                            //   location.reload();
                        }
                    });
                });

                $('.ion-close-cart').click(function(e) {
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
                                $('#cartValue').html(0);
                                setTimeout(() => {
                                    $('#loader_container_overlay').hide();
                                    $('#button_loader' + id).hide();
                                    $('#button_loader' + boxId).hide();
                                }, 1000);
                            }
                            console.log(response);
                            updateView(response);
                            $(`#product-row-${id}`).remove();
                            $(`#hr${id}`).remove();
                            $(`#box-row${boxId}`).remove();
                            $(`#hr${boxId}`).remove();
                            $('#loader_container_overlay').hide();
                            //   location.reload();
                        }
                    });
                });


                $('.clear').click(function(e) {
                    e.preventDefault();
                    //   id = $(this).attr('productId');
                    $.ajax({
                        url: "{{ url('cart/clear') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                });

                $('.plus').click(function() {
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

                $('.minus').click(function() {
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

                function updateView(response) {
                    productTotal = parseInt(qty * price);
                    $('#cartValue').html(response.cart.qty);
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
                            response.cart.amount +
                            {{ getSetting('shipping') }} +
                            (response.cart.amount * {{ getSetting('tax_value') }} / 100)
                        ).toFixed(2)
                    );
                    $('.vat').html('{{ getSetting('currency') }} ' +
                        (
                            (response.cart.amount * {{ getSetting('tax_value') }} / 100)
                        ).toFixed(2)
                    );
                    $('.cartTotal1').html('{{ getSetting('currency') }} ' + response.cart.amount + '.00');
                    $('#productTotal' + id).html(productTotal);

                }

                function updatecart() {
                    $('.checkout1').prop('disabled', true);
                }

                updatecart();

            });
        </script>

        <script>
            $(document).ready(function() {
                $('.add-to-cart').click(function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    let qty = $('#quantityinput').val();
                    $.ajax({
                        url: "<?php echo url('/'); ?>/cart/add",
                        method: "POST",
                        data: {
                            id: id,
                            qty: qty,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.error) {
                                // Handle error response
                            } else {
                                $('#cartValue').html(response.qty);
                                $('#cartValue1').html(response.qty);
                                $('#cartValue2').html(response.qty);
                                $('.quantity_btn_box' + id).show();
                                $('.add-to-cart' + id).hide();
                                // showToastr(response.msg, response.msg_type);
                                // $.post('{{ route('cart_data') }}', {
                                //     _token: '{{ csrf_token() }}'
                                // }, function (data) {
                                //     $('#cart_data').html(data);
                                // });
                                // $.post('{{ route('hearder_cart') }}', {
                                //     _token: '{{ csrf_token() }}'
                                // }, function (data) {
                                //     $('#hearder_cart').html(data);
                                // });

                                // Trigger confetti
                                const button = document.querySelector(`.quantity_btn_box${id}`);
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
                                            y: y / window
                                                .innerHeight, // Relative y position
                                        },
                                        scalar: 0.8, // Smaller particle size
                                    });
                                }
                                const cartItem = response.cart.items[
                                    0]; // Assuming a single item is added at a time
                                dataLayer.push({
                                    event: "add_to_cart",
                                    ecommerce: {
                                        currency: "AED", // Replace with your store's currency
                                        value: response.cart.amount, // Total cart amount
                                        items: [{
                                            item_id: cartItem.id, // Product ID
                                            price: cartItem
                                                .price, // Price per item (update if needed)
                                            quantity: cartItem
                                                .qty, // Quantity added
                                            name: cartItem.name,
                                        }, ],
                                    },
                                });
                                console.log("DataLayer pushed:", dataLayer);
                                try {
                                    if (cartItem && typeof snaptr === "function") {
                                        const c = document.cookie.match(
                                            /(?:^|;\s*)uuid_c1=([^;]+)/);
                                        const uuidC1 = c ? decodeURIComponent(c[1]) : null;
                                        const qty = Number(cartItem.qty) || 1;
                                        const unitPrice = Number(cartItem.price) || 0;
                                        const addValue = unitPrice * qty;

                                        const payload = {
                                            price: addValue,
                                            currency: "AED",
                                            item_ids: [cartItem.id],
                                            number_items: qty,
                                            user_email: '{{ session()->has('user') ? session('user')['email'] : session('cart')['email'] ?? '' }}'
                                        };
                                        if (uuidC1) payload.uuid_c1 = uuidC1;

                                        snaptr('track', 'ADD_CART', payload);
                                        console.log("Snap ADD_CART sent:", payload);
                                    } else {
                                        console.warn("snaptr is not defined or cartItem missing.");
                                    }
                                } catch (e) {
                                    console.error("Error sending snaptr ADD_CART event:", e);
                                }

                                // TikTok AddToCart tracking
                                try {
                                    if (cartItem && typeof ttq !== 'undefined') {
                                        ttq.track('AddToCart', {
                                            contents: [{
                                                content_id: cartItem.id,
                                                content_type: 'product',
                                                content_name: cartItem.name,
                                                quantity: cartItem.qty,
                                                price: cartItem.price
                                            }],
                                            value: response.cart.amount,
                                            currency: "AED"
                                        }, {
                                            event_id: Date.now() + '_' + Math.random().toString(36).substr(2, 9)
                                        });
                                        console.log("TikTok AddToCart sent for product:", cartItem.id);
                                    }
                                } catch (e) {
                                    console.error("Error sending TikTok AddToCart event:", e);
                                }
                            }
                        },
                        cache: false // Disable caching for the AJAX response
                    });
                });
            });
            $(document).ready(function() {
                $('.add-to-cart-item').click(function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    let qty = $('#quantityinput').val();
                    $.ajax({
                        url: "<?php echo url('/'); ?>/cart/add",
                        method: "POST",
                        data: {
                            id: id,
                            qty: qty,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.error) {
                                // Handle error response
                            } else {
                                $('#cartValue').html(response.qty);
                                $('.quantity_btn_box' + id).show();
                                // $('.add-to-cart-item').html('Added to cart');
                                // $('.add-to-cart-item').prop('disabled', true);
                                // $('#cartValue1').html(response.qty);
                                // $('#cartValue2').html(response.qty);
                                // // showToastr(response.msg, response.msg_type);
                                // $.post('{{ route('hearder_cart') }}', {
                                //     _token: '{{ csrf_token() }}'
                                // }, function(data) {
                                //     $('#hearder_cart').html(data);
                                // });
                                // Trigger confetti
                                const button = document.querySelector(`.quantity_btn_box${id}`);
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
                                            y: y / window
                                                .innerHeight, // Relative y position
                                        },
                                        scalar: 0.8, // Smaller particle size
                                    });
                                }
                                const cartItem = response.cart.items[
                                    0]; // Assuming a single item is added at a time
                                dataLayer.push({
                                    event: "add_to_cart",
                                    ecommerce: {
                                        currency: "AED", // Replace with your store's currency
                                        value: response.cart.amount, // Total cart amount
                                        items: [{
                                            item_id: cartItem.id, // Product ID
                                            price: cartItem
                                                .price, // Price per item (update if needed)
                                            quantity: cartItem
                                                .qty, // Quantity added
                                            name: cartItem.name,
                                        }, ],
                                    },
                                });
                                console.log("DataLayer pushed:", dataLayer);

                                try {
                                    if (cartItem && typeof snaptr === "function") {
                                        const c = document.cookie.match(
                                            /(?:^|;\s*)uuid_c1=([^;]+)/);
                                        const uuidC1 = c ? decodeURIComponent(c[1]) : null;
                                        const qty = Number(cartItem.qty) || 1;
                                        const unitPrice = Number(cartItem.price) || 0;
                                        const addValue = unitPrice * qty;

                                        const payload = {
                                            price: addValue,
                                            currency: "AED",
                                            item_ids: [cartItem.id],
                                            number_items: qty,
                                            user_email: '{{ session()->has('user') ? session('user')['email'] : session('cart')['email'] ?? '' }}'
                                        };
                                        if (uuidC1) payload.uuid_c1 = uuidC1;

                                        snaptr('track', 'ADD_CART', payload);
                                        console.log("Snap ADD_CART sent:", payload);
                                    } else {
                                        console.warn("snaptr is not defined or cartItem missing.");
                                    }
                                } catch (e) {
                                    console.error("Error sending snaptr ADD_CART event:", e);
                                }

                                // TikTok AddToCart tracking
                                try {
                                    if (cartItem && typeof ttq !== 'undefined') {
                                        ttq.track('AddToCart', {
                                            contents: [{
                                                content_id: cartItem.id,
                                                content_type: 'product',
                                                content_name: cartItem.name,
                                                quantity: cartItem.qty,
                                                price: cartItem.price
                                            }],
                                            value: response.cart.amount,
                                            currency: "AED"
                                        }, {
                                            event_id: Date.now() + '_' + Math.random().toString(36).substr(2, 9)
                                        });
                                        console.log("TikTok AddToCart sent for product:", cartItem.id);
                                    }
                                } catch (e) {
                                    console.error("Error sending TikTok AddToCart event:", e);
                                }
                            }
                        },
                        cache: false // Disable caching for the AJAX response
                    });
                });
            });

            $(document).ready(function() {
                $('.add-to-cart-item1').click(function(e) {
                    e.preventDefault();

                    let id = $(this).attr('id');

                    $.ajax({
                        url: "<?php echo url('/'); ?>/cart/add",
                        method: "POST",
                        data: {
                            id: id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.error) {


                            } else {
                                window.location.href = "<?php echo url('/'); ?>/cart";
                            }
                        }
                    });
                });
            });

            function showToastr(msg, msg_type) {
                switch (msg_type) {
                    case "success":
                        toastr.success(msg);
                        break;

                    case "danger":
                        toastr.error(msg)
                        break;

                    case "info":
                        toastr.info(msg)
                        break;

                    case "warning":
                        toastr.warning(msg)
                        break;
                }
            }

            $(document).ready(function() {

                let msg_type = "";
                let msg = "";
                @if (Session::has('msg'))
                    msg_type = "{{ Session::get('msg_type') }}";
                    msg = "{{ Session::get('msg') }}";
                @endif

                if (msg != "") {
                    switch (msg_type) {
                        case "success":
                            toastr.success(msg);
                            break;

                        case "danger":
                            toastr.error(msg)
                            break;

                        case "info":
                            toastr.info(msg)
                            break;

                        case "warning":
                            toastr.warning(msg)
                            break;
                    }
                }





            });

            // AddToCart event (working, included for reference)
            function addToCart(productId, price) {
                var addPayload = {
                    content_ids: [productId],
                    content_type: 'product',
                    value: price,
                    currency: @json(pixelCurrency())
                };

                function sendAddToCart() {
                    if (typeof fbq !== 'function') {
                        return false;
                    }
                    fbq('track', 'AddToCart', addPayload);
                    return true;
                }

                if (sendAddToCart()) {
                    return;
                }
                window.addEventListener('meta-pixel-ready', function() {
                    sendAddToCart();
                }, {
                    once: true
                });
                var addAttempts = 0;
                var addPoll = setInterval(function() {
                    if (sendAddToCart() || ++addAttempts >= 40) {
                        clearInterval(addPoll);
                    }
                }, 100);
            }

            // AddToCart event (working, included for reference)
            function InitiateCheckout() {
                function sendInitiateCheckout() {
                    if (typeof fbq !== 'function') {
                        return false;
                    }
                    fbq('track', 'InitiateCheckout');
                    return true;
                }

                if (sendInitiateCheckout()) {
                    return;
                }
                window.addEventListener('meta-pixel-ready', function() {
                    sendInitiateCheckout();
                }, {
                    once: true
                });
                var icAttempts = 0;
                var icPoll = setInterval(function() {
                    if (sendInitiateCheckout() || ++icAttempts >= 40) {
                        clearInterval(icPoll);
                    }
                }, 100);
            }
        </script>
