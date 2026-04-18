@extends('layout.app')
@section('content')
    @php
        use App\Models\Admins\Setting;
        $pro = Setting::where(['id' => '1'])->first();
    @endphp

    <!-- ===== HERO SECTION WITH CONFETTI ===== -->
    <x-hero-section :title="isset($page->name) ? (app()->isLocale('ar') ? $page->name_ar : $page->name) : 'Corporate Events'" :backgroundImage="asset($page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png')" :subTitle="$page ? (app()->getLocale() == 'ar' ? $page->sub_title_ar : $page->sub_title) : ''" />

    <!-- PREMIUM PRODUCT LINEUP -->
    <section class="product-lineup section">
        <div class="container">
            <h2 class="section_heading center red n_m_b">
                {{ __('corporate.product_lineup.title') }}
            </h2>

            <p class="section_subheading center max_width h_m_b">
                {{ __('corporate.product_lineup.description') }}
            </p>

            <div class="row">
                <div class="col-md-6 " style="margin-bottom: 24px;">
                    <div class="product-categories lineup-list">
                        <h3 class="lineup-list-title">{{ __('corporate.categories.title') }}</h3>

                        <ul class="lineup-list-content">
                            <li class="lineup-list-item">{{ __('corporate.categories.gummies') }}</li>
                            <li class="lineup-list-item">{{ __('corporate.categories.licorice') }}</li>
                            <li class="lineup-list-item">{{ __('corporate.categories.chocolate') }}</li>
                            <li class="lineup-list-item">{{ __('corporate.categories.mixes') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6 " style="margin-bottom: 24px;">
                    <div class="product-usp lineup-list">
                        <h3 class="lineup-list-title">{{ __('corporate.usp.title') }}</h3>

                        <ul class="lineup-list-content">
                            <li class="lineup-list-item">{{ __('corporate.usp.point1') }}</li>
                            <li class="lineup-list-item">{{ __('corporate.usp.point2') }}</li>
                            <li class="lineup-list-item">{{ __('corporate.usp.point3') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- WE ARE READY -->
    <section class="we-are-ready section">
        <div class="container">
            <h2 class="section_heading center red n_m_b">
                {{ __('corporate.ready.title') }}
            </h2>

            <p class="section_subheading center max_width h_m_b">
                {{ __('corporate.ready.subtitle') }}
            </p>

            <div class="row feature-cards">

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M34 26C38.4183 26 42 29.5817 42 34C42 38.4183 38.4183 42 34 42C30.2723 42 27.14 39.4505 26.252 36H10C8.89543 36 8 35.1046 8 34C8 32.8954 8.89543 32 10 32H26.252C27.14 28.5495 30.2723 26 34 26ZM34 30C31.7909 30 30 31.7909 30 34C30 36.2091 31.7909 38 34 38C36.2091 38 38 36.2091 38 34C38 31.7909 36.2091 30 34 30Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14 6C17.7335 6 20.8686 8.55788 21.751 12.0166C21.8326 12.0065 21.9156 12 22 12H40C41.1046 12 42 12.8954 42 14C42 15.1046 41.1046 16 40 16H22C21.9156 16 21.8326 15.9926 21.751 15.9824C20.8689 19.4416 17.7339 22 14 22C9.58172 22 6 18.4183 6 14C6 9.58172 9.58172 6 14 6ZM14 10C11.7909 10 10 11.7909 10 14C10 16.2091 11.7909 18 14 18C16.2091 18 18 16.2091 18 14C18 11.7909 16.2091 10 14 10Z" />
                            </svg>

                        </div>
                        <h4 class="feature-title">{{ __('corporate.ready.feature1.title') }}</h4>
                        <p class="feature-description">{{ __('corporate.ready.feature1.desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M31.9566 12.8628C31.9121 12.3973 31.5437 12.0289 31.0783 11.9844C30.8175 11.9595 24.6503 11.4154 21.0589 15.0068C20.2802 15.7855 19.6962 16.6854 19.2588 17.6198C18.5386 14.6708 17.2576 12.2241 15.4989 10.4655C13.3314 8.29796 10.1188 6.85583 6.20851 6.29514C3.29901 5.87789 1.03345 6.08633 0.938447 6.09552C0.473009 6.14002 0.104572 6.50846 0.0600717 6.97389C0.0509467 7.06889 -0.157491 9.33439 0.259697 12.244C0.820384 16.1542 2.26245 19.3669 4.43007 21.5344C6.59763 23.702 9.81026 25.1441 13.7205 25.7048C15.1606 25.9113 16.4426 25.9645 17.3819 25.9645C18.2332 25.9644 19.4738 25.9478 20.0449 25.9478C22.0423 25.9478 26.2226 25.5938 28.9343 22.882C32.5256 19.2908 31.9816 13.1236 31.9566 12.8628ZM10.6543 15.3101C10.2734 14.9292 9.65563 14.9292 9.27457 15.3101C8.89357 15.6911 8.89357 16.3088 9.27457 16.6899L16.5822 23.9975C13.7664 23.9026 8.90907 23.2541 5.80976 20.1548C2.11613 16.4611 1.90676 10.2383 1.9617 7.99602C4.20407 7.93752 10.4165 8.14258 14.1193 11.8453C17.2096 14.9357 17.8608 19.796 17.9589 22.6148L10.6543 15.3101ZM27.5546 21.5024C25.8348 23.2221 23.2474 23.7726 21.3881 23.9327L25.6864 19.6343C26.0674 19.2533 26.0674 18.6356 25.6864 18.2545C25.3055 17.8736 24.6878 17.8736 24.3067 18.2545L20.0045 22.5567C20.1622 20.6998 20.7111 18.114 22.4386 16.3865C24.6768 14.1482 28.3843 13.89 30.0446 13.8963C30.0506 15.5566 29.7924 19.2645 27.5546 21.5024Z" />
                            </svg>
                        </div>
                        <h4 class="feature-title">{{ __('corporate.ready.feature2.title') }}</h4>
                        <p class="feature-description">{{ __('corporate.ready.feature2.desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24.0001 2C24.7613 2 25.4561 2.43263 25.793 3.11523L31.5079 14.6924L44.2891 16.5605C45.0421 16.6706 45.6676 17.199 45.9024 17.9229C46.1371 18.6468 45.9408 19.4416 45.3956 19.9727L36.1485 28.9785L38.3311 41.7021C38.4597 42.4525 38.1511 43.2108 37.5352 43.6582C36.9193 44.1055 36.1025 44.1649 35.4288 43.8105L24.0001 37.7998L12.5713 43.8105C11.8976 44.1649 11.0808 44.1055 10.4649 43.6582C9.849 43.2108 9.5404 42.4525 9.669 41.7021L11.8506 28.9785L2.60455 19.9727C2.05935 19.4416 1.86297 18.6468 2.09771 17.9229C2.33255 17.199 2.95798 16.6706 3.711 16.5605L16.4913 14.6924L22.2071 3.11523L22.2735 2.98926C22.6303 2.37943 23.2865 2 24.0001 2ZM19.6133 17.4053C19.3223 17.9949 18.7601 18.4039 18.1094 18.499L8.29596 19.9326L15.3956 26.8477C15.8672 27.3071 16.083 27.9692 15.9717 28.6182L14.296 38.3828L23.0694 33.7695L23.1797 33.7158C23.7384 33.4645 24.3845 33.4824 24.9307 33.7695L33.7032 38.3828L32.0284 28.6182C31.9171 27.9692 32.1329 27.3071 32.6046 26.8477L39.7032 19.9326L29.8907 18.499C29.24 18.4039 28.6779 17.9949 28.3868 17.4053L24.0001 8.5166L19.6133 17.4053Z" />
                            </svg>
                        </div>
                        <h4 class="feature-title">{{ __('corporate.ready.feature3.title') }}</h4>
                        <p class="feature-description">{{ __('corporate.ready.feature3.desc') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- CUSTOMISED SECTION -->
    <section class="customised-section section">
        <div class="container">
            <h2 class="section_heading center red">
                {{ __('corporate.customised.title') }}
            </h2>

            <p class="section_subheading center max_width h_m_b">
                {{ __('corporate.customised.subtitle') }}
            </p>

            <div class="gallery-grid">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="gallery-item"><img src="{{ asset('front/assets/images/cop' . $i . '.webp') }}"></div>
                @endfor
            </div>
        </div>
    </section>


    <!-- CONTACT FORM -->
    <section class="reseller-contact">
        <div class="container text-center">

            <h2 class="section_heading center red">
                {{ __('corporate.contact.title') }}
            </h2>

            <p class="subtitle">{{ __('corporate.contact.subtitle') }}</p>

            <form class="form reseller-form" action="{{ url('/contact-us') }}" method="POST" id="contact">
                @csrf
                <input type="hidden" name="contact_type" value="corporate_events">

                <div class="form-row">
                    <input type="text" name="name" placeholder="{{ __('corporate.contact.name') }}" required>
                </div>

                <div class="form-row two-cols">
                    <input type="email" name="email" placeholder="{{ __('corporate.contact.email') }}" required>
                    <input type="text" name="phone" placeholder="{{ __('corporate.contact.phone') }}" required>
                </div>

                <div class="form-row two-cols">
                    <input type="text" name="retailer_type" placeholder="{{ __('corporate.contact.type') }}" required>
                    <input type="text" name="required_kgs" placeholder="{{ __('corporate.contact.required') }}"
                        required>
                </div>

                <div class="form-row two-fields two-cols">
                    <div class="field">
                        <input type="text" name="company_name" placeholder="{{ __('corporate.contact.company') }}"
                            required>
                    </div>
                </div>

                <div class="form-row">
                    <textarea name="meg" rows="4" placeholder="{{ __('corporate.contact.message') }}"></textarea>
                </div>

                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

                <button type="submit" class="btn-red contactus-btn">
                    {{ __('corporate.contact.btn') }}
                </button>
            </form>
        </div>
    </section>


    <!-- FAQ -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section_heading center red">
                {{ __('corporate.faq.title') }}
            </h2>

            <p class="section-subtitle">
                {{ __('corporate.faq.subtitle') }}
            </p>

            @foreach ($faqs as $faq)
                <div class="faq-item">
                    <h5>{{ app()->isLocale('ar') ? $faq->question_ar : $faq->question }}</h5>
                    <div class="faq-answer">{{ app()->isLocale('ar') ? $faq->answer_ar : $faq->answer }}</div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
