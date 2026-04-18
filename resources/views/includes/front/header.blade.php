<!-- Topbar Start -->
<?php

use App\Models\Admins\Product;
use App\Models\Flavour;
use App\Models\Theme;
use App\Models\TopAnnouncementBar;

$trending = Product::where('is_trending', 1)->limit(7)->get();
$setting = DB::table('setting')->where('id', '=', '1')->first();
$cate_des = DB::table('categories')->where('menu', 1)->limit(3)->orderBy('id', 'desc')->get();
$pages_des = DB::table('pages')
    ->where('is_show_in_header', 1)
    ->where(function ($q) {
        $q->whereNull('page_type')
            ->orWhere('page_type', '')
            ->orWhere('page_type', '<>', 'partner');
    })
    ->limit(5)
    ->orderBy('sort_no', 'asc')
    ->get();
$cate = DB::table('categories')->where('show_no_mob', 1)->orderBy('sort_no', 'asc')->get();
$mega_menu = DB::table('categories')->where('mega_menu', 1)->orderBy('sort_no', 'asc')->get();
$partner_menu_pages = DB::table('pages')
    ->where('page_type', 'partner')
    ->where('status', 1)
    ->orderBy('sort_no', 'asc')
    ->get();
$partner_hub_url = $partner_menu_pages->isNotEmpty()
    ? url('/' . ltrim($partner_menu_pages->first()->slug, '/'))
    : null;
$categories = DB::table('categories')->where('home_cat', 1)->orderBy('sort_no', 'asc')->limit(4)->get();
$slider = DB::table('sliders')->first();
$sliders = $slider ? DB::table('sliders')->where('id', '!=', $slider->id)->get() : '';
?>

<style>
    .search-results {
        border: 1px solid #ccc;
        background: #fff;
        max-height: 300px;
        overflow-y: auto;
        position: absolute;
        z-index: 1000;
        width: 82vw;
        height: 100vh;
        top: 140px;
        left: 140px;
        border-radius: 11px
    }

    .search-results div {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee
    }

    .search-results div:hover {
        background: #f9f9f9
    }

    @media (max-width:1024px) {
        .search-results {
            width: 90vw;
            height: 60vh;
            top: 100px;
            left: 5%
        }
    }

    @media (max-width:768px) {
        .search-results {
            width: 93vw;
            height: 50vh;
            top: 140px;
            left: 5.5%;
            border-radius: 8px
        }

        .search-results div {
            padding: 8px
        }
    }
</style>
{{-- announcement bar --}}
@php
    $TopAnnouncementBar = TopAnnouncementBar::where('status', 'active')->get();
@endphp

<div class="announcement-bar">
    <div class="container">
        @if (isset($TopAnnouncementBar) && count($TopAnnouncementBar) > 0)
            <div class="ann-text">
                @php $bar = $TopAnnouncementBar->first(); @endphp
                <p>
                    {!! app()->isLocale('ar') ? $bar->text_ar : $bar->text !!}
                </p>
            </div>
        @endif
    </div>
</div>

