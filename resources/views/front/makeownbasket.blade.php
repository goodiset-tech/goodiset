@extends('layout.app')
@section('content')
@php
    use App\Models\Admins\Setting;
    $pro = Setting::where(['id' => '1'])->first();
@endphp
<style>
    .progress {
        height: 10px;
        background-color: #e9ecef;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        transition: width 0.3s ease;
    }

    .load-more-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
        justify-content: center;
    }

    .load-more-container p {
        font-size: 14px;
        margin-bottom: 10px;
        color: #555;
        display: flex;
        justify-content: center;
    }

    #load-more {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #0a0a0a;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    #load-more:hover {
        background-color: #070707;
    }
</style>
<div class="main-container ">
    <div class="hero-image">
        <div class="headings">
            <h1 class="hero-title">Sweet Freedom! <br>
                Build Your Dream Candy Box</h1>
            <div class="breadcrumbs">
                <i class="fa-solid fa-house" style="color: white; font-size: 13px;"></i>
                <a href="#" target="_blank">Home</a>
                <i class="fa-solid fa-angle-right" style="color: white; font-size: 13px;"></i>
                <a href="#" target="_blank">Make Your Own Candy</a>
            </div>
        </div>
    </div>
    <div class="custom_box_container">

        <aside class="asside_section">
            <form class="packaging_detail">
                <div class="radio-group field">

                    @foreach ($packages as $v)
                        <input type="radio" onchange="fetchBoxes()" name="box_type" id="{{$v->name }}" {{ session('selected_box.package_type') == $v->id ? 'checked' : '' }} value="{{$v->id}}" />
                        <label class="radio-label" for="{{$v->name }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path
                                    d="M50.7 58.5L0 160l208 0 0-128L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160l208 0L397.3 58.5C389.1 42.3 372.5 32 354.3 32L240 32l0 128zm208 32L0 192 0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-224z" />
                            </svg>
                            {{$v->name }}
                        </label>
                    @endforeach
                </div>
                <div class="flieds">
                    <div class="field">
                        <label for="Select Size">Select Size</label>
                        <select id="size" onchange="fetchBoxes()">
                            <option value="">Select Size</option>
                            @foreach ($sizes as $v)
                                <option {{ session('selected_box.size') == $v->id ? 'selected' : '' }} value="{{$v->id}}">
                                    {{$v->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            <div class="packaging_detail_2">
                <div class="packaging_box" id="box-container">

                </div>
                <div class="message" style="background-color: #D2F5F1;display:none;">Your have added <span
                        id="max_desk">300</span>/ <span id="tot_desk">1000</span> grams</div>
                <div class="cards">
                    @php
                        $cart = session()->get('cart_customize', []);
                    @endphp
                    @if (!empty($cart))
                        @foreach ($cart as $item)
                            <div class="added_card">
                                <i style="display:none;" class="fa-solid fa-circle-xmark remove_item"
                                    data-id="{{ $item['id'] }}"></i>
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                <div class="content">
                                    <h1>{{ $item['name'] }}</h1>
                                    <p>
                                        <span id="qty{{ $item['id'] }}" class="qty{{ $item['id'] }}">{{ $item['quantity'] }}
                                            g</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="add_card_btn_outer">
                    <button class="add_card add_card_btn" style="margin-bottom: 20px" id="des_cart" disabled
                        data-id="${box.id}">
                        Add to Cart
                    </button>

                </div>
            </div>
        </aside>

        <div class="container" style="
        max-width: 1100px;
        margin: 0px; flex-direction:column">
            <div class="add_message  " style="    background-color: #F5F5F5;
    width: 98%;
padding:10px;
    border-radius: 12px;
    margin-bottom: 20px;">Please select the package to start</div>
            <div class="row-cols-2 row-cols-lg-5 row-cols-sm-12 g-2 g-lg-3 row gy-5" id="product-list">

                @php
                    $size = session('selected_box.size');
                    $package = session('selected_box.package_type');
                    $quantity = App\Helpers\Cart::package_qty($package, $size);
                    $quantity = $quantity ?? 0;
                @endphp
                <input type="hidden" value="{{$quantity}}" id="pack_qty">
                @foreach ($product as $index => $v)
                                <div class="card-container2 col-6 col-sm-6 col-md-4 col-xl-3 col-custom-xxl  col-lg-3 mb-4  product-card"
                                    data-index="{{ $index + 1 }}" style="{{ $index >= 24 ? 'display: none;' : '' }}">
                                    <div class="image">
                                        <img src="{{ asset('') }}{{ $v->image_one }}" />
                                    </div>
                                    <div class="content">
                                        <p class="product-name">
                                            {{ $v->product_name }}
                                        </p>
                                        <div class="quantity quantity-controls quantitybtnbox quantity_btn_box{{ $v->id }}"
                                            id="quantity_btn_box"
                                            style="{{ App\Helpers\Cart::cus_has_pro($v->id) ? '' : 'display:none;' }}">
                                            <div class="button_spin_overlay" id="button_loader{{$v->id}}" style="display: none">
                                                <div class="loader_dots"></div>
                                            </div>
                                            <button class="del_btn remove_item" data-id="{{ $v->id }}" productId="{{ $v->id }}">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                            @php
                                                $quantity = App\Helpers\Cart::cus_product_qty($v->id);
                                                $quantity = $quantity ?? 100;
                                            @endphp
                                            <i class="fa-solid fa-minus minus_quantity" productId="{{ $v->id }}"
                                                productprice="{{ $v->discount_price }}" id="minus"></i>
                                            <input type="hidden" class="form-control form-control-sm bg-secondary text-center"
                                                id="spec{{ $v->id }}" name="qty" value="1">
                                            <span class="quantity_cart"
                                                id="quantity{{ $v->id }}">{{ $v->format == 1 ? $quantity . 'g' : '1' }}</span>
                                            <i class="fa-solid fa-plus add_quantity" productId="{{ $v->id }}"
                                                productprice="{{ $v->discount_price }}" id="plus"></i>
                                        </div>
                                        <div class="button addtocart add-to-cart{{ $v->id }}"
                                            style="{{ App\Helpers\Cart::cus_has_pro($v->id) ? 'display:none;' : '' }}">
                                            <button class="add_basket add-to-box " id="{{ $v->id }}" data-id="{{ $v->id }}" disabled {{ $v->product_quantity < 1 ? 'disabled' : '' }}>
                                                {{ $v->product_quantity < 1 ? 'Sold Out' : 'Add to Bag' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                @endforeach
            </div>

            <!-- Progress and Load More Section -->
            <div class="load-more-container text-center mt-4">
                <p id="progress-tracker">You've viewed <span id="viewed-count"> 24 </span> of {{ count($product) }}
                    products</p>
                <div class="progress mb-2" style="width: 50%; margin: auto;">
                    <div id="progress-bar" class="progress-bar bg-dark" role="progressbar"
                        style="width: 15%; background-color:#070707;" aria-valuenow="24" aria-valuemin="0"
                        aria-valuemax="{{ count($product) }}"></div>
                </div>
                <button id="load-more" class="btn btn-primary" style="color: black;     background-color: #f5f5f5;
            border: 1px solid #ddd;">Load More</button>
            </div>
        </div>



    </div>

</div>

<div class="mbl_box_customization down_menu_box">
    <i class="fa-solid fa-grip-lines"></i>

    <form class="packaging_detail">
        <div class="radio-group field">

            @foreach ($packages as $v)
                <input type="radio" onchange="fetchBoxes1()" name="box_type" id="{{$v->name}}{{$v->id}}" {{ session('selected_box.package_type') == $v->id ? 'checked' : '' }} value="{{$v->id}}" />
                <label class="radio-label" for="{{$v->name}}{{$v->id}}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M50.7 58.5L0 160l208 0 0-128L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160l208 0L397.3 58.5C389.1 42.3 372.5 32 354.3 32L240 32l0 128zm208 32L0 192 0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-224z" />
                    </svg>
                    {{$v->name }}
                </label>
            @endforeach
        </div>
        <div class="flieds">
            <div class="field">
                <label for="Select Size">Select Size</label>
                <select id="size1" onchange="fetchBoxes1()">
                    <option value="">Select Size</option>
                    @foreach ($sizes as $v)
                        <option {{ session('selected_box.size') == $v->id ? 'selected' : '' }} value="{{$v->id}}">{{$v->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    <div class="packaging_box">
        <div class="img_outer" id="box-container-mob">
        </div>

        <div class="cards" style="width: 100%;">
            @php
                $cart = session()->get('cart_customize', []);
            @endphp
            @if (!empty($cart))
                @foreach ($cart as $item)
                    <div class="added_card">
                        <i style="display:none;" class="fa-solid fa-circle-xmark remove_item" data-id="{{ $item['id'] }}"></i>
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                        <div class="content">
                            <h1>{{ $item['name'] }}</h1>
                            <p>
                                <span id="qty{{ $item['id'] }}" class="qty{{ $item['id'] }}">{{ $item['quantity'] }} g</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{-- <div class="message" style="background-color: #F5F5F5;display:none;">Select <span id="max_mob"> 3</span>
            more items to fill the box</div> --}}
        <div class="message" style="background-color: #F5F5F5;display:none;">Your have added <span
                id="max_mob">300</span>/ <span id="tot_mob">1000</span> grams </div>
        <button class="add_card_btn add_card_btn_mob" disabled id="mob_cart">
            Add to Cart
        </button>
    </div>

</div>
<script src="{{ asset('') }}front/CustomBox.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function fetchBoxes() {
        // let packageType = $('#package_type').val();
        let packageType = $('input[name="box_type"]:checked').val();
        let size = $('#size').val();

        // Ensure both fields are selected before making the request
        if (packageType && size) {
            $.ajax({
                url: "{{route('get_box')}}", // Replace with the route to your function
                type: 'GET',
                data: {
                    package_type: packageType,
                    size: size
                },
                success: function (response) {
                    let boxContainer = $('#box-container');
                    let boxContainermob = $('#box-container-mob');
                    boxContainer.empty(); // Clear any existing content
                    boxContainermob.empty();
                    if (response.boxes.length > 0) {
                        $('.add_basket').removeAttr('disabled');
                        $('.message').show();
                        $('.add_message').hide();
                        response.boxes.forEach(box => {
                            $(`.add_basket`).text('Add to ' + box.package_name);
                            let total_qty = response.total_quantity;
                            let box_weight = box.weight
                            // let total_quantity = box_weight - total_qty;
                            let total_quantity = total_qty;
                            $(`#max_desk`).text(total_quantity + 'g');
                            $(`#max_mob`).text(total_quantity + 'g');
                            $(`#tot_desk`).text(box_weight + 'g');
                            $(`#tot_mob`).text(box_weight + 'g');
                            $(`#tot_mob`).text(box_weight + 'g');
                            $('.cards').empty();
                            $('.quantity_cart').text('100 g');
                            $('.quantitybtnbox').hide();
                            $('.add_quantity').show();
                            $('.minus_quantity').hide();
                            $('.remove_item').show();
                            $('.addtocart').show();
                            $('.add_card').prop('disabled', true);
                            $('.add_card_btn_mob').prop('disabled', true);
                            boxContainer.append(`
                               <div class="box-item">
                                  <div class="box_inner_item" >
                                    <img src="{{asset('')}}${box.image || '{{asset('')}}front/assets/images/box.png'}" alt="">
                                    <div class="detail">
                                      <div>
                                        <h3>${box.package_name || 'Box Name'}</h3>
                                        <p>${box.size_name || 'Up-To N People'} (${box.weight || 0} g)</p>
                                        </div>
                                        <span>AED ${box.price || 0}</span>
                                    </div>
                                    </div>
                                </div>
                            `);
                            boxContainermob.append(`
                                <img src="{{asset('')}}${box.image || '{{asset('')}}front/assets/images/box.png'}" alt="">
                                    <div class="detail_outer">
                                        <div class="detail">
                                            <h3>${box.package_name || 'Box Name'}</h3> <span>AED ${box.price || 0}</span>
                                        </div>
                                        <p>${box.size_name || 'Up-To N People'} (${box.weight || 0} g)</p>
                                    </div>

                            `);

                            // if(total_quantity === 0 ){
                            //     $('#mob_cart').prop('disabled', false);
                            //     $('#des_cart').prop('disabled', false);
                            //     $('.add_quantity').hide();
                            //     $('.add_basket').prop('disabled', true);
                            // }

                            if (total_quantity == box_weight) {
                                $('#mob_cart').prop('disabled', false);
                                $('#des_cart').prop('disabled', false);
                                $('.add_quantity').hide();
                                $('.add_basket').prop('disabled', false);
                            }

                        });


                    } else {
                        boxContainer.append('<p>No boxes available for the selected options.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching boxes:', error);
                }
            });
        }
    }
    function fetchBoxes1() {
        // let packageType = $('#package_type1').val();
        let packageType = $('input[name="box_type"]:checked').val();
        let size = $('#size1').val();

        // Ensure both fields are selected before making the request
        if (packageType && size) {
            $.ajax({
                url: "{{route('get_box')}}", // Replace with the route to your function
                type: 'GET',
                data: {
                    package_type: packageType,
                    size: size
                },
                success: function (response) {
                    let boxContainer = $('#box-container');
                    let boxContainermob = $('#box-container-mob');
                    boxContainer.empty();
                    boxContainermob.empty();
                    if (response.boxes.length > 0) {
                        $('.add_basket').removeAttr('disabled');
                        $('.message').show();
                        $('.add_message').hide();
                        response.boxes.forEach(box => {
                            $(`.add_basket`).text('Add to ' + box.package_name);
                            let total_qty = response.total_quantity;
                            let box_weight = box.weight
                            // let total_quantity = box_weight - total_qty;
                            let total_quantity = total_qty;
                            $(`#max_desk`).text(total_quantity + 'g');
                            $(`#max_mob`).text(total_quantity + 'g');
                            $(`#tot_desk`).text(box_weight + 'g');
                            $(`#tot_mob`).text(box_weight + 'g');
                            $('.cards').empty();
                            $('.quantity_cart').text('100 g');
                            $('.quantitybtnbox').hide();
                            $('.add_quantity').show();
                            $('.minus_quantity').hide();
                            $('.remove_item').show();
                            $('.addtocart').show();
                            $('.add_card').prop('disabled', true);
                            $('.add_card_btn_mob').prop('disabled', true);

                            boxContainer.append(`
                                <div class="box-item">
                                  <div class="box_inner_item" >
                                    <img src="{{asset('')}}${box.image || '{{asset('')}}front/assets/images/box.png'}" alt="">
                                    <div class="detail">
                                      <div>
                                        <h3>${box.package_name || 'Box Name'}</h3>
                                        <p>${box.size_name || 'Up-To N People'} (${box.weight || 0} g)</p>
                                        </div>
                                        <span>AED ${box.price || 0}</span>
                                    </div>
                                    </div>
                                </div>
                            `);
                            boxContainermob.append(`
                                <img src="{{asset('')}}${box.image || '{{asset('')}}front/assets/images/box.png'}" alt="">
                                    <div class="detail_outer">
                                        <div class="detail">
                                            <h3>${box.package_name || 'Box Name'}</h3> <span>AED ${box.price || 0}</span>
                                        </div>
                                        <p>${box.size_name || 'Up-To N People'} (${box.weight || 0} g)</p>
                                    </div>
                            `);
                            // if(total_quantity === 0 ){
                            //     $('#mob_cart').prop('disabled', false);
                            //     $('#des_cart').prop('disabled', false);
                            //     $('.add_quantity').hide();
                            //     $('.add_basket').prop('disabled', true);
                            // }
                            if (total_quantity == box_weight) {
                                $('#mob_cart').prop('disabled', false);
                                $('#des_cart').prop('disabled', false);
                                $('.add_quantity').hide();
                                $('.add_basket').prop('disabled', false);
                            }

                        });


                    } else {
                        boxContainer.append('<p>No boxes available for the selected options.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching boxes:', error);
                }
            });
        }
    }
    $(document).on('click', '.add_basket', function () {
        const productId = $(this).data('id');
        // let mobVal = parseInt($(`#max_mob`).text(), 10);
        // if (mobVal === 0) {
        //     alert('You have added max weight.');
        //     return false;
        // }
        const qty = $('#quantity' + productId).html();
        $('#button_loader' + productId).css('display', 'flex').show();
        $('#loader_container_overlay').css('display', 'flex').show();
        $('.quantity_btn_box' + productId).show();
        $('.add-to-cart' + productId).hide();

        $.ajax({
            url: "{{ route('add.to.cart') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: productId,
                quantity: qty, // Default quantity
            },
            success: function (response) {
                $('#loader_container_overlay').hide();
                $('#button_loader' + productId).hide();
                if (response.status) {
                    const product = response.cart[productId];
                    const existingCard = $(`.added_card .remove_item[data-id="${product.id}"]`).closest('.added_card');
                    if (existingCard.length) {
                        $(`#qty${productId}`).text(product.quantity + 'g');
                        let mob_val = parseInt($(`#max_mob`).text(), 10);
                        let dest_val = parseInt($(`#max_desk`).text(), 10);
                        mob_val = mob_val + 100;
                        dest_val = dest_val + 100;
                        $(`#max_mob`).text(mob_val + 'g');
                        $(`#max_desk`).text(dest_val + 'g');
                        let tot = parseInt($(`#tot_desk`).text(), 10);
                        if (mob_val == tot) {
                            $('#mob_cart').prop('disabled', false);
                            $('#des_cart').prop('disabled', false);
                            $('.add_quantity').hide();
                            $('.add_basket').prop('disabled', true);
                        }
                    } else {
                        // Add a new item to the cart
                        const newCard = `
                            <div class="added_card">
                                <i style="display:none;" class="fa-solid fa-circle-xmark remove_item" data-id="${product.id}"></i>
                                <img src="{{asset('')}}${product.image}" alt="${product.name}">
                                <div class="content">
                                    <h1>${product.name}</h1>
                                    <p>
                                        <span id="qty${product.id}" class="qty${product.id}">${product.quantity} g</span>
                                    </p>
                                </div>
                            </div>`;
                        $('.cards').append(newCard);

                        let mob_val = parseInt($(`#max_mob`).text(), 10);
                        let dest_val = parseInt($(`#max_desk`).text(), 10);
                        mob_val = mob_val + 100;
                        dest_val = dest_val + 100;
                        $(`#max_mob`).text(mob_val + 'g');
                        $(`#max_desk`).text(dest_val + 'g');
                        let tot = parseInt($(`#tot_desk`).text(), 10);
                        if (mob_val == tot) {
                            $('#mob_cart').prop('disabled', false);
                            $('#des_cart').prop('disabled', false);
                            $('.add_quantity').hide();
                            $('.add_basket').prop('disabled', true);
                        }
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Something went wrong!');
            },
        });
    });

    $(document).on('click', '.add_quantity', function () {
        const productId = $(this).attr('productId');

        const qty = $('#quantity' + productId).html();
        let mobVal = parseInt($(`#max_mob`).text(), 10);
        if (mobVal === 0) {
            alert('You have added max weight.');
            return false;
        }
        $('#button_loader' + productId).css('display', 'flex').show();
        $('#loader_container_overlay').css('display', 'flex').show();
        $.ajax({
            url: "{{ route('add.to.cart') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: productId,
                quantity: 100, // Add one more
            },
            success: function (response) {
                $('#button_loader' + productId).hide();
                $('#loader_container_overlay').hide();
                if (response.status) {
                    const product = response.cart[productId];
                    $(`#qty${productId}`).text(product.quantity + 'g');
                    $(`.qty${productId}`).text(product.quantity + 'g');
                    let mob_val = parseInt($(`#max_mob`).text(), 10);
                    let dest_val = parseInt($(`#max_desk`).text(), 10);
                    mob_val = mob_val + 100;
                    dest_val = dest_val + 100;
                    $(`#max_mob`).text(mob_val + 'g');
                    $(`#max_desk`).text(dest_val + 'g');
                    let tot = parseInt($(`#tot_desk`).text(), 10);
                    if (mob_val == tot) {
                        $('#mob_cart').prop('disabled', false);
                        $('#des_cart').prop('disabled', false);
                        $('.add_quantity').hide();
                        $('.add_basket').prop('disabled', true);
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Something went wrong!');
            },
        });
    });

    $(document).on('click', '.minus_quantity', function () {
        const productId = $(this).attr('productId');
        const qty = $('#quantity' + productId).html();
        $('#button_loader' + productId).css('display', 'flex').show();
        $('#loader_container_overlay').css('display', 'flex').show();
        $.ajax({
            url: "{{ route('decrement.to.cart') }}", // Create this route for decrementing quantity
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: productId,
                quantity: 100, // Remove one
            },
            success: function (response) {
                $('#button_loader' + productId).hide();
                $('#loader_container_overlay').hide();
                if (response.status) {
                    const product = response.cart[productId];

                    if (product && product.quantity > 0) {

                        // $(`#qty${productId}`).text(product.quantity+'g');
                        $(`.qty${productId}`).text(product.quantity + 'g');
                        let mob_val = parseInt($(`#max_mob`).text(), 10);
                        let dest_val = parseInt($(`#max_desk`).text(), 10);
                        mob_val = mob_val - 100;
                        dest_val = dest_val - 100;
                        $(`#max_mob`).text(mob_val + 'g');
                        $(`#max_desk`).text(dest_val + 'g');
                        let tot = parseInt($(`#tot_desk`).text(), 10);
                        if (mob_val < tot) {
                            $('#mob_cart').prop('disabled', true);
                            $('#des_cart').prop('disabled', true);
                            $('.add_quantity').css('display', 'flex').show();
                            $('.add_basket').prop('disabled', false);
                        }
                    } else {
                        // If quantity becomes 0, hide controls and show "Add to Bag" button
                        $(`.quantity_btn_box${productId}`).hide();
                        $(`.add-to-cart${productId}`).show();
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Something went wrong!');
            },
        });
    });


    $(document).on('click', '.remove_item', function () {
        const productId = $(this).data('id');
        let qty = $('#quantity' + productId).html();
        qty = parseInt(qty, 10);
        $('#button_loader' + productId).css('display', 'flex').show();
        $('#loader_container_overlay').css('display', 'flex').show();
        $.ajax({
            url: "{{ route('remove.from.cart') }}", // Add a route to remove item
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: productId,
            },
            success: function (response) {
                $('#button_loader' + productId).hide();
                $('#loader_container_overlay').hide();
                if (response.status) {
                    $(`.remove_item[data-id="${productId}"]`).closest('.added_card').remove();
                    $(`.quantity_btn_box${productId}`).hide();
                    $(`.add-to-cart${productId}`).show();
                    // $(`#quantity${productId}`).text('');
                    // $(`#quantity${productId}`).text('100 g');
                    let mob_val = parseInt($(`#max_mob`).text(), 10);
                    let dest_val = parseInt($(`#max_desk`).text(), 10);
                    mob_val -= qty;
                    dest_val -= qty;
                    $(`#max_mob`).text(mob_val + 'g');
                    $(`#max_desk`).text(dest_val + 'g');
                    let tot = parseInt($(`#tot_desk`).text(), 10);
                    if (mob_val < tot) {
                        $('#mob_cart').prop('disabled', true);
                        $('#des_cart').prop('disabled', true);
                        $('.add_quantity').css('display', 'flex').show();
                        $('.add_basket').prop('disabled', false);
                    }
                } else {
                    alert(response.message);
                }
            },
        });
    });

    $(document).on('click', '.add_card', function () {
        // let packageType = $('#package_type').val();
        let packageType = $('input[name="box_type"]:checked').val();
        let size = $('#size').val();
        let qty = parseInt($('#pack_qty').val(), 10);
        let qtyy = qty + 1;
        $.ajax({
            url: "<?php echo url('/'); ?>/cart/add",
            method: "POST",
            data: {
                packageType: packageType,
                packageSize: size,
                qty: 1,
                "_token": "{{ csrf_token() }}",
            },
            success: function (response) {
                const button = document.querySelector(`.add_card`);
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
                if (response.error) {
                    var msg = "Package Added To Cart";
                    var msg_type = "success";
                    let currentQty = parseInt($('#cartValue').html()) || 0;
                    let newQty = currentQty + 1;
                    $('#cartValue').html(newQty);
                    showToastr(msg, msg_type);
                    // Handle error response
                } else {
                    $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(response.qty);
                    $('#pack_qty').val(qtyy);
                    var msg = "Package Added To Cart";
                    var msg_type = "success";
                    showToastr(msg, msg_type);
                    $('.cards').empty();
                    $('.packaging_box').empty();
                    $('.message').hide();
                    $('.quantitybtnbox').hide();
                    $('.addtocart').show();
                    $('.add_basket').prop('disabled', true);
                    $('.add_card').prop('disabled', true);
                    $('.add_card_btn_mob').prop('disabled', true);
                    const radioButtons = document.querySelectorAll('input[name="box_type"]');
                    radioButtons.forEach(radio => radio.checked = false);
                    const sizeDropdown = document.getElementById('size');
                    sizeDropdown.selectedIndex = 0;
                    const sizeDropdown1 = document.getElementById('size1');
                    sizeDropdown1.selectedIndex = 0;
                    location.reload();
                }
            },
            cache: false // Disable caching for the AJAX response
        });
    });

    $(document).on('click', '.add_card_btn_mob', function () {
        // let packageType = $('#package_type').val();
        let packageType = $('input[name="box_type"]:checked').val();
        let size = $('#size1').val();
        let qty = parseInt($('#pack_qty').val(), 10);
        let qtyy = 1;
        $.ajax({
            url: "<?php echo url('/'); ?>/cart/add",
            method: "POST",
            data: {
                packageType: packageType,
                packageSize: size,
                qty: qtyy,
                "_token": "{{ csrf_token() }}",
            },
            success: function (response) {
                const button = document.querySelector(`.add_card_btn_mob`);
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
                if (response.error) {
                    var msg = "Package Added To Cart";
                    var msg_type = "success";
                    let currentQty = parseInt($('#cartValue').html()) || 0;
                    let newQty = currentQty + 1;
                    $('#cartValue').html(newQty);
                    showToastr(msg, msg_type);
                    // Handle error response
                } else {
                    $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(response.qty);
                    $('#pack_qty').val(qtyy);
                    var msg = "Package Added To Cart";
                    var msg_type = "success";
                    showToastr(msg, msg_type);
                    $('.cards').empty();
                    $('.packaging_box').empty();
                    $('.message').hide();
                    $('.quantitybtnbox').hide();
                    $('.addtocart').show();
                    $('.add_basket').prop('disabled', true);
                    $('.add_card_btn_mob').prop('disabled', true);
                    $('.add_card').prop('disabled', true);
                    const radioButtons = document.querySelectorAll('input[name="box_type"]');
                    radioButtons.forEach(radio => radio.checked = false);
                    const sizeDropdown = document.getElementById('size');
                    sizeDropdown.selectedIndex = 0;
                    const sizeDropdown1 = document.getElementById('size1');
                    sizeDropdown1.selectedIndex = 0;
                    location.reload();
                }
            },
            cache: false // Disable caching for the AJAX response
        });
    })
    // $(document).ready(function() {
    //     $('.add-to-box').click(function(e) {
    //         e.preventDefault();
    //         let id = $(this).attr('id');
    //         let qty = $('#qty').val();
    //         $.ajax({
    //             url: "<?php echo url('/'); ?>/cart/add",
    //             method: "POST",
    //             data: {
    //                 id: id,
    //                 qty: qty,
    //                 "_token": "{{ csrf_token() }}",
    //             },
    //             success: function(response) {
    //                 if (response.error) {
    //                     // Handle error response
    //                 } else {
    //                     $('#cartValue').html(response.qty);
    //                     $('#cartValue1').html(response.qty);
    //                     $('#cartValue2').html(response.qty);
    //                     // showToastr(response.msg, response.msg_type);
    //                     $.post('{{ route('hearder_cart') }}', {
    //                         _token: '{{ csrf_token() }}'
    //                     }, function(data) {
    //                         $('#hearder_cart').html(data);
    //                     });
    //                 }
    //             },
    //             cache: false // Disable caching for the AJAX response
    //         });
    //     });
    // });

    document.addEventListener('DOMContentLoaded', function () {
        const productsPerPage = 24; // Number of products to display per batch
        const productCards = document.querySelectorAll('.product-card'); // All product cards
        const totalProducts = productCards.length; // Total number of products
        const progressBar = document.getElementById('progress-bar'); // Progress bar element
        const viewedCount = document.getElementById('viewed-count'); // Element showing the current number of viewed products
        const loadMoreButton = document.getElementById('load-more'); // "Load More" button

        let currentIndex = productsPerPage; // Tracks the current number of displayed products

        // Function to update the progress bar and tracker
        function updateProgress() {
            // Update the count of viewed products
            viewedCount.textContent = currentIndex;

            // Calculate and set the width of the progress bar
            const progressPercentage = (currentIndex / totalProducts) * 100;
            progressBar.style.width = progressPercentage + '%';
            progressBar.setAttribute('aria-valuenow', currentIndex);

            // Hide the "Load More" button when all products are displayed
            if (currentIndex >= totalProducts) {
                loadMoreButton.style.display = 'none';
            }
        }

        // Event listener for the "Load More" button
        loadMoreButton.addEventListener('click', function () {
            // Show the next set of products
            const nextIndex = currentIndex + productsPerPage;

            for (let i = currentIndex; i < nextIndex && i < totalProducts; i++) {
                productCards[i].style.display = 'block'; // Make the product card visible
            }

            // Update the current index to reflect the total number of displayed products
            currentIndex = Math.min(nextIndex, totalProducts);

            // Update the progress bar and tracker
            updateProgress();
        });

        // Initial progress update
        updateProgress();
    });


    fetchBoxes();
    fetchBoxes1();


</script>

@endsection
