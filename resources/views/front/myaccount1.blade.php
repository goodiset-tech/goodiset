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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Account</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="/">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Account</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

  <!-- CONTAIN START -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-md-12">

                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Dashboard</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Orders</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
            <div class="row">
              <div class="col-xs-12">
                <div class="heading-part heading-bg mb-30 ">
                  <h2 class="heading m-0 justify-content-center">Account Dashboard</h2>
                </div>
              </div>
            </div>
            @foreach($user as $v)
            <form action="/user_update" method="post" >
            @csrf
                <input type="hidden" value="{{$v->id}}" name="id">
                  <div class="form-group">
                    <label for="old-pass">Name</label>
                    <input type="text" placeholder="Name" name="name" class="form-control" value="{{$v->name}}" required id="old-pass">
                  </div>
                  <div class="form-group">
                    <label for="login-pass">Email</label>
                    <input type="email" placeholder="Enter your Email" class="form-control" name="email" value="{{$v->email}}" required id="login-pass">
                  </div>
                  <div class="form-group">
                    <label for="re-enter-pass">Password</label>
                    <input type="text" placeholder=" your Password" class="form-control" name="pass" value="{{$v->password}}" required id="re-enter-pass">
                  </div>
                  <div class="form-group">
                    <label for="re-enter-pass">Phone</label>
                    <input type="text" placeholder="Phone" class="form-control"  name="phone" value="{{$v->phone}}"required id="re-enter-pass">
                  </div>
                  <div class="form-group">
                    <label for="re-enter-pass">City</label>
                    <input type="text" placeholder="City" class="form-control" name="city" value="{{$v->city}}" required id="re-enter-pass">
                  </div>
                  <div class="form-group">
                    <label for="re-enter-pass">Country</label>
                    <input type="text" placeholder="Country" class="form-control" name="country" value="{{$v->country}}" required id="re-enter-pass">
                  </div>
                  <div class="form-group">
                    <label for="re-enter-pass">Address</label>
                    <input type="text" placeholder="Address" class="form-control" name="address" value="{{$v->address}}" required id="re-enter-pass">
                  </div>
                <div class="col-xs-12">
                  <button class="btn btn-primary" type="submit" name="submit">Update</button>
                  <a href="/logout" class="btn btn-danger">Log Out</a>
                </div>
            </form>
            @endforeach
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                       <div class="row">
                          <div class="col-xs-12 col-md-12">
                            <div class="heading-part heading-bg mb-30">
                              <h2 class="heading m-0">My Orders</h2>
                            </div>
                          </div>
                        </div>

                      <div class="table-responsive col-md-12">
                        <table class="table col-md-12">

                          <thead>
                            <tr>
                                <th>Order placed.</th>
                                <th>Order No.</th>
                                <th>Shipping Company.</th>
                                <th>Track_no.</th>
                                <th>Track_url.</th>
                                <th>Delivery Status.</th>
                                <th >Total.</th>

                            </tr>
                          </thead>
                          <tbody>
                               @foreach($order as $v)
                            <tr>
                            <td>{{$v->created_at}}</td>
                              <td>{{$v->order_no}}</td>
                              <td>{{$v->shipping_company}}</td>
                              <td>{{$v->track_no}}</td>
                              <td><a href="{{$v->track_url}}">{{$v->track_url}}</a></td>
                              <td>
                                   @if($v->dstatus == 0)
                                        <p class="text-danger">Panding</p>
                                        @elseif($v->dstatus == 1)
                                        <p class="text-warning">Completed</p>
                                        @else
                                        <p class="text-success">Deliverd</p>
                                        @endif
                              </td>
                              <td>Rs:{{$v->amount}}</td>

                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>

                    </div>
                </div>
  </div>
</div>
  <!-- CONTAINER END -->

   @endsection
