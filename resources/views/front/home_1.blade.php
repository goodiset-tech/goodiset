@extends('layout.app1')
<?php
use App\Models\Catagorie;
use App\Models\Subcatagorie;
use App\Models\Childcatagorie;
use App\Models\Admins\Product;
use App\Models\Gallerie;
use Illuminate\Support\Facades\Session;
use App\Models\Admins\Setting;
use App\Models\Admins\Rating;
use App\Models\Admins\Slider;
?>
@section('content')
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->
    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Featured Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($fproducts as $k => $v)
                <div class="col-lg-3 col-md-6 col-6 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <a href="/product/{{ $v->slug }}"> <img class="img-fluid w-100" width="281px"
                                    height="281px" src="{{ asset($v->thumb) }}" alt="{{ $v->product_name }}"> </a>
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><a href="/product/{{ $v->slug }}">{{ $v->product_name }}</a>
                            </h6>
                            <div class="d-flex justify-content-center">
                                <h6>Rs {{ $v->discount_price }}</h6>
                                <h6 class="text-muted ml-2"><del>Rs {{ $v->selling_price }}</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="/product/{{ $v->slug }}" class="btn btn-sm text-dark p-0"><i
                                    class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a class="btn btn-sm text-dark p-0 add-to-cart-item" <?php if ($v->product_quantity < 1) {
                                echo 'disabled';
                            } ?>
                                id="{{ $v->id }}"><i
                                    class="fas fa-shopping-cart text-primary mr-1"></i><?php if ($v->product_quantity < 1) {
                                        echo 'Slod Out';
                                    } else {
                                        echo 'Add To Cart';
                                    } ?></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Products End -->
    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($aproducts as $k => $v)
                <div class="col-lg-3 col-md-6 col-6 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <a href="/product/{{ $v->slug }}"> <img class="img-fluid w-100" width="281px"
                                    height="281px" src="{{ asset($v->thumb) }}" alt="{{ $v->product_name }}"> </a>
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><a
                                    href="/product/{{ $v->slug }}">{{ $v->product_name }}</a></h6>
                            <div class="d-flex justify-content-center">
                                <h6>Rs {{ $v->discount_price }}</h6>
                                <h6 class="text-muted ml-2"><del>Rs {{ $v->selling_price }}</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="/product/{{ $v->slug }}" class="btn btn-sm text-dark p-0"><i
                                    class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a class="btn btn-sm text-dark p-0 add-to-cart-item" <?php if ($v->product_quantity < 1) {
                                echo 'disabled';
                            } ?>
                                id="{{ $v->id }}"><i
                                    class="fas fa-shopping-cart text-primary mr-1"></i><?php if ($v->product_quantity < 1) {
                                        echo 'Slod Out';
                                    } else {
                                        echo 'Add To Cart';
                                    } ?></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Products End -->

    <!-- Products Start -->
    <?php 
        $cate = DB::table('categories')->where('status',1)->get();
        foreach($cate as $v){
            $pro = DB::table('products')->where('category_id',$v->id)->limit('10')->inRandomOrder()->get();
        ?>
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">{{ $v->name }}</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($pro as $k => $v)
                <div class="col-lg-3 col-md-6 col-6 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <a href="/product/{{ $v->slug }}"> <img class="img-fluid w-100" width="281px"
                                    height="281px" src="{{ asset($v->thumb) }}" alt="{{ $v->product_name }}"> </a>
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><a
                                    href="/product/{{ $v->slug }}">{{ $v->product_name }}</a></h6>
                            <div class="d-flex justify-content-center">
                                <h6>Rs {{ $v->discount_price }}</h6>
                                <h6 class="text-muted ml-2"><del>Rs {{ $v->selling_price }}</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="/product/{{ $v->slug }}" class="btn btn-sm text-dark p-0"><i
                                    class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a class="btn btn-sm text-dark p-0 add-to-cart-item" <?php if ($v->product_quantity < 1) {
                                echo 'disabled';
                            } ?>
                                id="{{ $v->id }}"><i
                                    class="fas fa-shopping-cart text-primary mr-1"></i><?php if ($v->product_quantity < 1) {
                                        echo 'Slod Out';
                                    } else {
                                        echo 'Add To Cart';
                                    } ?></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Products End -->
    <?php }?>

    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <?php 
                        $brand = DB::table('brands')->get();
                        foreach($brand as $v){
                    ?>
                    <div class="vendor-item border p-4">
                        <a href="/brand/{{ $v->slug }}"><img src="{{ asset($v->brand_logo) }}" alt=""></a>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
@endsection