<div class="main_header">
    {{-- desktop nav --}}
    <div class="container">
        <nav class="navbar_container">
            <div class="navbar_brand">
                <a href="{{ url('/') }}" title="des_logo">
                    <img src="{{ asset('') }}{{ $setting->logo }}" width="165" height="72"
                        alt="{{ getSetting('site_title') }}" title="{{ getSetting('site_title') }}" class="logo">
                </a>
            </div>
            <ul class="nav-ul">
                    <li> {{-- mega menu --}}
                        <div class="mega-dropdown">
                            <button class="mega-dropdown-toggle nav_item" title="mega_menu_button">
                                <span>{{ __('header.mega.title_shop') }}</span>
                                <i class="fa-solid fa-angle-down mega_menu_arrow"></i>
                            </button>
                            <div class="mega-dropdown-menu">
                                <div class="mega_dropdown_menu_inner">
                                    <div class="menu-left">
                                        <!-- <h5 class="shop-h">{{ __('header.nav.shop') }}</h5> -->
                                        <ul>
                                            <li id="first_category" class="category category_item" style="height:auto">
                                                <a
                                                    href="<?php echo url('/'); ?>/shop">{{ __('header.nav.all_product') }}</a>
                                            </li>
                                            @foreach ($mega_menu as $v)
                                                <li id="{{ $v->slug }}" class="category category_item"
                                                    style="height:auto"><a
                                                        href="<?php echo url('/'); ?>/category/{{ $v->slug }}">
                                                        {{ app()->getLocale() == 'ar' ? $v->name_ar : $v->name }}
                                                    </a> </li>
                                            @endforeach
                                            <li id="seventh_category" style="display:none"
                                                class="category category_item"> <a
                                                    href="{{ url('/') }}/celebrations">{{ __('header.nav.event_type') }}</a>
                                            </li>
                                            <li id="sixth_category" style="display:none" class="category category_item">
                                                <a href="{{ url('/') }}/shop">{{ __('header.nav.flavour') }}</a>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- default/right side blocks --}}
                                    <div class="menu-right zero_category active" data-set="" name="default">
                                        <div class="row">
                                            @foreach ($categories as $v)
                                                <div class="col-md-3">
                                                    <div class="category_wrapper">
                                                        <a href="{{ url('/') }}/category/{{ $v->slug }}"
                                                            style="display:block;">
                                                            <img src="{{ asset('') }}{{ $v->banner }}"
                                                                alt="{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}"
                                                                title="{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}">
                                                            <p>
                                                                {{ app()->isLocale('ar') ? $v->name_ar : $v->name }}
                                                            </p>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="menu-right container first_category" name="first_category">
                                        <div
                                            style="display:grid; grid-template-columns: auto auto auto auto;width:100%">
                                            @php $product = Product::where('status',1)->limit(3)->get(); @endphp @foreach ($product as $v)
                                                <a class="" style="box-shadow: none"
                                                    href="<?php echo url('/'); ?>/product/{{ $v->slug }}">
                                                    <div class="card-container" style="max-width: 180px;width: 100%;">
                                                        <div class="image"
                                                            style="max-width: 180px; height: 160px; width: 100%;">
                                                            {{--
                                                        <button class="floating-btn">Sale</button> --}} <img
                                                                src="{{ asset('') }}{{ $v->image_one }}"
                                                                alt=" {{ $v->product_name }}"
                                                                title="{{ $v->product_name }}"
                                                                style="display: unset; width: 100%; height: 160px;" />
                                                        </div>
                                                        <div class="content">
                                                            <p class="product-name">{{ $v->product_name }}</p>
                                                            <p class="rats"> <span
                                                                    class="icon-aed">{{ getSetting('currency') }}</span><span>
                                                                    {{ $v->discount_price }}</span>
                                                                @if ($v->selling_price > 0)
                                                                    <del class="ml"><span
                                                                            class="icon-aed">{{ getSetting('currency') }}</span><span>
                                                                            {{ $v->selling_price }}</span></del>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                            <a href="{{ url('/') }}/shop" class="">
                                                <div class=" card-container view_all" style=" min-width:175px">
                                                    {{ __('header.nav.view_all') }}</div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="menu-right container second_category" name="first_category">
                                        <div
                                            style="display:grid; grid-template-columns: auto auto auto auto;width:100%">
                                            @php $product = Product::where('new_arrival',1)->limit(3)->get(); @endphp @foreach ($product as $v)
                                                <a style="box-shadow: none"
                                                    href="<?php echo url('/'); ?>/product/{{ $v->slug }}">
                                                    <div class="card-container" style="max-width: 180px;width: 100%;">
                                                        <div class="image"
                                                            style="max-width: 180px; height: 160px; width: 100%;">
                                                            {{--
                                                        <button class="floating-btn">Sale</button> --}} <img
                                                                src="{{ asset('') }}{{ $v->image_one }}"
                                                                alt=" {{ $v->product_name }}"
                                                                title="{{ $v->product_name }}"
                                                                style="display: unset; width: 100%;height: 160px;" />
                                                        </div>
                                                        <div class="content">
                                                            <p class="product-name">{{ $v->product_name }}</p>
                                                            <p class="rats"> {{ $v->discount_price }}
                                                                {{ getSetting('currency') }} @if ($v->selling_price > 0)
                                                                    <del class="ml">{{ $v->selling_price }}
                                                                        {{ getSetting('currency') }}</del>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                            <a href="{{ url('/') }}/shop">
                                                <div class="view_all" style=" min-width:175px">
                                                    {{ __('header.nav.view_all') }}</div>
                                            </a>
                                        </div>
                                    </div>
                                    @foreach ($mega_menu as $v)
                                        <div class="menu-right container {{ $v->slug }}" name="first_category">
                                            <div
                                                style="display:grid; grid-template-columns: auto auto auto auto;width:100%">
                                                @php
                                                    $searchObj = DB::table('category_conditions')
                                                        ->where('category_id', $v->id)
                                                        ->select('type', 'condition', 'condition_value')
                                                        ->get();
                                                    $product = \App\Models\Admins\Product::query();
                                                    if (isset($v->is_manual) && $v->is_manual == 2) {
                                                        if ($searchObj->count() > 0) {
                                                            foreach ($searchObj as $val) {
                                                                $method = $v->is_condition == 2 ? 'orWhere' : 'where';
                                                                if (trim($val->type) == 'Price') {
                                                                    $product->$method(
                                                                        'discount_price',
                                                                        $val->condition,
                                                                        intval($val->condition_value),
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Format') {
                                                                    $product->$method(
                                                                        'format',
                                                                        $val->condition,
                                                                        intval($val->condition_value),
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Tag') {
                                                                    $conditionValues = explode(
                                                                        ',',
                                                                        $val->condition_value,
                                                                    );
                                                                    $tagValues = array_map(
                                                                        fn($value) => str_replace(
                                                                            ' ',
                                                                            '',
                                                                            trim($value),
                                                                        ),
                                                                        $conditionValues,
                                                                    );
                                                                    foreach ($tagValues as $tag) {
                                                                        $product->$method(
                                                                            'tags',
                                                                            'LIKE',
                                                                            '%' . $tag . '%',
                                                                        );
                                                                    }
                                                                }
                                                                if (trim($val->type) == 'Title') {
                                                                    $product->$method(
                                                                        'product_name',
                                                                        $val->condition,
                                                                        $val->condition_value,
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Made in') {
                                                                    $product->$method(
                                                                        'country',
                                                                        $val->condition,
                                                                        intval($val->condition_value),
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Products') {
                                                                    if ($val->condition_value) {
                                                                        $product->whereIn(
                                                                            'id',
                                                                            explode(',', $val->condition_value),
                                                                        );
                                                                    }
                                                                }
                                                                if (trim($val->type) == 'Brand') {
                                                                    $product->$method(
                                                                        'brand_id',
                                                                        $val->condition,
                                                                        intval($val->condition_value),
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Theme') {
                                                                    $product->$method(
                                                                        'theme_id',
                                                                        $val->condition,
                                                                        intval($val->condition_value),
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Flavour') {
                                                                    $product->$method(
                                                                        'flavour_id',
                                                                        $val->condition,
                                                                        intval($val->condition_value),
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Color') {
                                                                    $product->$method(
                                                                        'product_color',
                                                                        $val->condition,
                                                                        intval($val->condition_value),
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Allergens') {
                                                                    $product->$method(
                                                                        'allergen',
                                                                        $val->condition,
                                                                        intval($val->condition_value),
                                                                    );
                                                                }
                                                                if (trim($val->type) == 'Weight') {
                                                                    $product->$method(
                                                                        'weight',
                                                                        $val->condition,
                                                                        $val->condition_value,
                                                                    );
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $product = $product->whereRaw(
                                                            "? = ANY(string_to_array(category_id, ','))",
                                                            [$v->id],
                                                        );
                                                    }
                                                $product = $product->where('status', 1)->limit(3)->get(); @endphp
                                                @foreach ($product as $v1)
                                                    <a style="box-shadow: none"
                                                        href="<?php echo url('/'); ?>/product/{{ $v1->slug }}">
                                                        <div class="card-container"
                                                            style="max-width: 180px;width: 100%;">
                                                            <div class="image"
                                                                style="max-width: 180px; height: 160px; width: 100%;">
                                                                {{--
                                                        <button class="floating-btn">Sale</button> --}} <img
                                                                    src="{{ asset('') }}{{ $v1->image_one }}"
                                                                    alt=" {{ $v1->product_name }}"
                                                                    title="{{ $v1->product_name }}"
                                                                    style="display: unset; width: 100%;height: 160px;" />
                                                            </div>
                                                            <div class="content">
                                                                <p class="product-name">
                                                                    {{ app()->isLocale('ar') ? $v1->name_ar : $v1->product_name }}
                                                                </p>
                                                                <p class="rats"> <span
                                                                        class="icon-aed">{{ getSetting('currency') }}</span>
                                                                    <span>{{ $v1->discount_price }}</span>
                                                                    @if ($v1->selling_price > 0)
                                                                        <del class="ml"><span
                                                                                class="icon-aed">{{ getSetting('currency') }}</span>
                                                                            <span>{{ $v1->selling_price }}</span></del>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                                <a href="{{ url('/') }}/category/{{ $v->slug }}">
                                                    <div class="view_all" style=" min-width:175px">
                                                        {{ __('header.nav.view_all') }}</div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach {{-- flavours block --}}
                                    <div class="menu-right sixth_category container flavour_category"
                                        name="seventh_category">
                                        <div class="row"> @php $flavours = Flavour::limit(3)->get(); @endphp @foreach ($flavours as $v)
                                                <a class="col-3"
                                                    href="{{ url('/') }}/flavour/{{ $v->slug }}"
                                                    class="flavour_card">
                                                    <div class="flavour_card" style="background-color:#EE253F;">
                                                        {{ $v->name }}</div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div> {{-- celebrations block --}}
                                    <div class="menu-right seventh_category container flavour_category2">
                                        <div class="row"> @php $themes = Theme::limit(3)->get(); @endphp @foreach ($themes as $v)
                                                <a class="col-3"
                                                    href="{{ url('/') }}/celebration/{{ $v->slug }}">
                                                    <div class="celebration_card"
                                                        style="background-image:url('{{ $v->image ? asset($v->image) : asset('candy.jpg') }}'); height:249px;width:180px; border-radius:8px; display:flex; justify-content:center; align-items:center; font-size:20px;">
                                                        <span style="font-size:20px;">{{ $v->name }}</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                            <a class="col-3" href="{{ url('/') }}/celebrations">
                                                <div class="view_all">{{ __('header.nav.view_all') }}</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @if ($partner_hub_url)
                        <li>
                            <div class="mega-dropdown partner-mega-dropdown">
                                <a href="{{ $partner_hub_url }}" class="mega-dropdown-toggle nav_item partner-mega-toggle">
                                    <span>{{ __('header.mega.partner') }}</span>
                                    <i class="fa-solid fa-angle-down mega_menu_arrow"></i>
                                </a>
                                <div class="mega-dropdown-menu partner-mega-dropdown-menu">
                                    <div class="partner_menu_dropdown_inner">
                                        <ul class="partner_menu_link_list">
                                            @foreach ($partner_menu_pages as $index => $partnerPage)
                                             @if($index > 0)
                                                <li>
                                                    <a 
                                                        href="{{ url('/') }}/{{ $partnerPage->slug }}">{{ app()->isLocale('ar') ? $partnerPage->name_ar : $partnerPage->name }}</a>
                                                </li>
                                             @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    @foreach ($pages_des as $v)
                        <li class="pick&mix {{ Session::get('title') == $v->name ? 'active_tab' : '' }}">
                            <a class="nav_item" href="<?php echo url('/'); ?>/{{ $v->slug }}">
                                {{ app()->isLocale('ar') ? $v->name_ar : $v->name }}
                            </a>
                        </li>
                    @endforeach
            </ul>
            <div class="navbar_trailing">
                <div class="elfsight-app-38cf2af6-0dfe-48a5-9c6a-e62f1ba0a864" data-elfsight-app-lazy></div>
                <div class="nav_options"> {{-- Language switcher with SVG flags --}}
                {{-- <div id="lang-selector" class="lang-selector">

                    <button id="selector-btn" class="selector-btn" title="language_selector">
                        <img class="flag" src="{{ asset('front/assets/images/uae.webp') }}" alt="">

                        <span id="selected-text" class="selected-text">
                            {{ app()->getLocale() === 'ar' ? 'AR' : 'EN' }}
                        </span>
                    </button>

                    <div id="lang-dropdown" class="lang-dropdown">

                    <div class="dropdown_section">
                        <div class="section-title">{{ __('header.country') }}</div>

                        <div class="option country selected" data-value="UAE">
                            <img class="flag" src="{{ asset('front/assets/images/uae.webp') }}" alt="">
                            <span>UAE</span>
                            <span class="tick">✔</span>
                        </div>
                    </div>

                    <div class="dropdown_section">
                        <div class="section-title">{{ __('header.language') }}</div>

                        <div class="option language " data-locale="en">
                            <span class="flag emoji">🌐</span>
                            <span>English</span>
                            {!! app()->getLocale() === 'en' ? '<span class="tick">✔</span>' : '' !!}
                        </div>

                        <div class="option language " data-locale="ar">
                            <span class="flag emoji">ع</span>
                            <span>العربية</span>
                            {!! app()->getLocale() === 'ar' ? '<span class="tick">✔</span>' : '' !!}
                        </div>
                    </div>
                    </div>
                </div> --}}

                <button type="button" class="option_item" id="open_search" title="open_search">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18 10.2C18 11.9213 17.4413 13.5113 16.5 14.8013L21.2475 19.5525C21.7163 20.0213 21.7163 20.7825 21.2475 21.2513C20.7788 21.72 20.0175 21.72 19.5488 21.2513L14.8013 16.5C13.5113 17.4413 11.9213 18 10.2 18C5.89127 18 2.40002 14.5088 2.40002 10.2C2.40002 5.89127 5.89127 2.40002 10.2 2.40002C14.5088 2.40002 18 5.89127 18 10.2ZM10.2 15.6C13.1813 15.6 15.6 13.1813 15.6 10.2C15.6 7.21877 13.1813 4.80002 10.2 4.80002C7.21877 4.80002 4.80002 7.21877 4.80002 10.2C4.80002 13.1813 7.21877 15.6 10.2 15.6Z" />
                    </svg>
                </button>

                @if (Session::get('user'))
                    <a href="{{ url('/') }}/my_account" class="option_item user_icon"
                        title="{{ __('header.account.my_account') }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.8 12C19.8 7.69127 16.3088 4.20002 12 4.20002C7.69127 4.20002 4.20002 7.69127 4.20002 12C4.20002 14.2575 5.16002 16.2938 6.69377 17.7188L7.80002 14.4H16.2L17.3063 17.7188C18.84 16.2938 19.8 14.2613 19.8 12ZM14.9025 16.2H9.09752L8.22377 18.825C9.34127 19.4475 10.6313 19.8 12 19.8C13.3688 19.8 14.6588 19.4475 15.7763 18.825L14.9025 16.2ZM2.40002 12C2.40002 6.69752 6.69752 2.40002 12 2.40002C17.3025 2.40002 21.6 6.69752 21.6 12C21.6 17.3025 17.3025 21.6 12 21.6C6.69752 21.6 2.40002 17.3025 2.40002 12ZM10.5 9.90002C10.5 10.7288 11.1713 11.4 12 11.4C12.8288 11.4 13.5 10.7288 13.5 9.90002C13.5 9.07127 12.8288 8.40002 12 8.40002C11.1713 8.40002 10.5 9.07127 10.5 9.90002ZM12 13.2C10.1775 13.2 8.70002 11.7225 8.70002 9.90002C8.70002 8.07752 10.1775 6.60002 12 6.60002C13.8225 6.60002 15.3 8.07752 15.3 9.90002C15.3 11.7225 13.8225 13.2 12 13.2Z" />
                        </svg>

                    </a>
                @else
                    <a href="{{ url('/') }}/login" class="option_item user_icon"
                        title="{{ __('header.account.login') }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.8 12C19.8 7.69127 16.3088 4.20002 12 4.20002C7.69127 4.20002 4.20002 7.69127 4.20002 12C4.20002 14.2575 5.16002 16.2938 6.69377 17.7188L7.80002 14.4H16.2L17.3063 17.7188C18.84 16.2938 19.8 14.2613 19.8 12ZM14.9025 16.2H9.09752L8.22377 18.825C9.34127 19.4475 10.6313 19.8 12 19.8C13.3688 19.8 14.6588 19.4475 15.7763 18.825L14.9025 16.2ZM2.40002 12C2.40002 6.69752 6.69752 2.40002 12 2.40002C17.3025 2.40002 21.6 6.69752 21.6 12C21.6 17.3025 17.3025 21.6 12 21.6C6.69752 21.6 2.40002 17.3025 2.40002 12ZM10.5 9.90002C10.5 10.7288 11.1713 11.4 12 11.4C12.8288 11.4 13.5 10.7288 13.5 9.90002C13.5 9.07127 12.8288 8.40002 12 8.40002C11.1713 8.40002 10.5 9.07127 10.5 9.90002ZM12 13.2C10.1775 13.2 8.70002 11.7225 8.70002 9.90002C8.70002 8.07752 10.1775 6.60002 12 6.60002C13.8225 6.60002 15.3 8.07752 15.3 9.90002C15.3 11.7225 13.8225 13.2 12 13.2Z" />
                        </svg>

                    </a>
                @endif
                <a href="{{ url('/') }}/cart" class="option_item" id="headerCartLink"
                    data-cart-drawer-url="{{ url('/cart/drawer') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.52505 9.60002H19.635L17.8388 18.1238C17.7788 18.4013 17.535 18.6 17.25 18.6H6.7463C6.4613 18.6 6.21755 18.4013 6.15755 18.1238L4.36505 9.60002H6.52505ZM15.0038 7.80002H9.00005L10.695 6.00002L10.7663 5.92502L12.0038 4.61252L13.2413 5.92502L13.3125 6.00002L15.0075 7.80002H15.0038ZM21.3 7.80002H17.475C17.0063 7.30127 15.6188 5.82752 13.3088 3.37877L12.6563 2.68127C12.4838 2.50127 12.2475 2.40002 12 2.40002C11.7525 2.40002 11.5163 2.50127 11.3438 2.68127C11.2988 2.73002 10.08 4.02377 7.68755 6.56252L6.52505 7.80002H2.70005C2.2013 7.80002 1.80005 8.20127 1.80005 8.70002C1.80005 9.13502 2.1113 9.49877 2.5238 9.58127L4.3988 18.4913C4.6313 19.6013 5.6138 20.3963 6.7463 20.3963H17.25C18.3863 20.3963 19.365 19.6013 19.5975 18.4913L21.4725 9.58127C21.885 9.49877 22.1963 9.13502 22.1963 8.70002C22.1963 8.20127 21.7951 7.80002 21.2963 7.80002H21.3ZM9.00005 12.3C9.00005 11.8013 8.5988 11.4 8.10005 11.4C7.6013 11.4 7.20005 11.8013 7.20005 12.3V15.9C7.20005 16.3988 7.6013 16.8 8.10005 16.8C8.5988 16.8 9.00005 16.3988 9.00005 15.9V12.3ZM12 11.4C11.5013 11.4 11.1 11.8013 11.1 12.3V15.9C11.1 16.3988 11.5013 16.8 12 16.8C12.4988 16.8 12.9 16.3988 12.9 15.9V12.3C12.9 11.8013 12.4988 11.4 12 11.4ZM16.8 12.3C16.8 11.8013 16.3988 11.4 15.9 11.4C15.4013 11.4 15 11.8013 15 12.3V15.9C15 16.3988 15.4013 16.8 15.9 16.8C16.3988 16.8 16.8 16.3988 16.8 15.9V12.3Z" />
                    </svg>

                    <span class="product-count"
                        id="cartValue">{{ Session::has('cart') ? App\Helpers\Cart::qty() : 0 }}</span>
                </a>
                @php
                    $__headerCartQty = Session::has('cart') ? App\Helpers\Cart::qty() : 0;
                @endphp
                <span id="cartValue1" hidden>{{ $__headerCartQty }}</span>
                <span id="cartValue2" hidden>{{ $__headerCartQty }}</span>

                <button type="button" class="option_item menu_icon" title="open_mobile_menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3.59961 5.9998C3.59961 5.33605 4.13586 4.7998 4.79961 4.7998H19.1996C19.8634 4.7998 20.3996 5.33605 20.3996 5.9998C20.3996 6.66355 19.8634 7.1998 19.1996 7.1998H4.79961C4.13586 7.1998 3.59961 6.66355 3.59961 5.9998ZM3.59961 11.9998C3.59961 11.3361 4.13586 10.7998 4.79961 10.7998H19.1996C19.8634 10.7998 20.3996 11.3361 20.3996 11.9998C20.3996 12.6636 19.8634 13.1998 19.1996 13.1998H4.79961C4.13586 13.1998 3.59961 12.6636 3.59961 11.9998ZM20.3996 17.9998C20.3996 18.6636 19.8634 19.1998 19.1996 19.1998H4.79961C4.13586 19.1998 3.59961 18.6636 3.59961 17.9998C3.59961 17.3361 4.13586 16.7998 4.79961 16.7998H19.1996C19.8634 16.7998 20.3996 17.3361 20.3996 17.9998Z" />
                    </svg>
                </button>
                </div>
            </div>
        </nav>
    </div>
</div>
{{-- search dropdown --}}
<div class="search_bar_overlay">
    <form action="{{ url('/') }}/search" class="search_form" method="get">
        <!-- <div class="row">
            <div class="col-6 col-xs-6">
                <h2 class="" style="color: white;font-size: 25px;font-weight: 900;">{{ __('header.search.title') }}</h2>
            </div>
            <div class="col-6 col-xs-6" style="text-align:right">
                <i id="close_search" style="color: white;font-size: 25px;font-weight: 900;" class="fa-solid fa-xmark  red close_search"></i>
            </div>
        </div> -->

        <div class="search_input">
            <input type="search" name="text" id="searchBox" required
                placeholder="{{ __('header.search.placeholder') }}" autofocus>
            <button type="submit" class="search" style="margin:0">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>

        <div class="search_card_container">
            <div class="container"
                style="padding:0;width:100%;display:flex;justify-content:center;align-items:center;">
                <div id="searchResults" class="row" style="row-gap:30px;width:100%"></div>
            </div>

            <div class="main_search_container" id="default_search_products">
                <div class="popular-categories">
                    <p class="heading section_heading red ">{{ __('header.search.most_popular_categories') }}</p>
                    <div class="search_category">
                        <div class="row">
                            @foreach ($categories as $v)
                                <div class="col-6 col-xs-6">
                                    <div class="category_card">
                                        <div class="image">
                                            <a href="{{ url('/') }}/category/{{ $v->slug }}"><img
                                                    src="{{ asset('') }}{{ $v->image }}"
                                                    alt="{{ $v->name }}" title="{{ $v->name }}" /></a>
                                        </div>
                                        <p class="name">{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="line"></div>

                <div class="trending-products">
                    <p class="section_heading red left">{{ __('header.search.trending_products') }}</p>
                    <div class="tp-cards">
                        @foreach ($trending as $v)
                            <div class="tp-card-container">
                                <div class="image">
                                    <a href="{{ url('/') }}/product/{{ $v->slug }}"><img
                                            src="{{ asset('') }}{{ $v->image_one }}?v={{ strtotime($v->updated_at) }}"
                                            alt="{{ $v->product_name }}" title="{{ $v->product_name }}" /></a>
                                    <!-- <button class="float-btn">Sale</button> -->
                                </div>
                                <div class="pt-content">
                                    <a href="{{ url('/') }}/product/{{ $v->slug }}">
                                        <p class="product-name">
                                            {{ app()->isLocale('ar') ? $v->name_ar : $v->product_name }}</p>
                                    </a>
                                    <p class="price">
                                        <span class="icon-aed">{{ getSetting('currency') }}</span>
                                        <span>{{ $v->discount_price }}</span>
                                        @if ($v->selling_price > 0)
                                            <del><span
                                                    class="icon-aed">{{ getSetting('currency') }}</span><span>{{ $v->selling_price }}</span></del>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <button class="view-all-btn">
                            <a href="{{ url('/') }}/shop">{{ __('header.search.view_all_button') }}</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="button-close">
            <button type="button"
                class="btn btn_outlined red close_search width_100">{{ __('search.close') }}</button>
        </div>
    </form>
</div>

{{-- mobile nav --}}
<div class="mbl_nav_container" id="mbl_nav_container">
    <div class="header">
        <a href="/" title="{{ getSetting('site_title') }}">
            <img src="{{ asset('') }}{{ $setting->logo }}" title="logo" width="165" height="72"
                alt="{{ getSetting('site_title') }}" title="{{ getSetting('site_title') }}">
        </a>
        <button class="option_item" id="close_mbl_menu" title="close_mobile_menu">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="mbl_nav_body">

        <ul>
            <li class="mbl_shop_dropdown">
                <div class="mbl_shop_toggle">
                    {{ __('header.nav.shop') }} <div class="arrow"></div>
                </div>
                <ul class="mbl_dropdown">
                    <li><a href="{{ url('/') }}/shop">{{ __('header.nav.all_products') }}</a></li>
                    {{-- <li>{{ __('header.nav.new_arrivals') }}</li> --}}
                    @foreach ($mega_menu as $v)
                        <li><a
                                href="{{ url('/') }}/category/{{ $v->slug }}">{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>

            @if ($partner_hub_url)
                <li class="mbl_shop_dropdown">
                    <div class="mbl_shop_toggle">
                        {{ __('header.mega.partner') }}
                        <div class="arrow"></div>
                    </div>
                    <ul class="mbl_dropdown" style="display:none">
                        @foreach ($partner_menu_pages as $partnerPage)
                            <li><a
                                    href="{{ url('/') }}/{{ $partnerPage->slug }}">{{ app()->isLocale('ar') ? $partnerPage->name_ar : $partnerPage->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif

            @foreach ($pages_des as $v)
                <li class="pick&mix {{ Session::get('title') == $v->name ? 'active_tab' : '' }}">
                    <a
                        href="<?php echo url('/'); ?>/{{ $v->slug }}">{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}</a>
                </li>
            @endforeach
        </ul>

        <div class="account_actions">
            @if (Session::get('user'))
                <button class="btn btn_primary red"> <i class="fa-regular fa-circle-user"></i><a
                        href="{{ url('/') }}/my_account">My
                        Account</a>
                </button>
            @else
                <button class="btn btn_primary red"> <i class="fa-regular fa-circle-user"></i><a
                        href="{{ url('/') }}/login">Login</a>
                </button>
            @endif
        </div>
        <div class="contect_us">
            <div class="contect">
                <p>{{ __('header.mobile.contact_info') }}</p>
                <div class="phone">
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                </div>
                <div class="email">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                </div>
            </div>
            <div class="follow">
                <p>{{ __('header.mobile.follow_us') }}</p>
                <div class="socail_icons">
                    <div class="facebook">
                        <a href="https://www.facebook.com/share/1CkAwUTTgm/?mibextid=wwXIfr" title="facebook"
                            target="_black" class="icon"><i class="fa-brands fa-facebook"></i></a>
                    </div>
                    <div class=" instagram">
                        <a href="https://www.instagram.com/goodiset" target="_black" title="instagram"
                            class="icon"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                    <div class="twitter">
                        <a href="https://www.tiktok.com/@goodiset" target="_black" title="tiktok" class="icon"><i
                                class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
<!-- mobile nav ends here -->

<div id="cartDrawerRoot" class="cart-drawer-root" aria-hidden="true">
    <div id="cartDrawerBackdrop" class="cart-drawer-backdrop" tabindex="-1"></div>
    <aside id="cartDrawerPanel" class="cart-drawer-panel" role="dialog" aria-modal="true"
        aria-label="{{ __('cart.drawer.a11y_label') }}" aria-hidden="true">
        <button type="button" class="cart-drawer-close" id="cartDrawerClose"
            aria-label="{{ __('cart.drawer.close') }}">&times;</button>
        <div id="cartDrawerBody" class="cart-drawer-body" aria-live="polite"></div>
    </aside>
</div>

<a href="{{ url('/') }}/cart" class="cart-fab" data-cart-drawer-url="{{ url('/cart/drawer') }}"
    aria-label="{{ __('cart.drawer.a11y_label') }}">
    <span class="cart-fab__icon" aria-hidden="true">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M6.52505 9.60002H19.635L17.8388 18.1238C17.7788 18.4013 17.535 18.6 17.25 18.6H6.7463C6.4613 18.6 6.21755 18.4013 6.15755 18.1238L4.36505 9.60002H6.52505ZM15.0038 7.80002H9.00005L10.695 6.00002L10.7663 5.92502L12.0038 4.61252L13.2413 5.92502L13.3125 6.00002L15.0075 7.80002H15.0038ZM21.3 7.80002H17.475C17.0063 7.30127 15.6188 5.82752 13.3088 3.37877L12.6563 2.68127C12.4838 2.50127 12.2475 2.40002 12 2.40002C11.7525 2.40002 11.5163 2.50127 11.3438 2.68127C11.2988 2.73002 10.08 4.02377 7.68755 6.56252L6.52505 7.80002H2.70005C2.2013 7.80002 1.80005 8.20127 1.80005 8.70002C1.80005 9.13502 2.1113 9.49877 2.5238 9.58127L4.3988 18.4913C4.6313 19.6013 5.6138 20.3963 6.7463 20.3963H17.25C18.3863 20.3963 19.365 19.6013 19.5975 18.4913L21.4725 9.58127C21.885 9.49877 22.1963 9.13502 22.1963 8.70002C22.1963 8.20127 21.7951 7.80002 21.2963 7.80002H21.3ZM9.00005 12.3C9.00005 11.8013 8.5988 11.4 8.10005 11.4C7.6013 11.4 7.20005 11.8013 7.20005 12.3V15.9C7.20005 16.3988 7.6013 16.8 8.10005 16.8C8.5988 16.8 9.00005 16.3988 9.00005 15.9V12.3ZM12 11.4C11.5013 11.4 11.1 11.8013 11.1 12.3V15.9C11.1 16.3988 11.5013 16.8 12 16.8C12.4988 16.8 12.9 16.3988 12.9 15.9V12.3C12.9 11.8013 12.4988 11.4 12 11.4ZM16.8 12.3C16.8 11.8013 16.3988 11.4 15.9 11.4C15.4013 11.4 15 11.8013 15 12.3V15.9C15 16.3988 15.4013 16.8 15.9 16.8C16.3988 16.8 16.8 16.3988 16.8 15.9V12.3Z"
                fill="currentColor" />
        </svg>
    </span>
    <span class="cart-fab__badge" id="cartValueFab">{{ $__headerCartQty }}</span>
</a>

<!-- Elfsight Website Translator | Untitled Website Translator 4 -->
<script src="https://elfsightcdn.com/platform.js" async></script>
