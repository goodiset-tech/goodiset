@extends('layout.app')
@php
    use Illuminate\Support\Facades\Session;
    use App\Models\Admins\Rating;
    $cate = DB::table('categories')->where('home_cat', 1)->orderBy('sort_no', 'asc')->limit(4)->get();
    $slider = DB::table('sliders')->orderBy('id', 'asc')->limit(1)->first();
    $sliders = DB::table('sliders')->where('status', 1)->limit(1)->get();
@endphp


@section('content')
    <!-- Popup -->
    @php
        $popup = App\Models\Popup::where('status', 1)
            ->where('start_date', '<=', \Carbon\Carbon::today())
            ->where('end_date', '>=', \Carbon\Carbon::today())
            ->first();
    @endphp
    @if ($popup)
        <div id="popupOverlay" class="overlay">
            <div class="new-year-modal">
                <span class="close-btn" id="closeBtn">
                    <img src="{{ asset('front/assets/images/close.png') }}" title="{{ __('home.popup.close') }}"
                        alt="{{ __('home.popup.close') }}">
                </span>
                <img src="{{ asset($popup->image) }}" title="{{ __('home.popup.image') }}" alt="{{ __('home.popup.image') }}">
            </div>
        </div>
    @endif
    <!-- End Popup -->

    <!-- hero section -->
    <section class="hero_section confetti-section">

        <div class="confetti-layer"></div> <!-- ✅ Confetti background layer (height controlled in Sass) -->

        <div class="hero_slider">
            @if ($sliders)
                @foreach ($sliders as $slide)
                    <div class="container">
                        @if (!empty($slide->cid))
                            <a href="{{ $slide->cid }}" class="hero_slide_link" title="hero_slider">
                        @endif
                        <div class="hero_slide">

                            <img src="{{ asset('') }}img/slider/{{ app()->isLocale('ar') ? $slide->slider_mobile_image : $slide->slider_image }}?v={{ strtotime($slide->updated_at) }}"
                                alt="" fetchpriority="high" />

                            {{-- <h1 class="hero_heading">
                                <?= app()->isLocale('ar') ? $slide->heading_ar : $slide->heading ?>
                            </h1>

                            <div class="hero_detail">
                                <?= app()->isLocale('ar') ? $slide->paragraph_ar : $slide->p ?>
                            </div>

                            <div class="hero_buttons">
                                @if ($slide->cid)
                                    <a class="btn btn_primary" href="{{ $slide->cid }}">
                                        {{ app()->isLocale('ar') ? $slide->button_ar : $slide->button }}
                                    </a>
                                @endif
                            </div> --}}
                        </div>
                        @if (!empty($slide->cid))
                            </a>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <!-- Promotional Section -->

    <section class="promo_banner">
        <div class="container">
            <div class="banner_grid">
                @if ($promotional_banners->count() == 2)
                    @foreach ($promotional_banners as $banner)
                        <div class="banner_item">
                            @if ($banner->link)
                                <a href="{{ $banner->link }}">
                            @endif
                            <img src="{{ asset('img/promotional/' . $banner->image) }}?v={{ strtotime($banner->updated_at) }}"
                                alt="Promotional Banner {{ $loop->iteration }}" loading="lazy" width="625"
                                height="200">
                            @if ($banner->link)
                                </a>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>


    <!-- End Promotional Section -->


    <!-- Category Section -->
    <section class="section category">
        <div class="container">
            <h1 class="section_heading center red">{{ __('home.cate.heading') }}</h1>
            <div class="row" style="justify-content: center;">
                @foreach ($cate as $v)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <div class="product-card" aria-label="{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}"
                            style="background-color: {{ $v->color }};">
                            <a href="{{ url('/') }}/category/{{ $v->slug }}" class="product-card__link"
                                title="{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}"
                                aria-label="{{ trim((app()->isLocale('ar') ? $v->name_ar : $v->name) . ' — ' . __('home.cate.button')) }}"></a>

                            <!-- Default state -->
                            <div class="card-default">
                                <div class="card-circle">
                                    {{-- <img src="{{ asset('') }}{{ $v->image }}?v={{ strtotime($v->updated_at) }}"
                                alt="{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}" /> --}}
                                </div>
                                {{-- <h3 class="card-title">{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}</h3> --}}
                            </div>

                            <!-- Hover hero (always at top) -->
                            <div class="card-hero">
                                <img src="{{ asset('') }}{{ $v->homepage_image ?? $v->banner }}?v={{ strtotime($v->updated_at) }}"
                                    alt="{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}" loading="lazy"
                                    width="300" height="220" />
                            </div>

                            <!-- Wave + background fill -->
                            <div class="card-mask" style="background-color: {{ $v->color }};">
                                <svg width="376" height="12" viewBox="0 0 376 12" xmlns="http://www.w3.org/2000/svg"
                                    preserveAspectRatio="none">
                                    <path fill="{{ $v->color }}"
                                        d="M219.033 3.95355C222.099 4.65027 224.994 5.40211 227.865 6.14792C233.676 7.65728 239.392 9.14197 246.24 10.095L246.661 10.1535C249.164 10.5019 251.318 10.8018 253.286 11.049C255.489 11.302 257.673 11.5109 259.607 11.6221C262.131 11.7672 264.303 11.8489 266.279 11.8708C268.255 11.8489 270.426 11.7672 272.951 11.6221C274.884 11.5109 277.069 11.302 279.271 11.049C281.239 10.8018 283.393 10.502 285.897 10.1535L286.317 10.095C293.165 9.14196 298.881 7.6573 304.692 6.14792C309.498 4.89965 314.369 3.63447 319.999 2.63913C321.221 2.4231 322.328 2.21903 323.37 2.02698C327.223 1.31684 330.184 0.771128 334.758 0.393406C341.735 -0.182772 345.7 -0.0768297 352.685 0.393404C358.015 0.752197 360.995 1.15517 366.267 2.01033C370.038 2.62201 373.088 3.33458 376 4.09809L375.984 12H0L0.0155877 4.15385C2.92768 3.39034 6.10812 2.62201 9.87909 2.01033C15.1511 1.15517 18.1309 0.752197 23.4606 0.393404C30.4457 -0.0768297 34.4112 -0.182772 41.3882 0.393406C45.9622 0.771129 48.9229 1.31684 52.7757 2.02698L52.777 2.02721C53.8185 2.21918 54.9254 2.4232 56.1468 2.63913C61.7771 3.63447 66.648 4.89965 71.4539 6.14792C77.265 7.65728 82.9811 9.14197 89.8291 10.095L90.2493 10.1535C92.7525 10.5019 94.9072 10.8018 96.8751 11.049C99.0776 11.302 101.262 11.5109 103.195 11.6221C105.72 11.7672 107.891 11.8489 109.867 11.8708C111.843 11.8489 114.015 11.7672 116.539 11.6221C118.473 11.5109 120.657 11.302 122.86 11.049C124.828 10.8018 126.982 10.502 129.485 10.1535L129.906 10.095C136.754 9.14196 142.47 7.6573 148.281 6.14792C151.152 5.40207 154.047 4.65018 157.113 3.95342C159.859 3.24459 162.759 2.58321 166.29 2.01033C168.377 1.67192 170.104 1.40434 171.76 1.18227C173.743 0.867395 175.794 0.604233 178.347 0.393406C182.16 0.0784708 185.074 -0.0326684 188.073 0.00808053C191.072 -0.0326684 193.986 0.0784708 197.8 0.393406C200.352 0.604226 202.403 0.867367 204.386 1.18223C206.042 1.4043 207.769 1.67191 209.856 2.01033C213.388 2.58325 216.287 3.24467 219.033 3.95355Z" />
                                </svg>
                            </div>

                            <!-- Content -->
                            <div class="card-content">
                                <h2 class="card-subtitle">{{ app()->isLocale('ar') ? $v->name_ar : $v->name }}</h2>
                                <p class="card-text">{{ app()->isLocale('ar') ? $v->sub_title_ar : $v->sub_title }}</p>
                                <span class="card-btn">{{ __('home.cate.button') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="about-inner">
            <!-- Bottom-left blob image -->
            <div class="about-image about-image--left">
                <img src="{{ asset('front/assets/images/about_left.webp') }}" alt="Goodiset Swedish Candy storefront"
                    loading="lazy" width="200" height="171" />
            </div>

            <!-- Top-right blob image -->
            <div class="about-image about-image--right">
                <img src="{{ asset('front/assets/images/about_right.webp') }}" alt="Goodiset Swedish Candy interior"
                    loading="lazy" width="200" height="171" />
            </div>

            <!-- Center text -->
            <div class="about-content section">
                <h2 class="section_heading red center">{!! __('home.intro.heading') !!}</h2>

                <p class="about-body">{{ __('home.intro.p1') }}</p>

                <p class="about-body about-body--highlight">
                    {{ __('home.intro.p2') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Flavour Section -->
    <section class="flavour-section section n_p_b n_p_t">
        <div class="flavour-inner">
            <div class="flavour-heading">
                <h2 class="section_heading red left"> {!! __('home.fla.heading') !!}</h2>
            </div>

            <div class="flavour-blobs">

                @foreach ($flavours as $flavour)
                    <a href="{{ route('flavour_detail', ['slug' => $flavour->slug]) }}" class="flavour-blob"
                        style="--blob-color: {{ $flavour->color ?? '#F778E0' }};">
                        {{-- <button class="flavour-blob" style="--blob-color: {{ $flavour->color ?? '#F778E0' }};"> --}}
                        <span class="flavour-blob__label">
                            {{ app()->isLocale('ar') ? $flavour->name_ar : $flavour->name }}</span>
                        {{-- </button> --}}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- feature section --}}
    <section class="features">
        <div class="container">
            <div class="row feature-cards n_m_t">
                <!-- First Column -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M32.0063 9.96411C32.9167 9.96424 33.3654 10.5531 33.4595 10.6155C35.0145 12.0731 36.7781 13.7251 39.1626 14.7131C41.6102 15.7288 44.0742 15.8229 46.27 15.9065C47.2543 15.9452 48.0561 16.746 48.0942 17.7551C48.1779 19.9288 48.2724 22.3943 49.2866 24.8381C50.261 27.1875 51.8295 28.8819 53.5239 30.6897C54.2072 31.4194 54.2076 32.5635 53.5249 33.2942C51.8147 35.1201 50.2618 36.7968 49.2866 39.1506C48.273 41.598 48.1794 44.0637 48.0962 46.2629C48.0585 47.2482 47.258 48.0505 46.2466 48.0901C44.0738 48.1737 41.6112 48.2697 39.1646 49.2844C36.9271 50.2138 35.1305 51.779 33.3101 53.5266C32.5799 54.211 31.4356 54.2091 30.7036 53.5247C28.8963 51.8322 27.2104 50.265 24.8472 49.2864C22.3988 48.2708 19.9351 48.1767 17.7339 48.093C16.7477 48.0553 15.9453 47.2528 15.9058 46.2317C15.8221 44.059 15.7267 41.5955 14.7144 39.1526C13.7397 36.7998 12.1694 35.1052 10.4731 33.2932C9.79056 32.5634 9.79072 31.4195 10.4712 30.6926C12.1834 28.8659 13.7399 27.1866 14.7153 24.8352C15.7295 22.3914 15.8257 19.9272 15.9116 17.7288C15.9498 16.7425 16.7521 15.9411 17.7622 15.9016C19.9367 15.8198 22.4012 15.7268 24.8491 14.7141C27.2328 13.7261 28.996 12.075 30.5562 10.6145C30.6504 10.5521 31.0962 9.96411 32.0063 9.96411Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M32.0103 2.58813C35.701 2.58813 38.3864 7.51449 41.5962 8.84595C44.9231 10.2256 50.2921 8.69405 52.7993 11.2014C55.3065 13.7089 53.7749 19.0779 55.1548 22.4045C56.4862 25.6142 61.4115 28.299 61.4116 31.9895C61.4116 35.6827 56.4867 38.3704 55.1567 41.5813C53.7778 44.9113 55.3117 50.281 52.8052 52.7903C50.2977 55.3004 44.9265 53.7714 41.5991 55.1526C38.3883 56.4856 35.7024 61.4124 32.0103 61.4124C28.3156 61.4119 25.6274 56.4858 22.4155 55.1545C19.0848 53.7742 13.713 55.3056 11.2036 52.7961C8.69447 50.2868 10.2254 44.9158 8.84521 41.5852C7.51399 38.3731 2.58838 35.6844 2.58838 31.9895C2.58853 28.2973 7.51533 25.6115 8.84814 22.4006C10.2292 19.0731 8.70018 13.7021 11.2104 11.1946C13.7196 8.68819 19.0895 10.222 22.4194 8.84302C25.63 7.51299 28.3173 2.58854 32.0103 2.58813ZM34.2759 9.44751C33.0057 8.25552 31.0137 8.25385 29.7026 9.48071C28.0622 11.0156 26.4457 12.5236 24.3091 13.4084C22.095 14.3247 19.7644 14.4134 17.6831 14.4924C15.9655 14.5588 14.5675 15.956 14.4995 17.6985C14.4196 19.7544 14.3282 22.0839 13.4106 24.2942C12.5208 26.4393 10.9939 28.0704 9.44287 29.7249C8.254 30.996 8.25382 32.9879 9.50244 34.3225C11.0483 35.9741 12.5319 37.5753 13.4097 39.6936C14.3256 41.9032 14.4157 44.2323 14.4966 46.3206C14.5624 48.0401 15.9613 49.4389 17.7075 49.5042C19.7626 49.5832 22.0926 49.6728 24.3071 50.5901C26.4454 51.4764 28.0751 52.9971 29.7407 54.5569C31.0155 55.7494 33.0072 55.7437 34.2759 54.5569L34.3442 54.4924C35.9801 52.9597 37.583 51.4699 39.7056 50.5881C41.9183 49.6709 44.2473 49.5802 46.3286 49.4993C48.0457 49.432 49.4415 48.0346 49.5083 46.2922C49.586 44.2362 49.6745 41.9048 50.5913 39.6907C51.4785 37.5494 52.9948 35.9261 54.5562 34.259C55.7449 32.988 55.7446 30.9961 54.4985 29.6643C52.9526 28.015 51.4687 26.4153 50.5903 24.2971C49.6732 22.0867 49.5839 19.7559 49.5044 17.676C49.4382 15.9592 48.0411 14.5635 46.3022 14.4963C44.2472 14.4173 41.9177 14.3276 39.7036 13.4104C37.5615 12.522 35.9344 11.0014 34.2759 9.44751Z" />
                                <path
                                    d="M19.4023 32.3037C20.053 32.3037 20.5919 32.4617 21.0186 32.7764C21.4504 33.0857 21.7304 33.5177 21.8584 34.0723H20.7783C20.6983 33.795 20.5412 33.5785 20.3066 33.4238C20.072 33.2692 19.7678 33.1924 19.3945 33.1924C19.0159 33.1924 18.69 33.2751 18.418 33.4404C18.1517 33.6003 17.9466 33.8346 17.8027 34.1436C17.6641 34.4476 17.5947 34.8111 17.5947 35.2324C17.5948 35.6536 17.6641 36.0164 17.8027 36.3203C17.9467 36.624 18.1491 36.8557 18.4102 37.0156C18.6714 37.1703 18.9782 37.248 19.3301 37.248C19.8527 37.248 20.248 37.101 20.5146 36.8076C20.7811 36.5144 20.9383 36.1332 20.9863 35.6641H19.5381V34.9355H21.9541V38H21.0742L20.9941 37.2324C20.8715 37.4136 20.7302 37.5709 20.5703 37.7041C20.4103 37.8321 20.2206 37.9307 20.002 38C19.7887 38.0639 19.5378 38.0957 19.25 38.0957C18.7222 38.0956 18.2583 37.9762 17.8584 37.7363C17.4638 37.4964 17.1571 37.1628 16.9385 36.7363C16.7198 36.3043 16.6104 35.7996 16.6104 35.2236C16.6104 34.6531 16.7223 34.1492 16.9463 33.7119C17.1703 33.2693 17.4903 32.925 17.9062 32.6797C18.3276 32.429 18.8264 32.3037 19.4023 32.3037Z"
                                    class="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M24.8535 33.8721C25.2481 33.8721 25.5924 33.9598 25.8857 34.1357C26.1789 34.3117 26.4054 34.5492 26.5654 34.8477C26.7254 35.1409 26.8056 35.4719 26.8057 35.8398V36.0156C26.8057 36.0795 26.8007 36.1466 26.79 36.2158H23.7715C23.7832 36.4193 23.8246 36.5982 23.9014 36.752C23.9974 36.9333 24.1261 37.072 24.2861 37.168C24.4514 37.2586 24.6353 37.3037 24.8379 37.3037C25.0618 37.3037 25.2457 37.2561 25.3896 37.1602C25.5389 37.0642 25.6484 36.9362 25.7178 36.7764H26.6934C26.6187 37.0268 26.4967 37.2535 26.3262 37.4561C26.1555 37.6534 25.944 37.8104 25.6934 37.9277C25.4427 38.0397 25.1603 38.0957 24.8457 38.0957C24.4458 38.0957 24.094 38.0105 23.79 37.8398C23.4862 37.6639 23.2488 37.4189 23.0781 37.1045C22.9075 36.7898 22.8223 36.4263 22.8223 36.0156C22.8223 35.5894 22.9042 35.2163 23.0693 34.8965C23.24 34.5765 23.4782 34.3259 23.7822 34.1445C24.0915 33.9633 24.4483 33.8721 24.8535 33.8721ZM24.8457 34.6562C24.6484 34.6563 24.4671 34.7013 24.3018 34.792C24.1364 34.8826 24.0062 35.0189 23.9102 35.2002C23.8484 35.3134 23.8082 35.4467 23.7861 35.5996H25.8379C25.8271 35.3066 25.7285 35.0773 25.542 34.9121C25.3553 34.7414 25.123 34.6562 24.8457 34.6562Z"
                                    class="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M31.5 33.8721C31.8785 33.8721 32.2012 33.939 32.4678 34.0723C32.7344 34.2003 32.9375 34.3865 33.0762 34.6318C33.2201 34.8718 33.292 35.1627 33.292 35.5039V38H32.4756L32.3799 37.3525C32.3266 37.4591 32.2571 37.5579 32.1719 37.6484C32.0919 37.739 31.9982 37.8184 31.8916 37.8877C31.7849 37.9517 31.6621 38.0027 31.5234 38.04C31.3902 38.0773 31.2379 38.0957 31.0674 38.0957C30.737 38.0957 30.4627 38.0396 30.2441 37.9277C30.0256 37.8158 29.8625 37.667 29.7559 37.4805C29.6492 37.2938 29.5957 37.0907 29.5957 36.8721C29.5957 36.6161 29.6601 36.3947 29.7881 36.208C29.9214 36.0214 30.1162 35.8777 30.3721 35.7764C30.628 35.6698 30.9423 35.6162 31.3154 35.6162H32.332C32.332 35.4029 32.3028 35.2266 32.2441 35.0879C32.1855 34.944 32.0942 34.8379 31.9717 34.7686C31.8491 34.6993 31.6919 34.6641 31.5 34.6641C31.2813 34.6641 31.0941 34.7151 30.9395 34.8164C30.7851 34.9124 30.6887 35.0613 30.6514 35.2637H29.708C29.7401 34.9759 29.8362 34.7309 29.9961 34.5283C30.1561 34.3203 30.3666 34.1598 30.6279 34.0479C30.8945 33.9306 31.1854 33.8721 31.5 33.8721ZM31.4199 36.2402C31.2333 36.2402 31.0787 36.2645 30.9561 36.3125C30.8334 36.3552 30.7447 36.4186 30.6914 36.5039C30.6381 36.5892 30.6114 36.6879 30.6113 36.7998C30.6113 36.9117 30.6382 37.0079 30.6914 37.0879C30.7447 37.1679 30.8225 37.2298 30.9238 37.2725C31.0251 37.3151 31.1456 37.3359 31.2842 37.3359C31.4386 37.3359 31.5742 37.3091 31.6914 37.2559C31.8141 37.1972 31.9186 37.117 32.0039 37.0156C32.0944 36.9091 32.164 36.7919 32.2119 36.6641C32.2599 36.5361 32.2916 36.3998 32.3076 36.2559V36.2402H31.4199Z"
                                    class="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M46.4551 33.8721C46.8497 33.8721 47.194 33.9598 47.4873 34.1357C47.7805 34.3117 48.007 34.5492 48.167 34.8477C48.327 35.1409 48.4072 35.4719 48.4072 35.8398V36.0156C48.4072 36.0795 48.4022 36.1466 48.3916 36.2158H45.373C45.3847 36.4193 45.4261 36.5982 45.5029 36.752C45.5989 36.9333 45.7277 37.072 45.8877 37.168C46.053 37.2586 46.2369 37.3037 46.4395 37.3037C46.6633 37.3037 46.8473 37.2561 46.9912 37.1602C47.1405 37.0642 47.25 36.9362 47.3193 36.7764H48.2949C48.2203 37.0268 48.0982 37.2535 47.9277 37.4561C47.7571 37.6534 47.5456 37.8104 47.2949 37.9277C47.0443 38.0397 46.7618 38.0957 46.4473 38.0957C46.0473 38.0957 45.6956 38.0105 45.3916 37.8398C45.0878 37.6639 44.8503 37.4189 44.6797 37.1045C44.509 36.7898 44.4238 36.4263 44.4238 36.0156C44.4239 35.5894 44.5058 35.2163 44.6709 34.8965C44.8416 34.5765 45.0798 34.3259 45.3838 34.1445C45.693 33.9633 46.0499 33.8721 46.4551 33.8721ZM46.4473 34.6562C46.25 34.6563 46.0686 34.7013 45.9033 34.792C45.738 34.8826 45.6077 35.0189 45.5117 35.2002C45.45 35.3134 45.4097 35.4467 45.3877 35.5996H47.4395C47.4287 35.3066 47.33 35.0773 47.1436 34.9121C46.9569 34.7414 46.7246 34.6562 46.4473 34.6562Z"
                                    class="white" />
                                <path d="M28.6523 38H27.6924V32.2402H28.6523V38Z" class="white" />
                                <path
                                    d="M35.623 33.9678H36.7188V34.7764H35.623V36.6484C35.6231 36.8509 35.6657 36.9923 35.751 37.0723C35.8416 37.1467 35.9907 37.1835 36.1982 37.1836H36.6943V38H36.0068C35.735 38 35.4975 37.9573 35.2949 37.8721C35.0977 37.7868 34.943 37.6454 34.8311 37.4482C34.7191 37.251 34.6631 36.9843 34.6631 36.6484V34.7764H33.9746V33.9678H34.6631L34.7744 32.9043H35.623V33.9678Z"
                                    class="white" />
                                <path d="M38.6221 38H37.6621V33.9678H38.6221V38Z" class="white" />
                                <path
                                    d="M41.9951 33.8721C42.3203 33.8721 42.5979 33.9415 42.8271 34.0801C43.0564 34.2134 43.2328 34.4106 43.3555 34.6719C43.4835 34.9332 43.5479 35.2591 43.5479 35.6484V38H42.5879V35.7363C42.5879 35.4003 42.5126 35.1413 42.3633 34.96C42.2139 34.7787 41.9925 34.6885 41.6992 34.6885C41.5074 34.6885 41.3343 34.7336 41.1797 34.8242C41.0304 34.9148 40.91 35.0478 40.8193 35.2236C40.7341 35.3942 40.6915 35.6025 40.6914 35.8477V38H39.7314V33.9678H40.5791L40.6514 34.6396C40.774 34.4051 40.9505 34.2187 41.1797 34.0801C41.4089 33.9415 41.6807 33.8721 41.9951 33.8721Z"
                                    class="white" />
                                <path
                                    d="M38.1426 32.2002C38.3184 32.2003 38.4623 32.2538 38.5742 32.3604C38.6914 32.4616 38.75 32.5946 38.75 32.7598C38.75 32.9198 38.6915 33.056 38.5742 33.168C38.4623 33.2746 38.3184 33.328 38.1426 33.3281C37.9666 33.3281 37.8195 33.2746 37.7021 33.168C37.5902 33.056 37.5342 32.9198 37.5342 32.7598C37.5342 32.5946 37.5903 32.4616 37.7021 32.3604C37.8195 32.2537 37.9666 32.2002 38.1426 32.2002Z"
                                    class="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M35.373 23.8721C35.757 23.8721 36.1013 23.9632 36.4053 24.1445C36.7144 24.3205 36.9544 24.5654 37.125 24.8799C37.301 25.1945 37.3887 25.563 37.3887 25.9844C37.3886 26.4055 37.3009 26.7733 37.125 27.0879C36.9491 27.4025 36.7067 27.6507 36.3975 27.832C36.0935 28.008 35.7492 28.0957 35.3652 28.0957C34.9813 28.0957 34.6345 28.008 34.3252 27.832C34.0212 27.6507 33.7815 27.4026 33.6055 27.0879C33.4348 26.7679 33.3496 26.4028 33.3496 25.9922C33.3496 25.5709 33.4373 25.2024 33.6133 24.8877C33.7892 24.568 34.0293 24.3205 34.333 24.1445C34.6423 23.9632 34.9891 23.8721 35.373 23.8721ZM35.373 24.7041C35.1866 24.7041 35.0134 24.7519 34.8535 24.8477C34.6935 24.9437 34.5647 25.0883 34.4688 25.2803C34.3729 25.4669 34.3252 25.7019 34.3252 25.9844C34.3252 26.2669 34.3728 26.5044 34.4688 26.6963C34.5647 26.8881 34.6902 27.0319 34.8447 27.1279C35.0047 27.2239 35.1786 27.2725 35.3652 27.2725C35.5571 27.2724 35.7302 27.2238 35.8848 27.1279C36.0448 27.0319 36.1735 26.8883 36.2695 26.6963C36.3655 26.5044 36.4131 26.2669 36.4131 25.9844C36.4131 25.7019 36.3654 25.4669 36.2695 25.2803C36.1789 25.0883 36.0535 24.9437 35.8936 24.8477C35.7389 24.7517 35.565 24.7041 35.373 24.7041Z"
                                    class="white" />
                                <path
                                    d="M31.4307 26.4482V22.3994H32.3906V28H31.4307L28.7354 23.96V28H27.7754V22.3994H28.7354L31.4307 26.4482Z"
                                    class="white" />
                            </svg>

                        </div>
                        <h3 class="feature-title">{{ __('home.features.halal.title') }}</h3>
                        <p class="feature-description">{{ __('home.features.halal.text') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.6224 33.9948L16.1714 36.5604L20.1115 32.5579V52H9.13721C6.3001 51.9998 4.00013 49.6745 4 46.8056V29.9723H17.5822L13.6224 33.9948Z" />
                                <path
                                    d="M60 46.8056C59.9999 49.6744 57.6999 51.9998 54.8628 52H23.708V32.5743L27.572 36.5206L30.1278 33.9619L26.2202 29.9723H60V46.8056Z" />
                                <path
                                    d="M16.7789 20.3435C17.585 20.3435 18.4659 20.637 19.0741 21.332C19.8707 22.2423 20.1205 24.9631 20.0909 26.336C18.746 26.3689 16.1749 26.3325 15.1332 25.2834C14.0439 24.1861 13.7459 22.2686 14.9042 21.1017C15.4083 20.5938 16.0812 20.3435 16.7789 20.3435Z" />
                                <path
                                    d="M27.0448 20.3435C27.7425 20.3435 28.4154 20.5938 28.9196 21.1017C30.0778 22.2686 29.7798 24.1861 28.6906 25.2834C27.6488 26.3325 25.0777 26.3689 23.7328 26.336C23.7032 24.9631 23.9531 22.2423 24.7496 21.332C25.3578 20.637 26.2388 20.3435 27.0448 20.3435Z" />
                                <path
                                    d="M20.1115 12V17.6091C17.5935 16.17 14.4114 16.4596 12.3604 18.5257C10.3156 20.5858 10.0429 23.8326 11.4443 26.336H4V17.1944C4.00021 14.3257 6.30015 12.0002 9.13721 12H20.1115Z" />
                                <path
                                    d="M54.8628 12C57.6999 12.0002 59.9998 14.3257 60 17.1944V26.336H32.3743C33.7755 23.8329 33.5033 20.5859 31.4583 18.5257C29.4071 16.4597 26.2258 16.1701 23.708 17.6091V12H54.8628Z" />
                            </svg>


                        </div>
                        <h3 class="feature-title">{{ __('home.features.customized_solutions.title') }}</h3>
                        <p class="feature-description">{{ __('home.features.customized_solutions.text') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M39.0291 18.2887C39.9352 18.2887 40.6697 19.0146 40.6697 19.91V23.4981H53.088C53.7093 23.4983 54.2773 23.845 54.5552 24.3941L59.8265 34.8147C59.8286 34.8188 59.8295 34.8232 59.8317 34.8273C59.9385 35.0424 60 35.2833 60 35.5392V51.1692C60 52.0646 59.2655 52.7906 58.3594 52.7906H51.015C50.2763 55.7769 47.5474 57.9999 44.3013 58C41.055 58 38.3252 55.777 37.5867 52.7906H26.4133C25.6748 55.777 22.9452 58 19.6987 58C16.4526 57.9999 13.7237 55.7769 12.985 52.7906H5.64062C4.73457 52.7906 4.00001 52.0646 4 51.1692V29.6061C6.98517 33.5238 11.73 36.0619 17.0635 36.0619C26.0755 36.0617 33.4071 28.8159 33.4073 19.91C33.4073 19.3629 33.3793 18.822 33.3253 18.2887H39.0291ZM19.6987 47.5803C17.6966 47.5804 16.068 49.1906 16.068 51.1692C16.0681 53.1478 17.6965 54.7572 19.6987 54.7573C21.701 54.7573 23.3302 53.1478 23.3303 51.1692C23.3303 49.1905 21.7009 47.5803 19.6987 47.5803ZM44.3013 47.5803C42.2991 47.5803 40.6697 49.1905 40.6697 51.1692C40.6698 53.1478 42.299 54.7573 44.3013 54.7573C46.3034 54.7572 47.9319 53.1478 47.932 51.1692C47.932 49.1906 46.3034 47.5804 44.3013 47.5803ZM40.6697 26.7408V33.9178H55.7053L52.0737 26.7408H40.6697Z" />
                                <path
                                    d="M17.0635 14.5249C17.9694 14.5252 18.704 15.2511 18.7041 16.1463V18.2878H20.8711C21.777 18.288 22.5116 19.014 22.5117 19.9092C22.5117 20.8045 21.7771 21.5303 20.8711 21.5305H17.0635C16.1574 21.5305 15.423 20.8047 15.4229 19.9092V16.1463C15.423 15.251 16.1576 14.5249 17.0635 14.5249Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.0635 7C24.2663 7.00021 30.126 12.7911 30.1261 19.9092C30.1261 27.0273 24.2662 32.8182 17.0635 32.8184C9.86048 32.8184 4 27.0274 4 19.9092C4.00014 12.7909 9.86056 7 17.0635 7ZM17.0635 10.2427C11.6697 10.2427 7.28139 14.5789 7.28125 19.9092C7.28125 25.2394 11.6696 29.5763 17.0635 29.5765C22.4571 29.5763 26.8448 25.2393 26.8448 19.9092C26.8447 14.5791 22.4569 10.2429 17.0635 10.2427Z" />
                            </svg>

                        </div>
                        <h3 class="feature-title">{{ __('home.features.delivery.title') }}</h3>
                        <p class="feature-description">{{ __('home.features.delivery.text') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GCC Countries Section Start -->
    <!-- <div class="gcc-countries-section section hidden">
        <div class="container-fluid pt-5">
            <h2 class="section_heading center red n_m_b">
                {{ __('home.gcc_section_title') }}
            </h2>

            <p class="section_subheading center max_width h_m_b">
                {{ __('home.gcc_section_subtitle') }}
            </p>
            <div class="gcc-flags-container">
                <div class="gcc-flag-item">
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w320/ae.png" alt="UAE Flag">
                    </div>
                    <h3 class="country-name">UAE</h3>
                </div>
                <div class="gcc-flag-item">
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w320/sa.png" alt="Saudi Arabia Flag">
                    </div>
                    <h3 class="country-name">Saudi Arabia</h3>
                </div>
                <div class="gcc-flag-item">
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w320/kw.png" alt="Kuwait Flag">
                    </div>
                    <h3 class="country-name">Kuwait</h3>
                </div>
                <div class="gcc-flag-item">
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w320/qa.png" alt="Qatar Flag">
                    </div>
                    <h3 class="country-name">Qatar</h3>
                </div>
                <div class="gcc-flag-item">
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w320/bh.png" alt="Bahrain Flag">
                    </div>
                    <h3 class="country-name">Bahrain</h3>
                </div>
                <div class="gcc-flag-item">
                    <div class="flag-circle">
                        <img src="https://flagcdn.com/w320/om.png" alt="Oman Flag">
                    </div>
                    <h3 class="country-name">Oman</h3>
                </div>
            </div>
        </div>
    </div> -->
    <!-- GCC Countries Section End -->

    {{-- google review --}}
    <section class="google_review section n_p_b" style="margin-bottom: 20px;">
        <h2 class="section_heading red center">{!! __('home.loved_by_customers') !!}</h2>

        <div style="padding:0px 6px !important;max-width: 1230px; margin: auto;" class="google-review-conntainer">
            <!-- <script src="https://static.elfsight.com/platform/platform.js" async></script>
            <div class="elfsight-app-ee40795a-f343-4594-9c97-f198aaa97527" style="height:460px" data-elfsight-app-lazy>
            </div> -->
            <script src="https://elfsightcdn.com/platform.js" async></script>
            <div class="elfsight-app-b5966e63-eb25-4f04-9b6a-3c5fbaa10992" data-elfsight-app-lazy></div>
        </div>
    </section>
    {{-- Video Section: portrait (9:16) tiles, muted autoplay in view; card opens modal for sound/full controls --}}
    @if (isset($homeVideos) && $homeVideos->isNotEmpty())
        <section class="section home-page-videos" id="home-page-videos-section">
            <div class="container">
                <h2 class="section_heading red center">{{ __('home.videos.heading') }}</h2>
                <div class="home-videos-strip" role="list">
                    @foreach ($homeVideos as $hv)
                        <button type="button" class="home-videos-strip__card" role="listitem"
                            data-home-video-src="{{ asset($hv->video_path) }}"
                            data-home-video-title="{{ e($hv->displayTitle()) }}"
                            aria-label="{{ e(__('home.videos.open') . ($hv->displayTitle() !== '' ? ': ' . $hv->displayTitle() : '')) }}">
                            <span class="home-videos-strip__media">
                                <video class="home-videos-strip__preview" tabindex="-1" muted playsinline loop
                                    preload="metadata" disablepictureinpicture disableremoteplayback
                                    @if ($hv->poster_path) poster="{{ asset($hv->poster_path) }}" @endif
                                    src="{{ asset($hv->video_path) }}"></video>
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div id="homeVideoModal" class="home-videos-modal" hidden>
                <div class="home-videos-modal__backdrop" data-home-video-close tabindex="-1"></div>
                <div class="home-videos-modal__dialog" role="dialog" aria-modal="true"
                    aria-labelledby="homeVideoModalTitle">
                    <button type="button" class="home-videos-modal__close" data-home-video-close
                        aria-label="{{ __('home.videos.close') }}">&times;</button>
                    <p id="homeVideoModalTitle" class="home-videos-modal__title visually-hidden"></p>
                    <video id="homeVideoModalPlayer" class="home-videos-modal__player" controls playsinline
                        preload="metadata"></video>
                </div>
            </div>
        </section>
        <style>
            .home-page-videos { margin-bottom: 32px; }

            /* Mobile: swipeable row; desktop/tablet: grid (4 cols on wide screens) */
            .home-videos-strip {
                display: flex;
                gap: 14px;
                overflow-x: auto;
                padding: 8px 4px 16px;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
            }

            .home-videos-strip__card {
                flex: 0 0 clamp(130px, 42vw, 200px);
                scroll-snap-align: start;
                border: none;
                background: transparent;
                padding: 0;
                cursor: pointer;
                text-align: center;
                color: inherit;
            }

            @media (min-width: 600px) {
                .home-videos-strip {
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    align-items: start;
                    overflow-x: visible;
                    scroll-snap-type: none;
                }

                .home-videos-strip__card {
                    flex: none;
                    scroll-snap-align: unset;
                    min-width: 0;
                }
            }

            @media (min-width: 900px) {
                .home-videos-strip {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }

            @media (min-width: 1200px) {
                .home-videos-strip {
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                }
            }

            /* Portrait reel / Shorts ratio (matches typical phone UGC). */
            .home-videos-strip__media {
                position: relative;
                display: block;
                border-radius: 12px;
                overflow: hidden;
                aspect-ratio: 9 / 16;
                background: #111;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            }

            .home-videos-strip__media img,
            .home-videos-strip__media video {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                pointer-events: none;
            }

            .home-videos-strip__preview {
                object-position: center center;
            }

            .home-videos-modal[hidden] {
                display: none !important;
            }

            .home-videos-modal:not([hidden]) {
                display: flex;
                position: fixed;
                inset: 0;
                z-index: 9000;
                align-items: center;
                justify-content: center;
                padding: 16px;
            }

            .home-videos-modal__backdrop {
                position: absolute;
                inset: 0;
                background: rgba(0, 0, 0, 0.55);
            }

            .home-videos-modal__dialog {
                position: relative;
                z-index: 1;
                width: min(960px, 100%);
                max-height: 90vh;
                background: #000;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
            }

            .home-videos-modal__player {
                display: block;
                width: 100%;
                max-height: min(78vh, 540px);
            }

            .home-videos-modal__close {
                position: absolute;
                top: 8px;
                right: 8px;
                z-index: 2;
                width: 40px;
                height: 40px;
                border: none;
                border-radius: 8px;
                background: rgba(255, 255, 255, 0.95);
                font-size: 26px;
                line-height: 1;
                cursor: pointer;
                color: #111;
            }

            .home-videos-modal__title.visually-hidden {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                border: 0;
            }
        </style>
        <script>
            (function() {
                var root = document.getElementById('home-page-videos-section');
                if (!root) return;
                var modal = root.querySelector('#homeVideoModal');
                var player = root.querySelector('#homeVideoModalPlayer');
                var titleEl = root.querySelector('#homeVideoModalTitle');
                if (!modal || !player) return;

                var stripVideos = root.querySelectorAll('.home-videos-strip__preview');

                function tryPlay(v) {
                    v.muted = true;
                    return v.play();
                }

                function pauseAllStrips() {
                    stripVideos.forEach(function(v) {
                        try {
                            v.pause();
                        } catch (e) {}
                    });
                }

                function resumeVisibleStrips() {
                    var H = window.innerHeight || document.documentElement.clientHeight;
                    stripVideos.forEach(function(v) {
                        var r = v.getBoundingClientRect();
                        if (r.width < 1 || r.height < 1) return;
                        if (r.bottom > H * 0.04 && r.top < H * 0.96) {
                            tryPlay(v).catch(function() {});
                        }
                    });
                }

                function openModal(src, title) {
                    pauseAllStrips();
                    player.removeAttribute('src');
                    player.load();
                    player.src = src;
                    titleEl.textContent = title || '';
                    modal.hidden = false;
                    document.body.style.overflow = 'hidden';
                    player.play().catch(function() {});
                }

                function closeModal() {
                    player.pause();
                    player.removeAttribute('src');
                    player.load();
                    modal.hidden = true;
                    document.body.style.overflow = '';
                    resumeVisibleStrips();
                }

                /* Muted inline playback when scrolled into view (no tap required). */
                if (!('IntersectionObserver' in window)) {
                    stripVideos.forEach(function(v) {
                        tryPlay(v).catch(function() {});
                    });
                } else {
                    var io = new IntersectionObserver(
                        function(entries) {
                            if (!modal.hidden) return;
                            entries.forEach(function(entry) {
                                var v = entry.target;
                                if (entry.isIntersecting && entry.intersectionRatio >= 0.2) {
                                    tryPlay(v).catch(function() {});
                                } else {
                                    try {
                                        v.pause();
                                    } catch (e) {}
                                }
                            });
                        }, {
                            root: null,
                            threshold: [0, 0.1, 0.2, 0.35, 0.5, 0.75, 1],
                            rootMargin: '0px 0px -5% 0px'
                        }
                    );
                    stripVideos.forEach(function(v) {
                        io.observe(v);
                    });
                }

                root.querySelectorAll('.home-videos-strip__card').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        openModal(btn.getAttribute('data-home-video-src'), btn.getAttribute(
                            'data-home-video-title'));
                    });
                });
                modal.querySelectorAll('[data-home-video-close]').forEach(function(el) {
                    el.addEventListener('click', closeModal);
                });
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !modal.hidden) closeModal();
                });
            })();
        </script>
    @endif
    {{-- Video Section End --}}

    @foreach ($home_categories as $v)
        @php
            $searchObj = DB::table('category_conditions')
                ->where('category_id', $v->id)
                ->select('type', 'condition', 'condition_value')
                ->get();
            $pro = DB::table('products');

            if (isset($v->is_manual) && $v->is_manual == 2) {
                if ($searchObj->count() > 0) {
                    foreach ($searchObj as $key => $val) {
                        $method = $v->is_condition == 2 ? 'orWhere' : 'where';
                        if (trim($val->type) == 'Price') {
                            $pro->$method('discount_price', $val->condition, intval($val->condition_value));
                        }
                        if (trim($val->type) == 'Format') {
                            $pro->$method('format', $val->condition, intval($val->condition_value));
                        }
                        if (trim($val->type) == 'Tag') {
                            $conditionValues = explode(',', $val->condition_value);
                            $tagValues = array_map(fn($value) => str_replace(' ', '', trim($value)), $conditionValues);
                            foreach ($tagValues as $tag) {
                                $pro->$method('tags', 'LIKE', '%' . $tag . '%');
                            }
                        }
                        if (trim($val->type) == 'Title') {
                            $pro->$method('product_name', $val->condition, $val->condition_value);
                        }
                        if (trim($val->type) == 'Made in') {
                            $pro->$method('country', $val->condition, intval($val->condition_value));
                        }
                        if (trim($val->type) == 'Brand') {
                            $pro->$method('brand_id', $val->condition, intval($val->condition_value));
                        }
                        if (trim($val->type) == 'Products') {
                            if ($val->condition_value) {
                                $conditionValues = explode(',', $val->condition_value);
                                $pro->whereIn('id', $conditionValues);
                            }
                        }
                        if (trim($val->type) == 'Theme') {
                            $pro->$method('theme_id', $val->condition, intval($val->condition_value));
                        }
                        if (trim($val->type) == 'Flavour') {
                            $pro->$method('flavour_id', $val->condition, intval($val->condition_value));
                        }
                        if (trim($val->type) == 'Color') {
                            $pro->$method('product_color', $val->condition, intval($val->condition_value));
                        }
                        if (trim($val->type) == 'Allergens') {
                            $pro->$method('allergen', $val->condition, intval($val->condition_value));
                        }
                        if (trim($val->type) == 'Weight') {
                            $pro->$method('weight', $val->condition, $val->condition_value);
                        }
                    }
                }
            } else {
                $pro = $pro->whereRaw("? = ANY(string_to_array(category_id, ','))", [$v->id]);
            }

            $pro = $pro->where('status', 1)->limit(10)->get();
        @endphp

        <section class="section bg_light_red {{ !$loop->last ? 'n_p_b' : '' }}">
            <div class="container">
                <h2 class="section_heading center red n_m_b">{!! app()->getLocale() == 'ar' ? $v->name_ar : $v->name !!}
                </h2>
                <h3 class="section_subheading center">{!! app()->getLocale() == 'ar' ? $v->sub_title_ar : $v->sub_title !!}
                </h3>


                <div class="c-slider js-slider">
                    <button class="c-slider__arrow c-slider__arrow--prev" type="button" aria-label="Previous">
                        <!-- SVG injected by slider.js -->
                    </button>

                    <div class="c-slider__track js-slider-track">
                        @foreach ($pro as $k => $v1)
                            <div class="c-slider__item">
                                <x-product-card :product="$v1" />
                            </div>
                        @endforeach
                    </div>

                    <button class="c-slider__arrow c-slider__arrow--next" type="button" aria-label="Next">
                        <!-- SVG injected by slider.js -->
                    </button>
                </div>
            </div>
        </section>
    @endforeach


    {{-- <section class="section collaborate_section" style="display:none;">
        <div class="container">
            <div class="collaborate_section_wrapper" style="background: #FFE4E4;">
                <div class="row" style="display: flex; align-items: center;">
                    <div class="col-md-6">
                        <div class="collaborate_content">
                            <h2 class="section_heading red left" style="margin-bottom: 24px">
                                {{ __('home.collab.heading') }}</h2>
    <h6 class="section_subHeading">{{ __('home.collab.join') }}</h6>
    <p class="collaborative-sub-text">{{ __('home.collab.text') }}</p>

    <a class="btn btn_primary" href="{{ url('/') }}/contact-us">{{ __('home.collab.button')
                                }}</a>
    </div>
    </div>

    <div class="col-md-6">
        <div class="image_wrapper">
            <img src="{{ asset('') }}front/assets/images/yourbran.png" alt="Collaborate Image">
        </div>
    </div>
    </div>
    </div>
    </div>
    </section> --}}

    <!-- FAQ -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section_heading center red n_m_b">{{ __('retailers.faq_title') }}</h2>
            <p class="section_subheading h_m_b">{{ __('retailers.faq_subtitle') }}</p>
            @foreach ($faqs as $faq)
                <div class="faq-item">
                    <h3>{{ app()->isLocale('ar') ? $faq->question_ar : $faq->question }}</h3>
                    <div class="faq-answer">{{ app()->isLocale('ar') ? $faq->answer_ar : $faq->answer }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Trusted Retailers -->
    {{-- <section class="trusted-retailers section">
        <div class="container">
            <h2 class="heading section_heading">{!! __('home.trusted_title') !!} </h2>
            <div class="retailer-logos">
                <img src="{{ asset('front/assets/images/marabou.png') }}" alt="Noon">
    <img src="{{ asset('front/assets/images/cloetta.png') }}" alt="Deliveroo">
    <img src="{{ asset('front/assets/images/bubs.png') }}" alt="Talabat">
    <img src="{{ asset('front/assets/images/people.png') }}" alt="Careem">
    </div>
    </div>
    </section> --}}

    {{-- <div class="loader hero_section confetti-section">
        <div class="confetti-layer" style="height: 100vh"></div>
    </div> --}}

    @if ($popup)
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const overlay = document.getElementById('popupOverlay');
                const closeBtn = document.getElementById('closeBtn');

                // Show popup
                overlay.style.display = 'flex';

                // Close on overlay click (but not modal click)
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        overlay.style.display = 'none';
                    }
                });

                // Close on X click
                closeBtn.addEventListener('click', () => {
                    overlay.style.display = 'none';
                });
            });
        </script>
    @endif



@endsection
