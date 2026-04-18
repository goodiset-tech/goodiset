@extends('layout.app')
@section('content')
    @php
        use App\Models\Admins\Setting;
        $pro = Setting::where(['id' => '1'])->first();
    @endphp

    <link rel="stylesheet" href="{{ asset('front/retailers.css') }}">

    <!-- HERO -->

    <x-hero-section :title="isset($page) ? (app()->getLocale() == 'ar' ? $page->name_ar : $page->name) : __('retailers.hero_title')" :backgroundImage="asset($page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png')" :subTitle="isset($page) ? (app()->getLocale() == 'ar' ? $page->sub_title_ar : $page->sub_title) : ''" />

    <!-- SEE IT IN ACTION -->
    <section class="see-it-section">
        <div class="container">
            <h2 class="section_heading center red n_m_b">{{ __('retailers.see_title') }}</h2>
            <p class="section_subheading center">{{ __('retailers.see_subtitle') }}</p>
            <div class="row">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="col-md-3">
                        <div class="gallery-item"><img src="{{ asset('front/assets/images/see' . $i . '.webp') }}"></div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section_heading center red n_m_b">{{ __('retailers.how_title') }}</h2>
            <p class="section_subheading center">{{ __('retailers.how_subtitle') }}</p>

            <div class="steps-grid">
                <div class="step-box">
                    <div class="step-num">1</div>
                    <h4>{{ __('retailers.how_1_title') }}</h4>
                    <p>{{ __('retailers.how_1_text') }}</p>
                </div>
                <div class="step-box">
                    <div class="step-num">2</div>
                    <h4>{{ __('retailers.how_2_title') }}</h4>
                    <p>{{ __('retailers.how_2_text') }}</p>
                </div>
                <div class="step-box">
                    <div class="step-num">3</div>
                    <h4>{{ __('retailers.how_3_title') }}</h4>
                    <p>{{ __('retailers.how_3_text') }}</p>
                </div>
                <div class="step-box">
                    <div class="step-num">4</div>
                    <h4>{{ __('retailers.how_4_title') }}</h4>
                    <p>{{ __('retailers.how_4_text') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Reselller Section -->


    <!-- WHY RESELL GOODISET -->
    <section class="why-resell">
        <div class="container text-center">
            <h2 class="section_heading center red n_m_b">{{ __('reseller.why_title') }}</h2>
            <p class="subtitle">{{ __('reseller.why_subtitle') }}</p>

            <div class="why-grid">
                <div class="why-item">
                    <div class="circle-icon"><i class="fa fa-award"></i></div>
                    <h4>{{ __('reseller.why_inclusive') }}</h4>
                    <p>{{ __('reseller.why_inclusive_text') }}</p>
                </div>

                <div class="why-item">
                    <div class="circle-icon"><i class="fa fa-chart-line"></i></div>
                    <h4>{{ __('reseller.why_demand') }}</h4>
                    <p>{{ __('reseller.why_demand_text') }}</p>
                </div>

                <div class="why-item">
                    <div class="circle-icon"><i class="fa fa-truck"></i></div>
                    <h4>{{ __('reseller.why_supply') }}</h4>
                    <p>{{ __('reseller.why_supply_text') }}</p>
                </div>

                <div class="why-item">
                    <div class="circle-icon"><i class="fa fa-file-alt"></i></div>
                    <h4>{{ __('reseller.why_label') }}</h4>
                    <p>{{ __('reseller.why_label_text') }}</p>
                </div>

                <div class="why-item">
                    <div class="circle-icon"><i class="fa fa-bullhorn"></i></div>
                    <h4>{{ __('reseller.why_marketing') }}</h4>
                    <p>{{ __('reseller.why_marketing_text') }}</p>
                </div>

                <div class="why-item">
                    <div class="circle-icon"><i class="fa fa-dollar-sign"></i></div>
                    <h4>{{ __('reseller.why_economics') }}</h4>
                    <p>{{ __('reseller.why_economics_text') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Reseller Section -->

    <!-- RETAILER CONTACT SECTION -->
    <section class="reseller-contact">
        <div class="container text-center">
            <h2 class="section_heading center red n_m_b">{{ __('retailers.contact_title') }}</h2>
            <p class="subtitle">{{ __('retailers.contact_subtitle') }}</p>

            <form class="form reseller-form" action="{{ url('/contact-us') }}" method="POST" id="contact">
                @csrf
                <div class="form-row">
                    <input type="text" name="name" placeholder="{{ __('retailers.contact_name') }}" required>
                </div>

                <div class="form-row two-cols">
                    <input type="email" name="email" placeholder="{{ __('retailers.contact_email') }}" required>
                    <input type="text" name="phone" placeholder="{{ __('retailers.contact_phone') }}" required>
                </div>

                <div class="form-row two-cols">
                    <input type="text" name="retailer_type" placeholder="{{ __('retailers.contact_type') }}" required>
                    <input type="text" name="required_kgs" placeholder="{{ __('retailers.contact_required') }}"
                        required>
                </div>
                <div class="form-row two-fields two-cols">
                    <div class="field">
                        <select name="contact_type" id="" required>
                            <option value="">{{ __('contact_select_type') }}</option>
                            <option value="Retailers">{{ __('Retailers') }}</option>
                            <option value="Resellers">{{ __('Resellers') }}</option>
                        </select>
                    </div>
                    <div class="field">
                        <input type="text" name="company_name" placeholder="{{ __('retailers.contact_company') }}"
                            required>
                    </div>
                </div>

                <div class="form-row">
                    <textarea name="meg" rows="4" placeholder="{{ __('retailers.contact_message') }}"></textarea>
                </div>

                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                <button type="submit" class="btn-red contactus-btn">{{ __('retailers.contact_btn') }}</button>
            </form>
        </div>
    </section>


    <!-- FAQ -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section_heading center red n_m_b">{{ __('retailers.faq_title') }}</h2>
            <p class="section_subheading center">{{ __('retailers.faq_subtitle') }}</p>
            @foreach ($faqs as $faq)
                <div class="faq-item">
                    <h5>{{ app()->isLocale('ar') ? $faq->question_ar : $faq->question }}</h5>
                    <div class="faq-answer">{{ app()->isLocale('ar') ? $faq->answer_ar : $faq->answer }}</div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
