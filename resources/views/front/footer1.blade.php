<?php 
use App\Models\Admins\Setting;
use App\Models\Admins\Category;
$pro= Setting::where(['id'=>'1'])->first();
$cate = Category::limit('6')->get();
?>
 <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="/" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1"><img src="{{asset('')}}{{$pro->logo}}" width="250px" height="100%" alt="Logo" ></h1>
                </a>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>{{$pro->homepage_footer}}</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{$pro->email}}</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{$pro->phone}}</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="/"><i class="fa fa-angle-right mr-2"></i>Homepage</a>
                            <a class="text-dark mb-2" href="/page/about"><i class="fa fa-angle-right mr-2"></i>About Us</a>
                            <a class="text-dark mb-2" href="/contact"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                            <a class="text-dark mb-2" href="/blog"><i class="fa fa-angle-right mr-2"></i>Our Blog</a>
                            <a class="text-dark mb-2" href="/shop"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark" href="/track_order"><i class="fa fa-angle-right mr-2"></i>Track Your Order</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">My Account</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="/login"><i class="fa fa-angle-right mr-2"></i>Login</a>
                            <a class="text-dark mb-2" href="/user_register"><i class="fa fa-angle-right mr-2"></i>Register</a>
                            <a class="text-dark mb-2" href="/cart"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>User Details</a>
                            <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>How To Order</a>
                            <a class="text-dark" href="#"><i class="fa fa-angle-right mr-2"></i>Delivery information</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                    required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block  border-0 py-3" style="color:black;" type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">© Copyright 2023 <a class="text-dark font-weight-semi-bold" href="/">{{$pro->site_title}}</a>. All Rights Reserved. 
                </p>
            </div>
           
        </div>
    </div>
    
     <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Added to Cart Successfully</h4>
            </div>
            <div class="modal-body">
                <ul class="cart-list link-dropdown-list">
                    <table class="table table-image">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Qty</th>
              <th scope="col">Total</th>
              <!--<th scope="col">Actions</th>-->
            </tr>
          </thead>
          <tbody id="cart_data">
             
          </tbody>
        </table> 
                    
                      
                     
                    </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Continue Shopping</button>
                 <a href="/checkout" class="btn btn-success">Go To Checkout</a>
            </div>
        </div>
    </div>
</div>
  <!-- FOOTER END --> 