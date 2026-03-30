@extends('layout.app')
@section('content')
    @php
        use App\Models\Admins\Setting;
        use App\Models\Faq;
        $pro = Setting::where(['id' => '1'])->first();
        $faqs = Faq::where('status', 1)->get();
    @endphp

    <x-hero-section :title="$page ? (app()->getLocale() == 'ar' ? $page->name_ar : $page->name) : __('faq.hero_title')" :backgroundImage="asset($page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png')" :subTitle="$page ? (app()->getLocale() == 'ar' ? $page->sub_title_ar : $page->sub_title) : ''" />

    <div class="outer_privacy_policy_container">
        <div class="faqs-container">
            <div class="container my-grid">
                <div class="row g-2 g-md-4">
                    <div class="col-md-4 col-6">
                        <div class="grid-item">
                            <i class="fa-solid fa-truck-fast fa-3x"></i>
                            <p>{{ __('faq.orders_and_delivery') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="grid-item">
                            <i class="fa-solid fa-rotate fa-3x"></i>
                            <p>{{ __('faq.returns_and_exchange') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="grid-item">
                            <i class="fas fa-credit-card fa-3x"></i>
                            <p>{{ __('faq.payment_methods') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="grid-item">
                            <i class="fas fa-box fa-3x"></i>
                            <p>{{ __('faq.products') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="grid-item">
                            <i class="fas fa-cogs fa-3x"></i>
                            <p>{{ __('faq.technical') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="grid-item">
                            <i class="fas fa-info-circle fa-3x"></i>
                            <p>{{ __('faq.general_information') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <section class="faq-section">
                <div class="container">
                    <h2 class="section_heading center red">{{ __('locations.faq_title') }}</h2>
                    <p class="section-subtitle">{{ __('locations.faq_subtitle') }}</p>
                    @foreach ($faqs as $faq)
                        <div class="faq-item  ">
                            <h5>{{ app()->isLocale('ar') ? $faq->question_ar : $faq->question }}</h5>
                            <div class="faq-answer">{{ app()->isLocale('ar') ? $faq->answer_ar : $faq->answer }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
    <script src="{{ asset('') }}front/Faqs.js"></script>
@endsection
