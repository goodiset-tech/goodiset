<div class="main">
       <?php $setting = DB::table('setting')
            ->where('id', '=', '1')
            ->first();
            $cate = DB::table('categories')->get();
            ?>
    <!-- HEADER START -->
  <header class="navbar navbar-custom container-full-sm" id="header">
    <div class="header-top">
      <div class="container">
        <div class="row">
         <div class="col-xs-6">
            <div class="top-link">
              <div class="help-num" >Welcome to DealStore</div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="top-link right-side">
              <div class="help-num" >Need Help? : 0300-3724942</div>
            </div>
          </div>
        </div>
      </div>
    </div>    <hr>
    <div class="header-middle">
      <div class="container">
    
        <div class="row">
          <div class="col-lg-2 col-md-3 col-lgmd-20per">
            <div class="header-middle-left">
              <div class="navbar-header float-none-sm">
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"><i class="fa fa-bars"></i></button>
                <a class="navbar-brand page-scroll" href="/">
                  <img alt="Site Logo" src="{{asset('')}}{{$setting->logo}}" width="250px" height="80px">
                </a> 
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-lgmd-60per">
            <div class="header-right-part">
              <div itemscope itemtype="https://schema.org/WebSite" class="main-search">
                <div class="header_search_toggle desktop-view">
                    <meta itemprop="url" content="/"/>
              <form itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction" class="search" action="/search" method="get">
                  <meta itemprop="target" content="https://etsystore.detox.com.pk/search">
                    <div class="search-box">
                       <input itemprop="query-input"  type="text" class="input-text" name="text" placeholder="I’m shopping for..." required>
                      <button class="search-btn"></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-3 col-lgmd-20per">
            <div class="middle-link right-side">
              <ul>
                <li class="login-icon content">
                  <a class="content-link">
                  <span class="content-icon"></span> 
                  </a> 
                  <a href="/login" title="Login">Login</a> or
                  <a href="/user_register" title="Register">Register</a>
                  <div class="content-dropdown">
                    <ul>
                      <li class="login-icon"><a href="/login" title="Login"><i class="fa fa-user"></i> Login</a></li>
                      <li class="register-icon"><a href="/user_register" title="Register"><i class="fa fa-user-plus"></i> Register</a></li>
                    </ul>
                  </div>
                </li>
                <li class="track-icon">
                  <a href="/track_order" title="Track your order"><span></span> Track your order</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header-bottom"> 
      <div class="container">
        <div class="row position-r">
          <div class="col-lg-2 col-md-3 col-lgmd-20per position-initial">
            <div class="sidebar-menu-dropdown home">
              <a class="btn-sidebar-menu-dropdown"><span></span> Categories </a>
              <div id="cat" class="cat-dropdown">
                <div class="sidebar-contant">
                  <div id="menu" class="navbar-collapse collapse" >
                    <div class="middle-link mobile right-side">
                      <ul>
                        <li class="login-icon content">
                          <a class="content-link">
                          <span class="content-icon"></span> 
                          </a> 
                          <a href="/login" title="Login">Login</a> or
                          <a href="/user_register" title="Register">Register</a>
                          <div class="content-dropdown">
                            <ul>
                              <li class="login-icon"><a href="/login" title="Login"><i class="fa fa-user"></i> Login</a></li>
                              <li class="register-icon"><a href="/user_register" title="Register"><i class="fa fa-user-plus"></i> Register</a></li>
                            </ul>
                          </div>
                        </li>
                        <li class="track-icon">
                          <a href="/track_order" title="Track your order"><span></span> Track your order</a>
                        </li>
                        
                      </ul>
                    </div>
                    <ul class="nav navbar-nav ">
                @foreach($cate as $v)
                      <li class="level"><a href="/category/{{$v->slug}}" class="page-scroll"><i class="fa fa-bolt"></i>{{$v->name}}</a></li>
                    @endforeach
                    </ul>
                    <div class="header-top mobile">
                      <div class="">
                        <div class="row">
                          <div class="col-xs-12">
                            <div class="top-link top-link-left ">
                              <ul>
                                <li class="language-icon">
                                  <select>
                                    <option selected="selected" value="">English</option>
                                  </select>
                                </li>
                                
                              </ul>
                            </div>
                          </div>
                          <div class="col-xs-12">
                            <div class="top-link right-side">
                              <div class="help-num" >Need Help? : 0300-3724942</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-lgmd-60per">
            <div class="bottom-inner">
              <div class="position-r">          
                <div class="nav_sec position-r">
                  <div class="mobilemenu-title mobilemenu">
                    <span>Menu</span>
                    <i class="fa fa-bars pull-right"></i>
                  </div>
                  <div class="mobilemenu-content">
                    <ul class="nav navbar-nav" id="menu-main">
                      <li >
                        <a href="/">Home</a>
                      </li>
                      <li >
                        <a href="/shop">Shop</a>
                      </li>
                      <li>
                        <a href="/page/about">About Us</a>
                      </li>
                      <li>
                        <a href="/blog">Blog</a>
                      </li>
                      <li>
                        <a href="/contact">Contact</a>
                      </li>
                      <li class="level">
                        <span class="opener plus"></span>
                        <a class="page-scroll">Shop by Category</a>
                        <div class="megamenu mobile-sub-menu">
                          <div class="megamenu-inner-top">
                            <ul class="sub-menu-level1">
                                 @foreach($cate as $v)
                              <li class="level2">
                                <ul class="sub-menu-level2 ">
                                    
                                  <li class="level3"><a href="/category/{{$v->slug}}"><span>■</span>{{$v->name}}</a></li>
                                </ul>
                             
                              </li>
                                  @endforeach
                            </ul>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-3 col-lgmd-20per">
            <div class="right-side float-left-xs header-right-link">
              <ul>
                <li class="cart-icon"> <a href="#"> <span> <small class="cart-notification" id="cartValue">{{ Session::has('cart') ? App\Helpers\Cart::qty() : 0 }}</small> </span> </a>
                  <div class="cart-dropdown header-link-dropdown">
                    <ul class="cart-list link-dropdown-list" id="hearder_cart" >
                    @foreach (App\Helpers\Cart::products() as $product)
                      <li>
                        <div class="media"> <a class="pull-left"> <img alt="Electrro" src="/{{$product->image_one}}" width="100px"height="100px"></a>
                          <div class="media-body"> <span><a>{{$product->product_name}}</a></span>
                            <p class="cart-price">Rs {{$product->discount_price}}</p>
                            <div class="product-qty">
                              <label>Qty:</label>
                              <div class="custom-qty">
                                <input type="text" name="qty" maxlength="8" value="{{$product['qty']}}" title="Qty" class="input-text qty">
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                    <!--<p class="cart-sub-totle"> <span class="pull-left">Cart Subtotal</span> <span class="pull-right"><strong class="price-box"></strong></span> </p>-->
                    <div class="clearfix"></div>
                    <div class="mt-20"> <a href="/cart" class="btn-color btn">Cart</a> <a href="/checkout" class="btn-color btn right-side">Checkout</a> </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- HEADER END --> 
  