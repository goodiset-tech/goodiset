@extends('layout.app')
@section('content')
    @php
        use App\Models\Admins\Setting;
        $pro = Setting::where(['id' => '1'])->first();
    @endphp

    <link rel="stylesheet" href="{{ asset('front/partners.css') }}">

    <!-- ===== HERO SECTION ===== -->
    <x-hero-section :title="$page ? (app()->getLocale() == 'ar' ? $page->name_ar : $page->name) : __('locations.hero_title')" :backgroundImage="asset($page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png')" :subTitle="$page ? (app()->getLocale() == 'ar' ? $page->sub_title_ar : $page->sub_title) : ''" />

    <!-- Trusted Retailers -->
    <section class="trusted-retailer section m_p_b">
        <div class="container">
            <h2 class="heading section_heading red">{!! __('partner.trusted_title') !!} </h2>
            <div class="retailer-logo">

                <div class="retailer-item">
                    <img src="{{ asset('front/assets/images/virgin_logo.png') }}" alt="Virgin megastore">
                    <a href="https://www.virginmegastore.ae" target="_blank" class="visit-btn">Shop now</a>
                </div>

                <div class="retailer-item">
                    <img src="{{ asset('front/assets/images/noon.png') }}" alt="Noon">
                    <a href="https://minutes.noon.com/uae-en/search/?q=goodiset" target="_blank" class="visit-btn">Shop
                        now</a>
                </div>

                <div class="retailer-item">
                    <img src="{{ asset('front/assets/images/talabet.png') }}" alt="Talabat">
                    <a href="https://www.talabat.com/uae/goodiset-swedish-candy" target="_blank" class="visit-btn">Shop
                        now</a>
                </div>

                <div class="retailer-item">
                    <img src="{{ asset('front/assets/images/delivero.png') }}" alt="Deliveroo">
                    <a href="https://deliveroo.ae/menu/Dubai/festival-city/goodiset-swedish-candy-dfc?day=today&geohash=thrr7ndf22g0&time=ASAP"
                        target="_blank" class="visit-btn">Shop now</a>
                </div>

                <!-- <div class="retailer-item">
                            <img src="{{ asset('front/assets/images/amazon_now.png') }}" alt="Amazon">
                            <a href="https://www.amazon.ae/tez/browse/search?qcbrand=sAuWWBROaG&searchKeyword=goodiset"
                                target="_blank" class="visit-btn">Shop now</a>
                        </div> -->

                <div class="retailer-item">
                    <img src="{{ asset('front/assets/images/keeta_logo.png') }}" alt="Keeta">
                    <a href="https://www.keeta.com" target="_blank" class="visit-btn">Shop now</a>
                </div>



                {{-- <div class="retailer-item">
                    <img src="{{ asset('front/assets/images/careem.png') }}" alt="Careem">
                    <a href="https://www.careem.com" target="_blank" class="visit-btn">Shop now</a>
                </div> --}}



            </div>


        </div>
    </section>



    <!-- FAQ -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section_heading center red">{{ __('retailers.faq_title') }}</h2>
            <p class="section-subtitle">{{ __('retailers.faq_subtitle') }}</p>
            @foreach ($faqs as $faq)
                <div class="faq-item">
                    <h5>{{ app()->isLocale('ar') ? $faq->question_ar : $faq->question }}</h5>
                    <div class="faq-answer">{{ app()->isLocale('ar') ? $faq->answer_ar : $faq->answer }}</div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
