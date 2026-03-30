@extends('layout.app')
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
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Checkout</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Checkout Start -->
<form action="/order_submit" method="post" class="main-form full">
    @csrf
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                    @if(Session::get('user'))
                        @foreach($user as $v)
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Name</label>
                                    <input class="form-control" type="text" value="{{$v->name}}" required name="name"
                                        placeholder="Enter Your Full Name">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" type="text" value="{{$v->email}}" required name="email"
                                        placeholder="Enter Your Active Email ID">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" value="{{$v->phone}}" required name="phone"
                                        placeholder="Enter Your Contact Number">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Address</label>
                                    <input class="form-control" type="text" value="{{$v->address}}" required name="address"
                                        placeholder="Enter Your House Number & Street Name, Area">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Country</label>
                                    <select class="custom-select" value="{{$v->country}}" required name="country">
                                        <option selected>Pakistan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <input class="form-control" type="text" value="{{$v->city}}" required name="city"
                                        placeholder="Enter Your City/Town">
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" required name="name" placeholder="Enter Your ">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" required name="email"
                                    placeholder="Enter Your Active Email ID">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" required name="phone"
                                    placeholder="Enter Your Contact Number">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" required name="address"
                                    placeholder="Enter Your House Number & Street Name, Area">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select" required name="country">
                                    <option selected>Pakistan</option>

                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" required name="city"
                                    placeholder="Enter Your City/Town">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <div class="d-flex justify-content-between">
                            <h4>Name</h4>
                            <h4>Qty</h4>
                            <h4>Price</h4>
                        </div>
                        @foreach (App\Helpers\Cart::products() as $product)
                            <div class="d-flex justify-content-between">
                                <p>{{$product->product_name}}</p>
                                <p>{{$product->qty}}</p>
                                <p>RS:{{$product->discount_price}}</p>
                            </div>
                        @endforeach

                        <hr class="mt-0">
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Shipping Fee</h5>
                            <h5 class="font-weight-bold">Rs:250</h5>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">Rs:{{Session::get('cart')['amount'] + 250}}</h5>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" checked name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Cash On Delivery</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" type="submit"
                            name="submit">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Checkout End -->
@endsection
