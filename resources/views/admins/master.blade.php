<!DOCTYPE html>
<html>

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link href="{{ asset('backend_assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend_assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('backend_assets/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend_assets/ckeditor/samples/css/samples.css') }}">

    <link href="{{ asset('backend_assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('backend_assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('backend_assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('backend_assets/css/plugins/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('backend_assets/css/plugins/summernote/summernote-bs3.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <style>
        @font-face {
            font-family: currencyFontStyle;
            src: url('{{ asset('front/font/currency.woff2') }}') format('woff2');
            font-display: swap;
            font-weight: 600;
            font-style: normal;
        }

        .icon-aed {
            font-family: 'currencyFontStyle', sans-serif !important;
        }
    </style>

</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation" style="overflow-y: auto;">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu"
                    style="
                  max-height: 100vh;
    overflow-y: auto;
    ">
                    <li class="nav-header">
                        <div class="dropdown profile-element">

                            <img alt="image" class="img-circle" style="border-radius: 0px;"
                                src="{{ asset('') }}{{ getSetting('logo') }}" width="107px" height="unset" />


                            {{-- <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="{{ url('/') }}/admin/logout">Logout</a></li>
                            </ul> --}}
                        </div>
                        <div class="logo-element"><img src="{{ asset('') }}{{ getSetting('logo1') }}"
                                height="48px" alt=""></div>
                    </li>
                    @if (auth()->guard('admin')->user()->roles->contains('id', 1))
                        <li
                            class="@yield('dashboard_active') @yield('sales_active')  @yield('vat_report') @yield('inventory_active') @yield('visits_active')">
                            <a href="#"> <i class="fa-solid fa-gauge"></i> <span
                                    class="nav-label">Dashboard</span><span class="fa arrow"></span></a>
                            <ul
                                class="nav nav-second-level collapse @yield('dashboard_active') @yield('sales_active') @yield('vat_report') @yield('inventory_active') @yield('visits_active')">
                                <li class="@yield('dashboard_active')">
                                    <a href="{{ route('admins.dashboard') }}"> <span
                                            class="nav-label">General</span></a>
                                </li>
                                <li class="@yield('sales_active') @yield('vat_report')">
                                    <a href="{{ route('admins.sales') }}"> <span class="nav-label">Sales</span></a>
                                </li>
                                {{-- <li class="@yield('inventory_active')">
                                    <a href="{{ route('admins.inventory') }}"> <span class="nav-label">Inventory</span></a>
                                </li> --}}
                                <li class="@yield('visits_active')">
                                    <a href="{{ route('admins.visits') }}"> <span class="nav-label">Visits</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="@yield('order')" style="display:;">
                            <a href="#"><i class="fa-solid fa-box"></i> <span class="nav-label">Order
                                    Management</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('orderc1')">

                                <li class="@yield('order1')"><a href="{{ route('admins.orders') }}">New Orders</a>
                                </li>
                                <li class="@yield('dorder')"><a
                                        href="{{ route('admins.dispatched_orders') }}">Dispatched
                                        Orders</a></li>
                                <li class="@yield('deorder')"><a
                                        href="{{ route('admins.deliverd_orders') }}">Delivered
                                        Orders</a></li>
                                <li class="@yield('corder')"><a
                                        href="{{ route('admins.complete_orders') }}">Confirmed
                                        Orders</a></li>
                                <li class="@yield('caorder')"><a href="{{ route('admins.canceled_orders') }}">Canceled
                                        Orders</a></li>
                                <li class="@yield('drorder')"><a href="{{ route('admins.draft_orders') }}">Draft
                                        Orders</a>
                                </li>
                                <li class="@yield('order_log')"><a href="{{ route('admins.orders.logreport') }}">Orders
                                        Log Report</a>
                                </li>

                            </ul>
                        </li>
                        {{-- <li class="@yield('category_active')">
                            <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Category</span><span
                                    class="fa arrow"></span></a>
                            <ul
                                class="nav nav-second-level collapse @yield('category_active_c1') @yield('category_active_c2') @yield('category_active_c3')">
                                <li class="@yield('category_child_1_active')"><a
                                        href="{{ route('admins.category') }}">Category</a>
                                </li>
                                <li class="@yield('category_child_2_active')"><a
                                        href="{{ route('admins.subcategory') }}">Sub
                                        Category</a></li>
                                <li style="display:;" class="@yield('category_child_3_active')"><a
                                        href="{{ route('admins.brand') }}">Brand</a></li>
                            </ul>
                        </li> --}}
                        <li
                            class="@yield('product_active') @yield('category_child_1_active') @yield('category_child_2_active') @yield('product_log') @yield('category_child_3_active')">
                            <a href="#"><i class=" fa-solid fa-boxes-stacked"></i> <span class="nav-label">Product
                                    Management</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('product_active_c1')">
                                {{-- <li class="@yield('product_child_1_active')"><a
                                        href="{{ route('admins.product_form') }}">Add
                                        Product</a>
                                </li> --}}
                                <li class="@yield('product_child_2_active')"><a href="{{ route('admins.products') }}">Products</a>
                                </li>
                                <li class="@yield('category_child_1_active')"><a
                                        href="{{ route('admins.category_all') }}">Category</a>
                                </li>
                                <li class="@yield('category_child_2_active')"><a
                                        href="{{ route('admins.subcategory') }}">SubCategory</a>
                                </li>
                                <li style="display:;" class="@yield('category_child_3_active')"><a
                                        href="{{ route('admins.brand') }}">Brand</a></li>
                                <li class="@yield('product_log')"><a
                                        href="{{ route('admins.products.logreport') }}">Product Log Report</a>
                                </li>

                            </ul>
                        </li>
                        <li class="@yield('warehouse_active') @yield('inventory_request_active') @yield('product_inventory')" style="display:;">
                            <a href="#"><i class="fa-solid fa-seedling"></i> <span class="nav-label">Inventory
                                </span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li class="@yield('warehouse_active')"><a
                                        href="{{ route('admins.warehouses.index') }}">Warehouses</a>
                                </li>
                                <li class="@yield('inventory_request_active')"><a
                                        href="{{ route('admins.inventory-requests.index') }}">Inventory Requests</a>
                                </li>
                                <li class="@yield('product_inventory')"><a
                                        href="{{ route('admins.products.inventory.report') }}">Product Inventory</a>
                                </li>

                            </ul>
                        </li>
                        <li
                            class="@yield('theme_active') @yield('size_active') @yield('color_active') @yield('flavour_active') @yield('flavour_active') @yield('theme_active')">
                            <a href="#"><i class="fa-solid fa-tags"></i> <span class="nav-label">Products
                                    Attributes</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('flavour_active')">
                                {{-- <li class="@yield('product_attribute_0_active')"><a
                                        href="{{route('admins.clarity')}}">Clarity</a></li> --}}
                                <li class="@yield('size_active')"><a href="{{ route('admins.size') }}">Size</a></li>
                                <li class="@yield('color_active')"><a href="{{ route('admins.colors') }}">Color</a></li>
                                <li class="@yield('product_attribute_child_2_active')"><a href="{{ route('admins.product_type') }}">Product
                                        Types</a></li>
                                <li class="@yield('product_attribute_child_2_active')"><a href="{{ route('admins.ingredient') }}">
                                        Ingredient</a>
                                </li>
                                <li class="@yield('product_attribute_child_2_active')"><a href="{{ route('admins.allergen') }}"> Allergen</a>
                                </li>
                                <li class="@yield('flavour_active')"><a href="{{ route('admins.flavour') }}">Flavours</a>
                                </li>
                                <li class="@yield('product_attribute_child_2_active')"><a href="{{ route('admins.package_type') }}">Package
                                        Types</a></li>
                                <li class="@yield('basket_active')"><a href="{{ route('admins.basket_type') }}">Basket
                                        Types</a>
                                </li>
                                <li class="@yield('theme_active')"><a href="{{ route('admins.theme') }}">Themes</a></li>

                                {{-- <li class="@yield('product_attribute_child_3_active')"><a
                                        href="{{route('admins.shap')}}">Shape</a></li> --}}

                            </ul>
                        </li>
                        <li class="@yield('box_active_c1')">
                            <a href="#"><i class="fa-solid fa-box-open"></i> <span class="nav-label">Box
                                    Management</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('box_active_c1')">
                                <li class="@yield('box_active_c1')"><a
                                        href="{{ route('admins.box_customize') }}">Customize
                                        Boxes</a>
                                </li>
                                <li class="@yield('box_active_c1')"><a href="{{ route('admins.box_size') }}">Box Sizes</a>
                                </li>
                            </ul>
                        </li>
                        <li class="@yield('campaign-emails') @yield('account_active') @yield('news_letter_active')">
                            <a href="#"><i class="fa-solid fa-user-group"></i> <span
                                    class="nav-label">Customers</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('box_active_c1')">
                                <li class="@yield('campaign-emails')">
                                    <a href="{{ URL::to('admin/campaign-emails') }}">Pre-Lanuch Emails</a>
                                </li>
                                <li class="@yield('news_letter_active')" style="display:;">
                                    <a href="{{ route('admins.news_letters') }}"> <span class="nav-label">News
                                            Letters</span> </a>
                                </li>
                                <li class="@yield('account_active')" style="display:;">
                                    <a href="{{ route('admins.accounts') }}"> <span class="nav-label">Accounts</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="@yield('pages_active') @yield('slider') @yield('announcements_active') @yield('order_notifications') @yield('popup_active') @yield('box_cal_active_c1') @yield('languages_active') @yield('promotional_banner')">
                            <a href="#"><i class="fa-solid fa-globe"></i> <span
                                    class="nav-label">Website</span><span class="fa arrow"></span></a>
                            <ul
                                class="nav nav-second-level collapse @yield('page_active_c1') @yield('slider') @yield('announcements_active') @yield('languages_active') @yield('promotional_banner')">
                                <li class="@yield('pages_active')"><a href="{{ route('admins.pages') }}">Pages</a>
                                </li>
                                <li class="@yield('slider')">
                                    <a href="{{ route('admins.slider') }}"><span class="nav-label">Sliders</span>
                                    </a>
                                </li>
                                <li class="@yield('promotional_banner')">
                                    <a href="{{ route('admins.promotional_banner') }}"><span
                                            class="nav-label">Promotional Banners</span>
                                    </a>
                                </li>
                                <li class="@yield('popup_active')">
                                    <a href="{{ route('admins.popup') }}"><span class="nav-label">Popup</span>
                                    </a>
                                </li>
                                <li class="@yield('announcements_active')">
                                    <a href="{{ route('admins.announcements') }}"><span
                                            class="nav-label">Announcements</span> </a>
                                </li>
                                <li class="{{ request()->routeIs('admins.locations.*') ? 'active' : '' }}">
                                    <a href="{{ route('admins.locations.index') }}"> <span
                                            class="nav-label">Locations</span></a>
                                </li>
                                <li class="@yield('order_notifications')">
                                    <a href="{{ route('admins.order_notifications.index') }}"> <span
                                            class="nav-label">Order Notifications</span></a>
                                </li>
                                <li class="@yield('box_cal_active_c1')">
                                    <a href="{{ route('admins.box.calculator') }}"> <span class="nav-label">Box
                                            Calculator</span></a>
                                </li>
                                <li class="@yield('languages_active')"><a
                                        href="{{ route('admins.languages') }}">Languages</a>
                                </li>
                                <!--<li class="@yield('page_1_active')"><a href="{{ route('admins.page_form') }}?section=1">Add Section</a></li>-->
                                <!--<li class="@yield('page_2_active')"><a href="{{ route('admins.msections') }}">Menu section</a></li>-->
                            </ul>
                        </li>

                        <li class=" @yield('offer_active') @yield('coupon_active') @yield('promotion_active')">
                            <a href="#"><i class="fa-solid fa-globe"></i> <span class="nav-label">Discount
                                    Center</span><span class="fa arrow"></span></a>
                            <ul
                                class="nav nav-second-level collapse @yield('page_active_c1') @yield('slider') @yield('announcements_active') @yield('coupon_active')">

                                <li class="@yield('coupon_active')" style="display:;">
                                    <a href="{{ route('admins.coupon') }}"> <span
                                            class="nav-label">Coupons</span></a>
                                </li>
                                <li class="@yield('promotion_active')" style="display:;">
                                    <a href="{{ route('admins.promotions.index') }}"> <span
                                            class="nav-label">Promotions</span></a>
                                </li>
                                <li class="@yield('offer_active')" style="display:;">
                                    <a href="{{ route('admins.offers.index') }}"> <span class="nav-label">Promotional
                                            Offers</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="@yield('review') @yield('blogs') @yield('faq') @yield('review_child_2_active') @yield('home_videos')">
                            <a href="#"><i class="fa-solid fa-truck"></i> <span
                                    class="nav-label">Content</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('product_active_c1')">
                                <li class="@yield('review_child_1_active')"><a href="{{ route('admins.review') }}">Reviews</a>
                                </li>
                                <li class="@yield('review_child_2_active')"><a
                                        href="{{ route('admins.approve_review') }}">Approve
                                        Reviews</a></li>
                                <li class="@yield('faq')">
                                    <a href="{{ route('admins.faq') }}"><span class="nav-label">Faq's</span> </a>
                                </li>
                                <li class="@yield('blogs')" style="display:;">
                                    <a href="{{ route('admins.blogs.index') }}"> <span class="nav-label">Blogs</span>
                                    </a>
                                </li>
                                <li class="@yield('home_videos')" style="display:;">
                                    <a href="{{ route('admins.home-videos.index') }}"> <span
                                            class="nav-label">Videos</span></a>
                                </li>
                                {{-- <li class="@yield('blog_category_active')" style="display:;">
                                    <a href="{{ route('admins.blog_category') }}"> <span
                                            class="nav-label">Blog_category</span> </a>
                                </li> --}}
                            </ul>
                        </li>

                        <li class="@yield('users') @yield('roles') @yield('user_log')">
                            <a href="#"><i class="fa-solid fa-user-gear"></i> <span class="nav-label">Users
                                    Management</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('users_active_c1')">
                                <li class="@yield('users')"><a href="{{ route('admins.users.index') }}">Users</a>
                                </li>
                                <li class="@yield('roles')"><a href="{{ route('admins.roles.index') }}">Roles</a>
                                </li>
                                <li class="@yield('user_log')"><a href="{{ route('admins.user.logreport') }}">User
                                        Log</a>
                                </li>

                            </ul>
                        </li>
                        <li class="@yield('countries') @yield('cities') ">
                            <a href="#"><i class="fa-solid fa-truck"></i> <span
                                    class="nav-label">Shipping</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('shipping_active_c1') ">
                                <li class="@yield('countries')"><a
                                        href="{{ route('admins.countries.index') }}">Countries</a>
                                </li>
                                <li class="@yield('cities')"><a
                                        href="{{ route('admins.cities.index') }}">Cities</a>
                                </li>
                            </ul>
                        </li>


                        <!--<li class="@yield('home_cats_active')"> -->
                        <!--    <a href="{{ route('admins.home_cats') }}"><i class="fa fa-list-alt"></i> <span-->
                        <!--            class="nav-label">Home Categories</span> </a>-->
                        <!--</li>-->
                        {{-- <li class="@yield('media')">
                            <a href="{{route('admins.media')}}"><i class="fa fa-image"></i> <span
                                    class="nav-label">Media</span> </a>
                        </li> --}}
                        <!-- <li class="@yield('learn_setting')"> -->
                        <!--    <a href="{{ route('admins.learn_setting') }}"><i class="fa fa-cog" ></i> <span-->
                        <!--            class="nav-label">Learn Settings</span> </a>-->
                        <!--</li>-->
                        <li
                            class="@yield('Customers') @yield('Franchise') @yield('Event Organizer') @yield('Retailers') @yield('inquiry') @yield('Resellers') @yield('Influencers')">
                            <a href="#"><i class="fa-solid fa-inbox"></i> <span
                                    class="nav-label">Inbox</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('shipping_active_c1')">
                                <li class="@yield('Customers')" style="display:;">
                                    <a href="{{ route('admins.contact') }}?type=Customers"> <span
                                            class="nav-label">Customers</span> </a>
                                </li>
                                <li class="@yield('Franchise')" style="display:;">
                                    <a href="{{ route('admins.contact') }}?type=Franchise"> <span
                                            class="nav-label">Franchise</span> </a>
                                </li>
                                <li class="@yield('Retailers')" style="display:;">
                                    <a href="{{ route('admins.contact') }}?type=Retailers"> <span
                                            class="nav-label">Retailers</span> </a>
                                </li>
                                <li class="@yield('Reseller')" style="display:;">
                                    <a href="{{ route('admins.contact') }}?type=Resellers"> <span
                                            class="nav-label">Resellers</span> </a>
                                </li>
                                <li class="@yield('Influencers')" style="display:;">
                                    <a href="{{ route('admins.contact') }}?type=Influencers"> <span
                                            class="nav-label">Influencers</span> </a>
                                </li>
                                <li class="@yield('Event Organizer')" style="display:;">
                                    <a href="{{ route('admins.contact') }}?type=Event Organizer"> <span
                                            class="nav-label">Event Organizer</span> </a>
                                </li>
                                <li class="@yield('corporate-events')" style="display:;">
                                    <a href="{{ route('admins.contact') }}?type=corporate-events"> <span
                                            class="nav-label">Corporate Events</span> </a>
                                </li>
                                <li class="@yield('inquiry')" style="display:;">
                                    <a href="{{ route('admins.contact') }}?type=inquiry"> <span
                                            class="nav-label">Inquiry</span> </a>
                                </li>
                            </ul>
                        </li>

                        <li class="@yield('setting') @yield('currency_active') @yield('vat_active')">
                            <a href="#"><i class="fa-solid fa-gear"></i> <span class="nav-label">System
                                    Settings</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse @yield('shipping_active_c1')">

                                <li class="@yield('currency_active')">
                                    <a href="{{ route('admins.currency') }}"> <span class="nav-label">Currency</span>
                                    </a>
                                </li>
                                <li class="@yield('vat_active')">
                                    <a href="{{ route('admins.vat') }}"> <span class="nav-label">Vat</span> </a>
                                </li>
                                <li class="@yield('setting')">
                                    <a href="{{ route('admins.setting') }}"> <span class="nav-label">General
                                            Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- Dashboard --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('dashborad', 'read'))
                            <li
                                class="@yield('dashboard_active') @yield('sales_active') @yield('inventory_active') @yield('visits_active')">
                                <a href="#"> <i class="fa-solid fa-gauge"></i> <span
                                        class="nav-label">Dashboard</span><span class="fa arrow"></span></a>
                                <ul
                                    class="nav nav-second-level collapse @yield('dashboard_active') @yield('sales_active') @yield('inventory_active') @yield('visits_active')">
                                    <li class="@yield('dashboard_active')">
                                        <a href="{{ route('admins.dashboard') }}"> <span
                                                class="nav-label">General</span></a>
                                    </li>
                                    <li class="@yield('sales_active')">
                                        <a href="{{ route('admins.sales') }}"> <span
                                                class="nav-label">Sales</span></a>
                                    </li>
                                    <li class="@yield('inventory_active')">
                                        <a href="{{ route('admins.inventory') }}"> <span
                                                class="nav-label">Inventory</span></a>
                                    </li>
                                    <li class="@yield('visits_active')">
                                        <a href="{{ route('admins.visits') }}"> <span
                                                class="nav-label">Visits</span></a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{-- Order Management --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('orders', 'read'))
                            <li class="@yield('order')" style="display:;">
                                <a href="#"><i class="fa-solid fa-box"></i> <span class="nav-label">Order
                                        Management</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('orderc1')">
                                    <li class="@yield('order1')"><a href="{{ route('admins.orders') }}">New
                                            Orders</a></li>
                                    <li class="@yield('dorder')"><a
                                            href="{{ route('admins.dispatched_orders') }}">Dispatched
                                            Orders</a></li>
                                    <li class="@yield('deorder')"><a
                                            href="{{ route('admins.deliverd_orders') }}">Delivered
                                            Orders</a></li>
                                    <li class="@yield('corder')"><a
                                            href="{{ route('admins.complete_orders') }}">Confirmed
                                            Orders</a></li>
                                    <li class="@yield('caorder')"><a
                                            href="{{ route('admins.canceled_orders') }}">Canceled
                                            Orders</a></li>
                                </ul>
                            </li>
                        @endif

                        {{-- Product Management --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('products', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('category', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('brands', 'read'))
                            <li
                                class="@yield('product_active') @yield('category_child_1_active') @yield('category_child_2_active') @yield('category_child_3_active')">
                                <a href="#"><i class="fa-solid fa-boxes-stacked"></i> <span
                                        class="nav-label">Product
                                        Management</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('product_active_c1')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('products', 'read'))
                                        <li class="@yield('product_child_2_active')"><a
                                                href="{{ route('admins.products') }}">Products</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('category', 'read'))
                                        <li class="@yield('category_child_1_active')"><a
                                                href="{{ route('admins.category') }}">Category</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('subcategory', 'read'))
                                        <li class="@yield('category_child_2_active')"><a
                                                href="{{ route('admins.subcategory') }}">SubCategory</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('brands', 'read'))
                                        <li style="display:;" class="@yield('category_child_3_active')"><a
                                                href="{{ route('admins.brand') }}">Brand</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('products', 'read'))
                                        <li class="@yield('product_child_2_active')"><a
                                                href="{{ route('admins.products.logreport') }}">Product Log Report</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Product Attributes --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('size', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('colors', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('product_type', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('ingredient', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('allergen', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('flavour', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('package_type', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('basket_type', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('theme', 'read'))
                            <li class="@yield('product_attribute_active')">
                                <a href="#"><i class="fa-solid fa-tags"></i> <span class="nav-label">Products
                                        Attributes</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('product_active_c1')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('size', 'read'))
                                        <li class="@yield('product_attribute_child_1_active')"><a href="{{ route('admins.size') }}">Size</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('colors', 'read'))
                                        <li class="@yield('product_attribute_child_2_active')"><a
                                                href="{{ route('admins.colors') }}">Color</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('product_type', 'read'))
                                        <li class="@yield('product_attribute_child_2_active')"><a
                                                href="{{ route('admins.product_type') }}">Product Types</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('ingredient', 'read'))
                                        <li class="@yield('product_attribute_child_2_active')"><a
                                                href="{{ route('admins.ingredient') }}">Ingredient</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('allergen', 'read'))
                                        <li class="@yield('product_attribute_child_2_active')"><a
                                                href="{{ route('admins.allergen') }}">Allergen</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('flavour', 'read'))
                                        <li class="@yield('product_attribute_child_2_active')"><a
                                                href="{{ route('admins.flavour') }}">Flavours</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('package_type', 'read'))
                                        <li class="@yield('product_attribute_child_2_active')"><a
                                                href="{{ route('admins.package_type') }}">Package Types</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('basket_type', 'read'))
                                        <li class="@yield('product_attribute_child_2_active')"><a
                                                href="{{ route('admins.basket_type') }}">Basket Types</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('theme', 'read'))
                                        <li class="@yield('product_attribute_child_2_active')"><a
                                                href="{{ route('admins.theme') }}">Themes</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Box Management --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('box_management', 'read'))
                            <li class="@yield('box_active_c1')">
                                <a href="#"><i class="fa-solid fa-box-open"></i> <span class="nav-label">Box
                                        Management</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('box_active_c1')">
                                    <li class="@yield('box_active_c1')"><a
                                            href="{{ route('admins.box_customize') }}">Customize
                                            Boxes</a></li>
                                    <li class="@yield('box_active_c1')"><a href="{{ route('admins.box_size') }}">Box
                                            Sizes</a></li>
                                </ul>
                            </li>
                        @endif

                        {{-- Customers --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('customers', 'read'))
                            <li class="@yield('campaign-emails') @yield('account_active') @yield('news_letter_active')">
                                <a href="#"><i class="fa-solid fa-user-group"></i> <span
                                        class="nav-label">Customers</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('box_active_c1')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('campaign_emails', 'read'))
                                        <li class="@yield('campaign-emails')"><a
                                                href="{{ URL::to('admin/campaign-emails') }}">Pre-Launch Emails</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('newsletters', 'read'))
                                        <li class="@yield('news_letter_active')" style="display:;"><a
                                                href="{{ route('admins.news_letters') }}">News Letters</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('accounts', 'read'))
                                        <li class="@yield('account_active')" style="display:;"><a
                                                href="{{ route('admins.accounts') }}">Accounts</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Website --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('pages', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('sliders', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('announcements', 'read'))
                            <li class="@yield('page_active')">
                                <a href="#"><i class="fa-solid fa-globe"></i> <span
                                        class="nav-label">Website</span><span class="fa arrow"></span></a>
                                <ul
                                    class="nav nav-second-level collapse @yield('page_active_c1') @yield('slider') @yield('announcements_active')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('pages', 'read'))
                                        <li class="@yield('page_2_active')"><a
                                                href="{{ route('admins.pages') }}">Pages</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('sliders', 'read'))
                                        <li class="@yield('slider')"><a
                                                href="{{ route('admins.slider') }}">Sliders</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('announcements', 'read'))
                                        <li class="@yield('announcements_active')"><a
                                                href="{{ route('admins.announcements') }}">Announcements</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Content --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('reviews', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('faqs', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('blogs', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('blog_category', 'read'))
                            <li class="@yield('review') @yield('blog_active') @yield('home_videos')">
                                <a href="#"><i class="fa-solid fa-truck"></i> <span
                                        class="nav-label">Content</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('product_active_c1')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('reviews', 'read'))
                                        <li class="@yield('review_child_1_active')"><a
                                                href="{{ route('admins.review') }}">Reviews</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('reviews', 'read'))
                                        <li class="@yield('review_child_2_active')"><a
                                                href="{{ route('admins.approve_review') }}">Approve Reviews</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('faqs', 'read'))
                                        <li class="@yield('faq')"><a
                                                href="{{ route('admins.faq') }}">Faq's</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('blogs', 'read'))
                                        <li class="@yield('blog_active')" style="display:;"><a
                                                href="{{ route('admins.blogs.index') }}">Blog</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('blogs', 'read'))
                                        <li class="@yield('home_videos')" style="display:;"><a
                                                href="{{ route('admins.home-videos.index') }}">Videos</a></li>
                                    @endif
                                    {{-- @if (auth()->guard('admin')->user()->hasPermissionForAction('blog_category', 'read'))
                                        <li class="@yield('blog_category_active')" style="display:;"><a
                                                href="{{ route('admins.blog_category') }}">Blog Category</a></li>
                                    @endif --}}
                                </ul>
                            </li>
                        @endif

                        {{-- Users Management --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('user_management', 'read'))
                            <li class="@yield('users')">
                                <a href="#"><i class="fa-solid fa-user-gear"></i> <span class="nav-label">Users
                                        Management</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('users_active_c1')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('user_management', 'read'))
                                        <li class="@yield('users')"><a
                                                href="{{ route('admins.users.index') }}">Users</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('user_management', 'read'))
                                        <li class="@yield('users')"><a
                                                href="{{ route('admins.roles.index') }}">Roles</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('user_management', 'read'))
                                        <li class="@yield('user_log')"><a
                                                href="{{ route('admins.user.logreport') }}">User Log</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('admin', 'read'))
                                        <li class="@yield('admin')"><a
                                                href="{{ route('admins.admin') }}">Admin</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Shipping --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('shipping', 'read'))
                            <li class="@yield('shipping_active_c1')">
                                <a href="#"><i class="fa-solid fa-truck"></i> <span
                                        class="nav-label">Shipping</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('shipping_active_c1')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('countries', 'read'))
                                        <li class="@yield('countries')"><a
                                                href="{{ route('admins.countries.index') }}">Countries</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('cities', 'read'))
                                        <li class="@yield('cities')"><a
                                                href="{{ route('admins.cities.index') }}">Cities</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Inbox --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('messages', 'read'))
                            <li
                                class="@yield('Customers') @yield('Franchise') @yield('Event Organizer') @yield('Retailers') @yield('inquiry')">
                                <a href="#"><i class="fa-solid fa-inbox"></i> <span
                                        class="nav-label">Inbox</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('shipping_active_c1')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('messages', 'read'))
                                        <li class="@yield('Customers')" style="display:;"><a
                                                href="{{ route('admins.contact') }}?type=Customers">Customers</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('messages', 'read'))
                                        <li class="@yield('Franchise')" style="display:;"><a
                                                href="{{ route('admins.contact') }}?type=Franchise">Franchise</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('messages', 'read'))
                                        <li class="@yield('Retailers')" style="display:;"><a
                                                href="{{ route('admins.contact') }}?type=Retailers">Retailers</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('messages', 'read'))
                                        <li class="@yield('Event Organizer')" style="display:;"><a
                                                href="{{ route('admins.contact') }}?type=Event Organizer">Event
                                                Organizer</a></li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('messages', 'read'))
                                        <li class="@yield('inquiry')" style="display:;"><a
                                                href="{{ route('admins.contact') }}?type=inquiry">Inquiry</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- System Settings --}}
                        @if (auth()->guard('admin')->user()->hasPermissionForAction('settings', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('currency', 'read') ||
                                auth()->guard('admin')->user()->hasPermissionForAction('vat', 'read'))
                            <li class="@yield('setting') @yield('currency_active') @yield('vat_active')">
                                <a href="#"><i class="fa-solid fa-gear"></i> <span class="nav-label">System
                                        Settings</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse @yield('shipping_active_c1')">
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('currency', 'read'))
                                        <li class="@yield('currency_active')"><a
                                                href="{{ route('admins.currency') }}">Currency</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('vat', 'read'))
                                        <li class="@yield('vat_active')"><a href="{{ route('admins.vat') }}">Vat</a>
                                        </li>
                                    @endif
                                    @if (auth()->guard('admin')->user()->hasPermissionForAction('settings', 'read'))
                                        <li class="@yield('setting')"><a
                                                href="{{ route('admins.setting') }}">General Settings</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                    {{-- @else
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('dashborad', 'read'))
                    <li class="@yield('dashboard_active')">
                        <a href="{{ route('admins.dashboard') }}"><i class="fa fa-th-large"></i> <span
                                class="nav-label">Dashboard</span></a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('category', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('brands', 'read'))
                    <li class="@yield('category_active')">

                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Category</span><span
                                class="fa arrow"></span></a>


                        <ul
                            class="nav nav-second-level collapse @yield('category_active_c1') @yield('category_active_c2') @yield('category_active_c3')">
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('category', 'read'))
                            <li class="@yield('category_child_1_active')"><a
                                    href="{{ route('admins.category') }}">Category</a></li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('brands', 'read'))
                            <li style="display:;" class="@yield('category_child_3_active')"><a
                                    href="{{ route('admins.brand') }}">Brand</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('products', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('products', 'create'))
                    <li class="@yield('product_active')">
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Products</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse @yield('product_active_c1')">
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('products', 'create'))
                            <li class="@yield('product_child_1_active')"><a
                                    href="{{ route('admins.product_form') }}">Add
                                    Product</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('products', 'read'))
                            <li class="@yield('product_child_2_active')"><a href="{{ route('admins.products') }}">All
                                    Product</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('size', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('colors', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('product_type', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('ingredient', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('allergen', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('flavour', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('package_type', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('basket_type', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('theme', 'read'))
                    <li class="@yield('product_attribute_active')">
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Products
                                Attributes</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse @yield('product_active_c1')">
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('size', 'read'))
                            <li class="@yield('product_attribute_child_1_active')"><a
                                    href="{{ route('admins.size') }}">Size</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('colors', 'read'))
                            <li class="@yield('product_attribute_child_2_active')"><a
                                    href="{{ route('admins.colors') }}">Color</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('product_type', 'read'))
                            <li class="@yield('product_attribute_child_2_active')"><a
                                    href="{{ route('admins.product_type') }}">Product
                                    Types</a></li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('ingredient', 'read'))
                            <li class="@yield('product_attribute_child_2_active')"><a
                                    href="{{ route('admins.ingredient') }}">
                                    Ingredient</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('allergen', 'read'))
                            <li class="@yield('product_attribute_child_2_active')"><a
                                    href="{{ route('admins.allergen') }}">
                                    Allergen</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('flavour', 'read'))
                            <li class="@yield('product_attribute_child_2_active')"><a
                                    href="{{ route('admins.flavour') }}">Flavours</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('package_type', 'read'))
                            <li class="@yield('product_attribute_child_2_active')"><a
                                    href="{{ route('admins.package_type') }}">Package
                                    Types</a></li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('basket_type', 'read'))
                            <li class="@yield('product_attribute_child_2_active')"><a
                                    href="{{ route('admins.basket_type') }}">Basket
                                    Types</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('theme', 'read'))
                            <li class="@yield('product_attribute_child_2_active')"><a
                                    href="{{ route('admins.theme') }}">Themes</a></li>
                            @endif
                            <li class="@yield('product_attribute_child_3_active')"><a
                                    href="{{route('admins.shap')}}">Shape</a></li>

                        </ul>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('pages', 'read') || auth()->guard('admin')->user()->hasPermissionForAction('pages', 'create'))
                    <li class="@yield('page_active')">
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Pages</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse @yield('page_active_c1')">
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('pages', 'create'))
                            <li class="@yield('page_1_active')"><a href="{{ route('admins.page_form') }}">Add
                                    Page</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('pages', 'read'))
                            <li class="@yield('page_2_active')"><a href="{{ route('admins.pages') }}">All
                                    Page</a>
                            </li>
                            @endif
                            <!--<li class="@yield('page_1_active')"><a href="{{ route('admins.page_form') }}?section=1">Add Section</a></li>-->
                            <!--<li class="@yield('page_2_active')"><a href="{{ route('admins.msections') }}">Menu section</a></li>-->

                        </ul>
                    </li>
                    @endif
                    <li class="@yield('coupon_active')" style="display:none;">
                        <a href="{{ route('admins.coupon') }}"><i class="fa fa-flask"></i> <span
                                class="nav-label">Coupons</span></a>
                    </li>
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('orders', 'read'))
                    <li class="@yield('order')" style="display:;">
                        <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">Orders</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse @yield('orderc1')">
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('orders', 'read'))
                            <li class="@yield('order1')"><a href="{{ route('admins.orders') }}">New
                                    Orders</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('orders', 'read'))
                            <li class="@yield('dorder')"><a href="{{ route('admins.dispatched_orders') }}">Dispatched
                                    Orders</a></li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('orders', 'read'))
                            <li class="@yield('deorder')"><a href="{{ route('admins.deliverd_orders') }}">Delivered
                                    Orders</a></li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('orders', 'read'))
                            <li class="@yield('corder')"><a href="{{ route('admins.complete_orders') }}">Complete
                                    Orders</a></li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('orders', 'read'))
                            <li class="@yield('caorder')"><a href="{{ route('admins.canceled_orders') }}">Canceled
                                    Orders</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('reviews', 'read'))
                    <li class="@yield('review')">
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">All
                                Reviews</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse @yield('product_active_c1')">
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('reviews', 'read'))
                            <li class="@yield('review_child_1_active')"><a
                                    href="{{ route('admins.review') }}">Reviews</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('reviews', 'read'))
                            <li class="@yield('review_child_2_active')"><a
                                    href="{{ route('admins.approve_review') }}">Approve
                                    Reviews</a></li>
                            @endif

                        </ul>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('user_management', 'read'))
                    <li class="@yield('users')">
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Users
                                Management</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse @yield('users_active_c1')">
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('user_management', 'read'))
                            <li class="@yield('users')"><a href="{{ route('admins.users.index') }}">Users</a>
                            </li>
                            @endif
                            @if (auth()->guard('admin')->user()->hasPermissionForAction('user_management', 'read'))
                            <li class="@yield('users')"><a href="{{ route('admins.roles.index') }}">Roles</a>
                            </li>
                            @endif
                            <li class="@yield('users')"><a
                                    href="{{ route('admins.permissions.index') }}">Permissions</a></li>

                        </ul>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('sliders', 'read'))
                    <li class="@yield('slider')">
                        <a href="{{ route('admins.slider') }}"><i class="fa fa-pie-chart"></i> <span
                                class="nav-label">Home Slider</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('faqs', 'read'))
                    <li class="@yield('faq')">
                        <a href="{{ route('admins.faq') }}"><i class="fa fa-question"></i> <span
                                class="nav-label">Faq's</span> </a>
                    </li>
                    @endif

                    <!--<li class="@yield('home_cats_active')"> -->
                    <!--    <a href="{{ route('admins.home_cats') }}"><i class="fa fa-list-alt"></i> <span-->
                    <!--            class="nav-label">Home Categories</span> </a>-->
                    <!--</li>-->
                    <li class="@yield('media')">
                        <a href="{{route('admins.media')}}"><i class="fa fa-image"></i> <span
                                class="nav-label">Media</span> </a>
                    </li>
                    <!-- <li class="@yield('learn_setting')"> -->
                    <!--    <a href="{{ route('admins.learn_setting') }}"><i class="fa fa-cog" ></i> <span-->
                    <!--            class="nav-label">Learn Settings</span> </a>-->
                    <!--</li>-->
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('newsletters', 'read'))
                    <li class="@yield('news_letter_active')" style="display:;">
                        <a href="{{ route('admins.news_letters') }}"><i class="fa fa-users"></i> <span
                                class="nav-label">News Letters</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('blog_category', 'read'))
                    <li class="@yield('blog_category_active')" style="display:;">
                        <a href="{{ route('admins.blog_category') }}"><i class="fa fa-book"></i> <span
                                class="nav-label">Blog_category</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('blogs', 'read'))
                    <li class="@yield('blog_active')" style="display:;">
                        <a href="{{ route('admins.blog') }}"><i class="fa fa-book"></i> <span
                                class="nav-label">Blog</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('messages', 'read'))
                    <li class="@yield('message')" style="display:;">
                        <a href="{{ route('admins.contact') }}"><i class="fa fa-comment"></i> <span
                                class="nav-label">Messages</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('currency', 'read'))
                    <li class="@yield('currency_active')">
                        <a href="{{ route('admins.currency') }}"><i class="fa fa-dollar"></i> <span
                                class="nav-label">Currency</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('currency', 'read'))
                    <li class="@yield('vat_active')">
                        <a href="{{ route('admins.vat') }}"><i class="fa fa-money"></i> <span
                                class="nav-label">Vat</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('announcement', 'read'))
                    <li class="@yield('announcements_active')">
                        <a href="{{ route('admins.announcements') }}"><i class="fa fa-bell"></i> <span
                                class="nav-label">Announcements</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('currency', 'read'))
                    <li class="@yield('admin')">
                        <a href="{{ route('admins.admin') }}"><i class="fa fa-user"></i> <span
                                class="nav-label">Admin</span> </a>
                    </li>
                    @endif
                    @if (auth()->guard('admin')->user()->hasPermissionForAction('settings', 'read'))
                    <li class="@yield('setting')">
                        <a href="{{ route('admins.setting') }}"><i class="fa fa-cog"></i> <span
                                class="nav-label">Settings</span> </a>
                    </li>
                    @endif
                    @endif --}}

                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation"
                    style="margin-bottom: 0;    height: 68px;border-left: 1px solid #E7EAEC;">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn  "
                            style="color: #e92827;background:white;font-size:24px;" href="#"><i
                                class="fa fa-bars"></i>
                        </a>
                        <form style="display:none;" role="search" class="navbar-form-custom"
                            action="http://webapplayers.com/inspinia_admin-v2.7/search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control"
                                    name="top-search" id="top-search">
                            </div>
                        </form>

                    </div>

                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown" style="float: right; margin-top: 8px;display:block;">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"
                                style="padding: 0px; display: flex; align-items: center; gap: 8px;">
                                <!-- Profile Image -->
                                <img src="{{ asset('user.webp') }}" alt="Profile"
                                    style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;" />



                            </a>

                            <!-- Dropdown Menu -->
                            <ul class="dropdown-menu dropdown-menu-right"
                                style="right: 0; left: auto; min-width: 150px;">
                                <li> <!-- User Info -->
                                    <span class="clear">
                                        <span class="block m-t-xs"
                                            style="font-family: Inter; font-weight: 500; font-size: 14px; line-height: 20px; color: black;">
                                            <strong
                                                class="font-bold">{{ auth()->guard('admin')->user()->name }}</strong>
                                        </span>
                                        <span class="text-muted text-xs block"
                                            style="font-family: Inter; font-weight: 400; font-size: 12px; line-height: 16px; color:#525866; margin-top: 4px;">
                                            {{ auth()->guard('admin')->user()->roles->pluck('name')->first() ?? 'User' }}
                                        </span>
                                    </span>
                                </li>
                                <li><a href="{{ url('/admin/logout') }}"><i class="fa fa-sign-out"></i> Log out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>



                </nav>
            </div>
            @yield('content')

            {{-- <div class="footer">
                <div class="pull-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company &copy; 2014-2017
                </div>
            </div> --}}
        </div>
        <div id="right-sidebar">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">

                    <li class="active"><a data-toggle="tab" href="#tab-1">
                            Notes
                        </a></li>
                    <li><a data-toggle="tab" href="#tab-2">
                            Projects
                        </a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">
                            <i class="fa fa-gear"></i>
                        </a></li>
                </ul>

                <div class="tab-content">


                    <div id="tab-1" class="tab-pane active">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
                            <small><i class="fa fa-tim"></i> You have 10 new message.</small>
                        </div>

                        <div>

                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar"
                                            src="{{ asset('backend_assets/img/a1.jpg') }}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">

                                        There are many variations of passages of Lorem Ipsum available.
                                        <br>
                                        <small class="text-muted">Today 4:21 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar"
                                            src="{{ asset('backend_assets/img/a2.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        The point of using Lorem Ipsum is that it has a more-or-less normal.
                                        <br>
                                        <small class="text-muted">Yesterday 2:45 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar"
                                            src="{{ asset('backend_assets/img/a3.jpg') }}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        Mevolved over the years, sometimes by accident, sometimes on purpose (injected
                                        humour and the like).
                                        <br>
                                        <small class="text-muted">Yesterday 1:10 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar"
                                            src="{{ asset('backend_assets/img/a4.jpg') }}">
                                    </div>

                                    <div class="media-body">
                                        Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
                                        <br>
                                        <small class="text-muted">Monday 8:37 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar"
                                            src="{{ asset('backend_assets/img/a8.jpg') }}">
                                    </div>
                                    <div class="media-body">

                                        All the Lorem Ipsum generators on the Internet tend to repeat.
                                        <br>
                                        <small class="text-muted">Today 4:21 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar"
                                            src="{{ asset('backend_assets/img/a7.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..",
                                        comes from a line in section 1.10.32.
                                        <br>
                                        <small class="text-muted">Yesterday 2:45 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar"
                                            src="{{ asset('backend_assets/img/a3.jpg') }}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
                                        <br>
                                        <small class="text-muted">Yesterday 1:10 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar"
                                            src="{{ asset('backend_assets/img/a4.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        Uncover many web sites still in their infancy. Various versions have.
                                        <br>
                                        <small class="text-muted">Monday 8:37 pm</small>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div id="tab-2" class="tab-pane">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <ul class="sidebar-list">
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Business valuation</h4>
                                    It is a long established fact that a reader will be distracted.

                                    <div class="small">Completion with: 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Contract with Company </h4>
                                    Many desktop publishing packages and web page editors.

                                    <div class="small">Completion with: 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Meeting</h4>
                                    By the readable content of a page when looking at its layout.

                                    <div class="small">Completion with: 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary pull-right">NEW</span>
                                    <h4>The generated</h4>
                                    <!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
                                    There are many variations of passages of Lorem Ipsum available.
                                    <div class="small">Completion with: 22%</div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Business valuation</h4>
                                    It is a long established fact that a reader will be distracted.

                                    <div class="small">Completion with: 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Contract with Company </h4>
                                    Many desktop publishing packages and web page editors.

                                    <div class="small">Completion with: 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Meeting</h4>
                                    By the readable content of a page when looking at its layout.

                                    <div class="small">Completion with: 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary pull-right">NEW</span>
                                    <h4>The generated</h4>
                                    <!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
                                    There are many variations of passages of Lorem Ipsum available.
                                    <div class="small">Completion with: 22%</div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>

                        </ul>

                    </div>

                    <div id="tab-3" class="tab-pane">

                        <div class="sidebar-title">
                            <h3><i class="fa fa-gears"></i> Settings</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <div class="setings-item">
                            <span>
                                Show notifications
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example">
                                    <label class="onoffswitch-label" for="example">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Disable Chat
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox"
                                        id="example2">
                                    <label class="onoffswitch-label" for="example2">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Enable history
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example3">
                                    <label class="onoffswitch-label" for="example3">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Show charts
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example4">
                                    <label class="onoffswitch-label" for="example4">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Offline users
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example5">
                                    <label class="onoffswitch-label" for="example5">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Global search
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example6">
                                    <label class="onoffswitch-label" for="example6">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Update everyday
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example7">
                                    <label class="onoffswitch-label" for="example7">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-content">
                            <h4>Settings</h4>
                            <div class="small">
                                I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry.
                                And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                                since the 1500s.
                                Over the years, sometimes by accident, sometimes on purpose (injected humour and the
                                like).
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Mainly scripts -->
    <script src="{{ asset('backend_assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('backend_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend_assets/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('backend_assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('backend_assets/js/plugins/dataTables/datatables.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('backend_assets/js/inspinia.js') }}"></script>
    <script src="{{ asset('backend_assets/js/plugins/pace/pace.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('backend_assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- SUMMERNOTE -->
    <script src="{{ asset('backend_assets/js/plugins/summernote/summernote.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('backend_assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend_assets/ckeditor/samples/js/sample.js') }}"></script>



    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $(document).on('change', 'input[name="product_status"]', function() {
                let status = $(this).is(':checked') ? 1 : 0;
                let product_id = $(this).data('id');
                updateStatus(status, product_id);
            });
        });
        $(document).ready(function() {
            $(document).on('change', 'input[name="is_trending"]', function() {
                let status = $(this).is(':checked') ? 1 : 0;
                let product_id = $(this).data('id');
                updateTrendingStatus(status, product_id);
            });
        });
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

            });

        });
    </script>

    <script>
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
            $(document).on('click', '.delete_record', function() {
                $(".select2").select2(); // If needed; remove if unrelated
                let href = $(this).data('href');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        window.location.href = href;
                    }
                });
            });

            // $('.delete_record').click(function () {
            //     $(".select2").select2();
            //     swal({
            //         title: "Are you sure?",
            //         text: "Once deleted, you will not be able to recover",
            //         icon: "warning",
            //         buttons: true,
            //         dangerMode: true,
            //     })
            //         .then((willDelete) => {
            //             if (willDelete) {
            //                 let href = $(this).data('href');
            //                 window.location.href = href;
            //             }
            //         });

            // });



            let msg_type = "";
            let msg = "";
            @if (Session::has('msg'))
                msg_type = "{{ Session::get('msg_type') }}";
                msg = "{{ Session::get('msg') }}";
            @endif

            if (msg != "") {
                // alert(msg);
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

                    case "errors": // Handle both 'danger' and 'error'
                        try {
                            // If msg is a JSON-encoded string, parse it
                            if (typeof msg === 'string') {
                                msg = JSON.parse(msg.replace(/&quot;/g, '"'));
                            }

                            if (typeof msg === 'object') {
                                let errorList = '<ul style="text-align: left;">';
                                Object.keys(msg).forEach(key => {
                                    if (Array.isArray(msg[key])) {
                                        msg[key].forEach(errMsg => {
                                            errorList += `<li>${errMsg}</li>`;
                                        });
                                    } else {
                                        errorList += `<li>${msg[key]}</li>`;
                                    }
                                });
                                errorList += '</ul>';
                                toastr.error(errorList);
                            } else {
                                toastr.error(msg);
                            }
                        } catch (e) {
                            // Fallback if JSON parsing fails
                            toastr.error("An error occurred while displaying messages.");
                            console.error("Toastr Error Parsing:", e);
                        }
                        break;

                    case "warning":
                        toastr.warning(msg)
                        break;
                }
            }





        });
        $(document).ready(function() {
            $(document).click(function(event) {
                // Check if the clicked element is NOT inside .navbar-default or .navbar-static-side
                if ($(window).width() < 768) {
                    if (!$(event.target).closest('.navbar-default, .navbar-static-side,.navbar-minimalize ')
                        .length) {
                        // Remove the class only if body contains 'mini-navbar'
                        if ($('body').hasClass('mini-navbar')) {
                            $('body').removeClass('mini-navbar');
                        }
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript',
                        'subscript', 'clear'
                    ]],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                    ['misc', ['undo', 'redo']]
                ],
            });

            // $('.input-group.date').datepicker({
            //     todayBtn: "linked",
            //     keyboardNavigation: false,
            //     forceParse: false,
            //     calendarWeeks: true,
            //     autoclose: true
            // });

        });
    </script>
    @stack('scripts')
</body>

</html>
