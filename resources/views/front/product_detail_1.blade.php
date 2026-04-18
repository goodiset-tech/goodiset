@extends('layout.app')

<?php
use App\Models\Admins\Category;
use App\Models\Admins\Product;
use App\Models\Admins\Gallerie;
use App\Models\Admins\Rating;
?>


@section('content')
    @foreach ($product as $item)
        <!-- Page Header Start -->
        <div class="container-fluid bg-secondary mb-5">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                <h2 class="font-weight-semi-bold text-uppercase mb-3">Product Detail</h2>
                <div class="d-inline-flex">
                    <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"
                        style=" background-color: transparent; ">
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
                            class="breadcrumb-item"><a itemtype="https://schema.org/Thing" itemprop="item"
                                href="/"><span itemprop="name"><i class="icofont icofont-ui-home"></i>
                                    Home</span></a></a>
                            <meta itemprop="position" content="1" />
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
                            class="breadcrumb-item">
                            <a itemtype="https://schema.org/Thing" itemprop="item" href="/category/{{ $cate->slug }}">
                                <span itemprop="name">{{ $cate->name }}</span> </a>
                            <meta itemprop="position" content="2" />
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
                            class="breadcrumb-item" class="breadcrumb-item active">
                            <a itemtype="https://schema.org/Thing" itemprop="item" href="/product/{{ $item->slug }}">
                                <span itemprop="name">{{ $item->product_name }}</span>
                                <meta itemprop="position" content="3" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <style>
            @keyframes changeViewerNumber {

                0% {

                    content: "95";

                }

                10% {

                    content: "85";

                }

                20% {

                    content: "90";

                }

                25% {

                    content: "92";

                }

                35% {

                    content: "102";

                }

                50% {

                    content: "109";

                }

                60% {

                    content: "81";

                }

                75% {

                    content: "89";

                }

                75% {

                    content: "97";

                }

                100% {

                    content: "110";

                }

            }


            .viewer-count span#viewerNumber::after {

                content: "X";

                animation: changeViewerNumber 10s infinite;

            }
        </style>
        <!-- Shop Detail Start -->
        <div class="" itemtype="https://schema.org/Product" itemscope>
            <meta itemprop="mpn" content="DealStore_{{ $item->id }}" />
            <meta itemprop="name" content="{{ $item->product_name }}" />
            <?php
            
            ?>
            <link itemprop="image" href="/{{ $item->image_one }}" />


            <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
                <meta itemprop="priceCurrency" content="PKR" />
                <meta itemprop="price" content="{{ $item->discount_price }}" />
                <meta itemprop="priceValidUntil" content="2030-12-30" />
                <meta property="og:availability" content="<?= $item->product_quantity < 1 ? 'OutOfStock' : 'InStock' ?>" />
                <meta property="product:availability"
                    content="<?= $item->product_quantity < 1 ? 'OutOfStock' : 'InStock' ?>" />
                <meta itemprop="availability"
                    content="https://schema.org/<?= $item->product_quantity < 1 ? 'OutOfStock' : 'InStock' ?>" />
                <meta itemprop="itemCondition" content="https://schema.org/NewCondition" />
                <link itemprop="url" href="https://dealstore.com.pk/product/{{ $item->slug }}" />
                <div itemprop="seller" itemtype="https://schema.org/Organization" itemscope>
                    <meta itemprop="name" content="{{ $brand->name }}" />
                </div>
            </div>

            <div itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating" itemscope>
                <?php
                    $count = 0;
                    $totalrating = 0;
                    $getreview = DB::table('rating')->where('status', '1')->where('pid',
                        $item->id)->orderby('id', 'desc')->get();
                    $countcustomer = DB::table('rating')->where('status', '1')->where('pid',
                        $item->id)
                        ->count();
                    if($countcustomer != 0 && $getreview){
                    foreach ($getreview as $avg){
                        $count = $count + $avg->rate;
                    }
                    $totalrating = $count / $countcustomer;
                    $finalresult = round($totalrating);
                ?>
                <meta itemprop="reviewCount" content="{{ $countcustomer }}" />
                <meta itemprop="ratingValue" content="{{ $finalresult }}" />
                <?php }?>
            </div>
            <div itemprop="review" itemtype="https://schema.org/Review" itemscope>
                <?php
                    foreach ($getreview as $avg){ ?>
                <div itemprop="author" itemtype="https://schema.org/Person" itemscope>
                    <meta itemprop="name" content="{{ $avg->name }}" />
                </div>
                <div itemprop="reviewRating" itemtype="https://schema.org/Rating" itemscope>
                    <meta itemprop="ratingValue" content="{{ $avg->rate }}" />
                    <meta itemprop="bestRating" content="5" />
                </div>
                <?php }?>
            </div>
            <meta itemprop="sku" content="{{ $item->sku }}" />
        </div>
        <div class="container-fluid py-5">
            <div class="row px-xl-5">
                <div class="col-lg-5 pb-5">
                    <div id="product-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner border">
                            <div class="carousel-item active">
                                <img class="w-100 h-100" src="/{{ $item->image_one }}" alt="Image">
                            </div>
                            <?php $Galleries = Gallerie::where(['product_id' => $item->id])->get(); ?>
                            @foreach ($Galleries as $Gallerie)
                                <div class="carousel-item">
                                    <img class="w-100 h-100" src="{{ $Gallerie->photo }}" alt="Image">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" title="prev" data-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" title="next" data-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 pb-5">
                    <h3 class="font-weight-semi-bold">{{ $item->product_name }}</h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                        </div>
                        <?php
                        $data = Rating::where('pid', $item->id)
                            ->where('status', 1)
                            ->sum('rate');
                        $count = Rating::where(['pid' => $item->id])
                            ->where('status', 1)
                            ->count();
                        if ($count && $data) {
                            $rate = $data / $count;
                        } else {
                            $rate = 0;
                        }
                        ?>
                        <small class="pt-1">({{ number_format($rate, 2) }}/5.00)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">Rs:{{ $item->discount_price }}</h3>
                    <p class="mb-4"><?= $item->short_discriiption ?></p>

                    <table class="table table-striped">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Category : </td>
                                <td><a href="/category/{{ $cate->slug }}">{{ $cate->name }}</a></td>
                            </tr>
                            <tr>
                                <td>Brand : </td>
                                <td><a href="/brand/{{ $brand->slug }}">{{ $brand->name }}</a></td>
                            </tr>

                            <tr>
                                <td>Customer Watching</td>
                                <td>
                                    <div class="viewer-count">👁️<span id="viewerNumber"> </span> people watching this
                                        product now! </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Payment</td>
                                <td>Cash on Delivery Available</td>
                            </tr>

                            <tr>
                                <td>Shipping : </td>
                                <td>2 - 3 Business Days (in Pakistan)</td>
                            </tr>
                            <tr>
                                <?php if($item->product_quantity<1){?>
                                <td>Availability : </td>

                                <td> <strong class="badge badge-danger">Out Of Stock</strong></span> </td>
                                <?php }else{?>
                                <td>Availability : </td>
                                <td> <strong class="badge badge-success">{{ $item->product_quantity }} In
                                        Stock</strong></span> </td>
                                <?php }?>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus" title="minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary text-center" title="qty"
                                id="qty" name="qty" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus" title="plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button title="cart" class="btn btn-primary px-3 add-to-cart"
                            <?php if($item->product_quantity<1){?>disabled<?php }?> id="{{ $item->id }}"><i
                                class="fa fa-shopping-cart mr-1"></i><?php if($item->product_quantity<1){?>SOLD OUT<?php }else{?> Add
                            To Cart<?php }?></button><br><br>

                    </div>
                    <div class="d-flex pt-2">

                        <div class="d-inline-flex">
                            <button title="buy" class="btn btn-danger px-3 add-to-cart-item1"
                                <?php if($item->product_quantity<1){?>disabled<?php }?> id="{{ $item->id }}"
                                href="#"><i class="fa fa-shopping-bag"></i> <?php if($item->product_quantity<1){?>SOLD
                                OUT<?php }else{?>Buy Now<?php }?></button>
                            <button title="whatsapp"
                                onclick="window.location='https://api.whatsapp.com/send?phone=<?= $sett->phone ?>&amp;text=Hello, I want to purchase:*{{ $item->product_name }}* Price:*{{ $item->discount_price }} URL:*{{ url('/product/') }}/{{ $item->slug }}* Thank You !';"
                                id="shake" class="btn btn-success px-3 ml-2"><i class="fa fa-phone"></i> Chat On
                                Whatsapp</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Tags & Keywords</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews
                            ({{ $rcount }})</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-4">Faq</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            <h5>Buy {{ $item->product_name }} Online in Pakistan From DealStore.com.pk</h5>
                            <?= $item->product_details ?>
                            <p>{{ $item->product_name }} price in Pakistan is Rs.{{ $item->discount_price }} Although you
                                can get it at a discounted price by availing the ongoing sale on DealStore.com.pk</p>
                            <p>Looking To Buy Original <a
                                    href="/product/{{ $item->slug }}">{{ $item->product_name }}</a>? We Have It At Best
                                Price In Pakistan. Order Now And Get It At Your Home.Get The Best Deals On <a
                                    href="/product/{{ $item->slug }}">{{ $item->product_name }}</a> From <a
                                    href="https://dealstore.com.pk/">DealStore.com.pk</a>. {{ $item->product_name }}
                                Offers Online In Karachi, Lahore, Islamabad &amp; All Across Pakistan. Cash On Delivery.</p>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <div class="items-Product-Tags">
                                <div class="reviews__comment--content">
                                    <h3>Tag's</h3>
                                    <?php 
                                        $tags = explode(',',$item['tags']);
                                        foreach($tags as $k=> $v){
                                            if(!empty($v))
                                                {
                                            // $tag = str_replace(' ', '-', $v);
                                            $tag = str_replace("-", " ", $v);
                                        ?>
                                    <a href="/tags/{{ $v }}" class="btn btn-primary"><?= $tag ?></a>
                                    <?php }}?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">{{ $rcount }} Reviews on {{ $item->product_name }}</h4>
                                    @foreach ($rating as $v)
                                        <div class="media mb-4">
                                            <img src="/public/images/user.webp" width="100px" height="100px"
                                                alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                            <div class="media-body">
                                                <h6>{{ $v->name }} <small style="font-size: 14px; color: green;"><i
                                                            class="fa fa-check-circle"></i> Verified Purchase</small> -
                                                    <i>{{ date(' F d Y ', strtotime($v->created_at)) }}</i></small></h6>
                                                @if ($v->rate == 5)
                                                    <div class="text-primary mb-2">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        ({{ $v->rate }})
                                                    </div>
                                                @else
                                                    <div class="text-primary mb-2">
                                                        <i class="fas fa-star"></i>
                                                        ({{ $v->rate }})
                                                    </div>
                                                @endif
                                                <p>{{ $v->review }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>

                                    <form action="/rating_submit" method="POST">
                                        @csrf
                                        <input type="hidden" name="pid" value="{{ $item->id }}">

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name"
                                                required placeholder="Your Name....">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email"
                                                required placeholder="Your Email....">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="rating">
                                                <option value="5">5 Star(Excellent)</option>
                                                <option value="4">4 Star(Better)</option>
                                                <option value="3">3 Star(Good)</option>
                                                <option value="2">2 Star(Poor)</option>
                                                <option value="1">1 Star(Very bad)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea id="message" cols="10" rows="3" class="form-control" name="review" required
                                                placeholder="Your Comments...."></textarea>
                                        </div>
                                        <div class="form-group mb-0">
                                            <input name="submit" type="submit" value="Leave Your Review"
                                                class="btn btn-primary px-3">
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-4">
                            <section>
                                <h3 class="text-center mb-4 pb-2 text-primary fw-bold">Add Question</h3>
                                <div class="main-form mt-30">
                                    <div class="row">

                                        <form action="/faq_submit" method="POST">
                                            @csrf
                                            <input type="hidden" name="pid" value="{{ $item->id }}">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" required
                                                    placeholder="Your Name....">
                                            </div>
                                            <div class="form-group">
                                                <textarea cols="30" rows="3" class="form-control" name="question" required
                                                    placeholder="Your Question...."></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary px-3" name="submit"
                                                    type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <h3 class="text-center mb-4 pb-2 text-primary fw-bold">FAQ</h3>
                                <p class="text-center mb-5">
                                    Find the answers for the most frequently asked questions below
                                </p>
                                <div class="row">
                                    @if ($faq)
                                        @foreach ($faq as $v)
                                            <div class="col-md-6 col-lg-4 mb-4">
                                                <h6 class="mb-3 text-primary"><i
                                                        class="fa fa-paper-plane text-primary pe-2"></i>
                                                    {{ $v->question }}</h6>
                                                <p>
                                                    <strong><u>Answered By:{{ $v->a_name }}</u></strong>
                                                    {{ $v->answer }}
                                                </p>
                                            </div>
                                        @endforeach
                                    @else
                                        <li>No Data Found</li>
                                    @endif
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Shop Detail End -->


        <!-- Products Start -->
        <div class="container-fluid py-5">
            <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
            </div>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel related-carousel">
                        @if (!empty($item->related_product_id))
                            <?php
                            $rpro = [];
                            if (isset($item->related_product_id)) {
                                $rpro = explode(',', $item->related_product_id);
                            }
                            $rprod = Product::whereIn('id', $rpro)->get();
                            ?>
                            @foreach ($rprod as $k => $aproduct)
                                @if ($aproduct->status == 1)
                                    <div class="card product-item border-0">
                                        <div
                                            class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                            <img class="img-fluid w-100" src="{{ asset($aproduct->thumb) }}"
                                                width="281px" height="281px" alt="{{ $aproduct->product_name }}">
                                        </div>
                                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                            <h6 class="text-truncate mb-3"><a
                                                    href="/product/{{ $aproduct->slug }}">{{ $aproduct->product_name }}</a>
                                            </h6>
                                            <div class="d-flex justify-content-center">
                                                <h6>Rs {{ $aproduct->discount_price }}</h6>
                                                <h6 class="text-muted ml-2"><del>Rs {{ $aproduct->selling_price }}</del>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between bg-light border">
                                            <a href="/product/{{ $aproduct->slug }}" class="btn btn-sm text-dark p-0"><i
                                                    class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                            <a class="btn btn-sm text-dark p-0 add-to-cart-item" <?php if ($aproduct->product_quantity < 1) {
                                                echo 'disabled';
                                            } ?>
                                                id="{{ $aproduct->id }}"><i
                                                    class="fas fa-shopping-cart text-primary mr-1"></i><?php if ($aproduct->product_quantity < 1) {
                                                        echo 'Slod Out';
                                                    } else {
                                                        echo 'Add To Cart';
                                                    } ?></a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            @if (!empty($rproducts) && $rproducts->count())
                                @foreach ($rproducts as $k => $aproduct)
                                    @if ($aproduct->status == 1)
                                        <div class="card product-item border-0">
                                            <div
                                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                                <img class="img-fluid w-100" src="{{ asset($aproduct->thumb) }}"
                                                    width="281px" height="281px" alt="{{ $aproduct->product_name }}">
                                            </div>
                                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                                <h6 class="text-truncate mb-3"><a
                                                        href="/product/{{ $aproduct->slug }}">{{ $aproduct->product_name }}</a>
                                                </h6>
                                                <div class="d-flex justify-content-center">
                                                    <h6>Rs {{ $aproduct->discount_price }}</h6>
                                                    <h6 class="text-muted ml-2"><del>Rs
                                                            {{ $aproduct->selling_price }}</del></h6>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between bg-light border">
                                                <a href="/product/{{ $aproduct->slug }}"
                                                    class="btn btn-sm text-dark p-0"><i
                                                        class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                                <a class="btn btn-sm text-dark p-0 add-to-cart-item" <?php if ($aproduct->product_quantity < 1) {
                                                    echo 'disabled';
                                                } ?>
                                                    id="{{ $aproduct->id }}"><i
                                                        class="fas fa-shopping-cart text-primary mr-1"></i><?php if ($aproduct->product_quantity < 1) {
                                                            echo 'Slod Out';
                                                        } else {
                                                            echo 'Add To Cart';
                                                        } ?></a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Products End -->
    @endforeach
    <script>
        let id, qty, price, productTotal;
        $(document).ready(function() {

            $('.ion-close').click(function(e) {
                e.preventDefault();
                id = $(this).attr('productId');
                $.ajax({
                    url: "{{ url('cart/remove') }}",
                    type: "POST",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        location.reload();
                        console.log(id);
                        removeFromView(id, response);
                        updateView(response);
                        location.reload();
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
                price = $(this).attr('productprice');
                $.ajax({
                    url: "{{ url('cart/increment') }}",
                    type: "POST",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.error) {
                            alert('Item out of stock');
                        } else {
                            $('#spec' + id).val(parseInt($('#spec' + id).val()) + 1);
                            qty = $('#spec' + id).val();
                            updateView(response, price);
                        }
                    }
                });
            });

            $('.minus').click(function() {
                id = $(this).attr('productId');
                price = $(this).attr('productprice');
                $.ajax({
                    url: "{{ url('cart/decrement') }}",
                    type: "POST",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        qty = (parseInt($('#spec' + id).val()) - 1);
                        if (qty > 0) $('#spec' + id).val(qty);
                        else {
                            removeFromView(id, response);
                        }
                        updateView(response, price);
                    }
                });
            });

            function updateView(response) {
                productTotal = parseInt(qty * price);
                $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(response.cart.qty);
                $('#cartTotal').html(response.cart.amount);
                $('#productTotal' + id).html(productTotal);
            }

        });
    </script>

    <style>
        /* Id's Being animated */
        #shake {
            animation: Shake5s 5s linear infinite;
        }

        #jump {
            animation: Jump5s 5s linear infinite;
        }

        #rainbow {
            animation: rainbow10s 10s linear infinite
        }

        /* All Animations */
        @keyframes Shake5s {

            0%,
            10%,
            100% {
                transform: rotate(0deg);
            }

            2%,
            6% {
                transform: rotate(5deg);
            }

            4%,
            8% {
                transform: rotate(-5deg);
            }
        }

        @keyframes Jump5s {

            0%,
            5%,
            10%,
            100% {
                transform: translate(0px, 0px)
            }

            2% {
                transform: translate(0px, -20px)
            }

            7% {
                transform: translate(0px, -10px)
            }
        }
    </style>
@endsection
