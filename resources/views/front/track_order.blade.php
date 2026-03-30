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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Track Order</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="/">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Track Order</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
   
  
        @if($count > 0)
    <div class="container-fluid pt-5">
       <div class="row px-xl-5">
        <div class="col-xs-12 col-md-12">
            <h2 class="account__content--title h3 mb-20">Orders History</h2>
            <div class="account__table--area">
                <table class="table table-bordered">
                    <thead class="account__table--header">
                        <tr class="account__table--header__child">
                            <th class="account__table--header__child--items">Sr#</th>
                            <th class="account__table--header__child--items">Order</th>
                            <th class="account__table--header__child--items">Date</th>
                            <th class="account__table--header__child--items">Delivery Status</th>
                            <th class="account__table--header__child--items">Shipping Company</th>
                            <th class="account__table--header__child--items">Tracking Url</th>
                            <th class="account__table--header__child--items">Tracking No</th>
                            <th class="account__table--header__child--items">Note</th>
                            <th class="account__table--header__child--items">Total</th>	 	 	 	
                        </tr>
                    </thead>
                    <tbody class="account__table--body mobile__none">
                        @php
                            $no = 1;
                        @endphp
                        @foreach($product as $v)
                        <tr class="account__table--body__child">
                            <td class="account__table--body__child--items">{{$no++}}</td>
                            <td class="account__table--body__child--items">{{$v->order_no}}</td>
                            <td class="account__table--body__child--items">{{ date('Y/m/d', $v->created_at->timestamp) }}</td>
                            @if($v->dstatus == 0)
                            <td class="account__table--body__child--items">Panding</td>
                            @elseif($v->dstatus == 1)
                            <td class="account__table--body__child--items">Completed</td>
                            @elseif($v->dstatus == 2)
                            <td class="account__table--body__child--items">Deliverd</td>
                            @elseif($v->dstatus == 3)
                            <td class="account__table--body__child--items">Cancel</td>
                            @else
                            <td class="account__table--body__child--items">Dispatched </td>
                            @endif
                            @if($v->shipping_company)
                            <td class="account__table--body__child--items">{{$v->shipping_company}}</td>
                            @else
                            <td class="account__table--body__child--items">--</td>
                            @endif
                            @if($v->track_url)
                            <td class="account__table--body__child--items">{{$v->track_url}}</td>
                            @else
                            <td class="account__table--body__child--items">--</td>
                            @endif
                            @if($v->track_no)
                            <td class="account__table--body__child--items">{{$v->track_no}}</td>
                            @else
                            <td class="account__table--body__child--items">--</td>
                            @endif
                            @if($v->note)
                            <td class="account__table--body__child--items">{{$v->note}}</td>
                            @else
                            <td class="account__table--body__child--items">--</td>
                            @endif
                            
                            <td class="account__table--body__child--items">Rs:{{$v->amount}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div> 
        @else
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
        <div class="col-xs-12">
            <div class="col-lg-6 col-md-8 col-sm-8 col-lg-offset-3 col-sm-offset-2">
              <form class="main-form full" action="/trackorder" method="POST">
                  @csrf
                <div class="row">
                  <div class="col-xs-12 mb-20">
                    <div class="heading-part heading-bg">
                      <h2 class="heading">Track Order</h2>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="login-email">Track Order #:</label>
                      <input id="login-email" class="form-control" type="text" required name="num" placeholder="Enter Order No">
                    </div>
                  </div>
                 
                    <button name="submit" type="submit" class="btn btn-primary">Track Order</button>
                  </div>
                 
              </form>
            </div>
          </div>
        </div>
      </div>
            
            @endif
            
  @endsection