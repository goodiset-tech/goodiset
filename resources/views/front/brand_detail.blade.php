@extends('layout.app')
@section('content')
<?php 
use App\Models\Admins\Category;
$cate = Category::limit('6')->get();
?>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .pagination .shadow-sm span .cursor-default {
    background: #08c!important;
    color: #fff;
    height: 50px;
}
</style>
<!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
             
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{$brand_id->name}}</h1>
            
            <div class="d-inline-flex">
                <p class="m-0"><a href="/">Home</a></p>
                <p class="m-0 px-2">-</p>
                
                <p class="m-0">{{$brand_id->name}}</p>
                
            </div>
        </div>
    </div>
       
        
    @if(!empty($products) && $products->count())
        <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
           


            <!-- Shop Product Start -->
            <div class="col-lg-12 col-md-12">
                <div class="row pb-3">
                    @foreach ($products as  $k=>$v)
                        @if($v->status == 1)
                            
                            <div class="col-lg-3 col-6 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <a href="/product/{{$v->slug}}"> <img class="img-fluid w-100" src="{{asset($v->thumb)}}" alt="{{$v->product_name}}"> </a>
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3"><a href="/product/{{$v->slug}}">{{$v->product_name}}</a></h6>
                                <div class="d-flex justify-content-center">
                                    <h6>Rs {{$v->discount_price}}</h6><h6 class="text-muted ml-2"><del>Rs {{$v->selling_price}}</del></h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="/product/{{$v->slug}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                <?php if($v->product_quantity < 1){  ?>
                                <a  class="btn btn-sm text-dark p-0 " <?php if($v->product_quantity < 1){ echo"disabled"; }?> id="{{$v->id}}" ><i class="fas fa-shopping-cart text-primary mr-1"></i><?php if($v->product_quantity < 1){?>Sold Out<?php }else{?>Add To Cart<?php }?></a>
                                <?php }else{?>
                                <a  class="btn btn-sm text-dark p-0 add-to-cart-item" <?php if($v->product_quantity < 1){ echo"disabled"; }?> id="{{$v->id}}" ><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="col-12 pb-1">
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-center mb-3" id="svg">
                     {!!$products->render()  !!}
                  </ul>
                </nav>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

               
              
              
           

    @else
    <tr >
        <td colspan="10">There are no data.</td>
    </tr>
    @endif
 
@endsection
