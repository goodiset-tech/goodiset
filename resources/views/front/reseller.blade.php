@extends('layout.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('front/reseller.css') }}">


    <!-- HERO SECTION -->
    <x-hero-section :title="__('reseller.hero_title')" :backgroundImage="asset('front/assets/images/faqsheroimage.png')">
        <h4 class="hero-subtitle">{{ __('reseller.hero_subtitle') }}</h4>
    </x-hero-section>

    {{-- <section class="reseller-hero"
        style="background: url('{{ asset('front/assets/images/candy-bg.webp') }}') center/cover no-repeat;">
        <div class="overlay"></div>
        <div class="container hero-content">
            <h1>{{ __('reseller.hero_title') }}</h1>
            <p>{{ __('reseller.hero_subtitle') }}</p>

            <div class="badges">
                <span><i class="fa fa-check-circle"></i> {{ __('reseller.hero_badge_halal') }}</span>
                <span><i class="fa fa-leaf"></i> {{ __('reseller.hero_badge_nongmo') }}</span>
                <span><i class="fa fa-ban"></i> {{ __('reseller.hero_badge_nored') }}</span>
                <span><i class="fa fa-language"></i> {{ __('reseller.hero_badge_labels') }}</span>
            </div>

            <div class="hero-buttons">
                <a href="#contact" class="btn btn-primary">{{ __('reseller.hero_btn_apply') }}</a>
                <a href="#" class="btn btn-outline">{{ __('reseller.hero_btn_price') }}</a>
            </div>
        </div>
    </section> --}}

    <!-- WHO THIS PROGRAM IS FOR -->
    <section class="who-for">
        <div class="container text-center">
            <h2>{{ __('reseller.who_title') }}</h2>
            <p class="subtitle">{{ __('reseller.who_subtitle') }}</p>
            <p class="subnote">{!! __('reseller.who_note') !!}</p>

            <div class="cards">
                <div class="card">
                    <div class="icon"><img src="{{ asset('front/assets/icons/distributor.svg') }}" alt=""></div>
                    <h3>{{ __('reseller.who_card_distributors') }}</h3>
                    <p>{{ __('reseller.who_card_distributors_text') }}</p>
                </div>

                <div class="card">
                    <div class="icon"><img src="{{ asset('front/assets/icons/stockist.svg') }}" alt=""></div>
                    <h3>{{ __('reseller.who_card_stockists') }}</h3>
                    <p>{{ __('reseller.who_card_stockists_text') }}</p>
                </div>

                <div class="card">
                    <div class="icon"><img src="{{ asset('front/assets/icons/corporate.svg') }}" alt=""></div>
                    <h3>{{ __('reseller.who_card_corporate') }}</h3>
                    <p>{{ __('reseller.who_card_corporate_text') }}</p>
                </div>

                <div class="card">
                    <div class="icon"><img src="{{ asset('front/assets/icons/ecommerce.svg') }}" alt=""></div>
                    <h3>{{ __('reseller.who_card_ecommerce') }}</h3>
                    <p>{{ __('reseller.who_card_ecommerce_text') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY RESELL GOODISET -->
    <section class="why-resell">
        <div class="container text-center">
            <h2>{{ __('reseller.why_title') }}</h2>
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

    <!-- PRODUCT RANGES -->
    <section class="product-ranges">
        <div class="container text-center">
            <h2>{{ __('reseller.products_title') }}</h2>
            <p class="subtitle">{{ __('reseller.products_subtitle') }}</p>

            <div class="product-grid">
                <div class="product-card">
                    <img src="{{ asset('front/assets/images/premixed.webp') }}" alt="Premixed Flavours">
                    <div class="card-content">
                        <div class="icon-title">
                            <i class="fa fa-cube"></i>
                            <h3>Premixed Flavours</h3>
                        </div>
                        <h5>Loose Candy</h5>
                        <ul>
                            <li>Gummies, sours, licorice, jelly, marshmallow, chocolate-coated</li>
                            <li>Bulk bags (refill), shelf-ready pouches, gift tubes</li>
                            <li>Halal, gelatin-free; many SKUs gluten-free</li>
                        </ul>
                    </div>
                </div>

                <div class="product-card">
                    <img src="{{ asset('front/assets/images/chocolate.webp') }}" alt="Chocolate">
                    <div class="card-content">
                        <div class="icon-title">
                            <i class="fa fa-cookie-bite"></i>
                            <h3>Chocolate</h3>
                        </div>
                        <h5>Bars & Bags</h5>
                        <ul>
                            <li>Family favourites in bars and share bags</li>
                            <li>Seasonal limited editions available</li>
                            <li>Premium Swedish quality guaranteed</li>
                        </ul>
                    </div>
                </div>

                <div class="product-card">
                    <img src="{{ asset('front/assets/images/gifting.webp') }}" alt="Gifting">
                    <div class="card-content">
                        <div class="icon-title">
                            <i class="fa fa-gift"></i>
                            <h3>Gifting</h3>
                        </div>
                        <h5>Corporate & Events</h5>
                        <ul>
                            <li>Ready-to-ship gift boxes & corporate sleeves</li>
                            <li>Custom messages for special occasions</li>
                            <li>Q4, Ramadan/Eid, Back-to-School events</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COMMERCIALS -->
    <section class="commercials">
        <div class="container text-center">
            <h2>{{ __('reseller.commercials_title') }}</h2>
            <p class="subtitle"><em>{{ __('reseller.commercials_subtitle') }}</em></p>

            <div class="commercials-grid">
                <div class="commercial-card">
                    <h3>{{ __('reseller.order_details') }}</h3>
                    <ul>
                        <li>{{ __('reseller.order_min') }}</li>
                        <li>{{ __('reseller.order_case') }}</li>
                        <li>{{ __('reseller.order_lead') }}</li>
                        <li>{{ __('reseller.order_shelf') }}</li>
                    </ul>
                </div>

                <div class="commercial-card">
                    <h3>{{ __('reseller.margins') }}</h3>
                    <ul>
                        <li>{{ __('reseller.margins_pouches') }}</li>
                        <li>{{ __('reseller.margins_gift') }}</li>
                        <li>{{ __('reseller.margins_bulk') }}</li>
                    </ul>

                    <hr>
                    <a href="#" class="btn btn-primary full-width">
                        <i class="fa fa-download"></i> {{ __('reseller.price_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-it-works">
        <div class="container text-center">
            <h2>{{ __('reseller.how_title') }}</h2>
            <p class="subtitle">{{ __('reseller.how_subtitle') }}</p>

            <div class="steps-list">
                @for ($i = 1; $i <= 6; $i++)
                    <div class="step-item">
                        <div class="step-number-reseller">{{ $i }}</div>
                        <div class="step-content">
                            <h4>{{ __('reseller.step' . $i) }}</h4>
                            <p>{{ __('reseller.step' . $i . '_text') }}</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- LOGISTICS -->
    <section class="logistics">
        <div class="container text-center">
            <h2>{{ __('reseller.logistics_title') }}</h2>

            <div class="logistics-grid">
                <div class="logistics-card">
                    <div class="icon"><i class="fa fa-truck"></i></div>
                    <h4>{{ __('reseller.logistics_delivery') }}</h4>
                    <p>{{ __('reseller.logistics_delivery_text') }}</p>
                </div>
                <div class="logistics-card">
                    <div class="icon"><i class="fa fa-cube"></i></div>
                    <h4>{{ __('reseller.logistics_collect') }}</h4>
                    <p>{{ __('reseller.logistics_collect_text') }}</p>
                </div>
                <div class="logistics-card">
                    <div class="icon"><i class="fa fa-shield-alt"></i></div>
                    <h4>{{ __('reseller.logistics_breakage') }}</h4>
                    <p>{{ __('reseller.logistics_breakage_text') }}</p>
                </div>
                <div class="logistics-card">
                    <div class="icon"><i class="fa fa-clock"></i></div>
                    <h4>{{ __('reseller.logistics_packing') }}</h4>
                    <p>{{ __('reseller.logistics_packing_text') }}</p>
                </div>
                <div class="logistics-card">
                    <div class="icon"><i class="fa fa-whatsapp"></i></div>
                    <h4>{{ __('reseller.logistics_tracking') }}</h4>
                    <p>{{ __('reseller.logistics_tracking_text') }}</p>
                </div>
                <div class="logistics-card">
                    <div class="icon"><i class="fa fa-paper-plane"></i></div>
                    <h4>{{ __('reseller.logistics_dispatch') }}</h4>
                    <p>{{ __('reseller.logistics_dispatch_text') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq">
        <div class="container text-center">
            <h2>{{ __('reseller.faq_title') }}</h2>
            <p class="subtitle">{{ __('reseller.faq_subtitle') }}</p>

            <div class="faq-list">
                @foreach ($faqs as $faq)
                    <div class="faq-item">
                        <button class="faq-question">
                            {{ app()->isLocale('ar') ? $faq->question_ar : $faq->question }}
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        <div class="faq-answer">
                            {{ app()->isLocale('ar') ? $faq->answer_ar : $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <section class="reseller-contact" id="contact">
        <div class="container text-center">
            <h2>{{ __('reseller.contact_title') }}</h2>
            <p class="subtitle">{{ __('reseller.contact_subtitle') }}</p>

            <div class="reseller-logos">
                <img src="{{ asset('front/assets/icons/carrefoutlogo.png') }}" alt="Carrefour Logo" />
                <img src="{{ asset('front/assets/icons/shellogo.svg') }}" alt="Shell Logo" />
                <img src="{{ asset('front/assets/icons/lululogo.svg') }}" alt="Lulu Logo" />
                <img src="{{ asset('front/assets/icons/almayalogo.svg') }}" alt="Al Maya Logo" />
                <img src="{{ asset('front/assets/icons/aramcologo.png') }}" alt="Aramco Logo" />
            </div>

            <form class="form reseller-form" action="{{ url('/contact-us') }}" method="POST">
                @csrf
                <input type="hidden" name="contact_type" value="Resellers">

                <div class="form-row">
                    <input type="text" name="name" placeholder="{{ __('reseller.contact_name') }}" required>
                </div>
                <div class="form-row two-cols">
                    <input type="email" name="email" placeholder="{{ __('reseller.contact_email') }}" required>
                    <input type="text" name="phone" placeholder="{{ __('reseller.contact_phone') }}" required>
                </div>
                <div class="form-row two-cols">
                    <input type="text" name="retailer_type" placeholder="{{ __('reseller.contact_type') }}" required>
                    <input type="text" name="required_kgs" placeholder="{{ __('reseller.contact_required') }}"
                        required>
                </div>
                <div class="form-row">
                    <input type="text" name="company_name" placeholder="{{ __('reseller.contact_company') }}"
                        required>
                </div>
                <div class="form-row">
                    <textarea name="meg" rows="4" placeholder="{{ __('reseller.contact_message') }}"></textarea>
                </div>

                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                <button type="submit" class="btn-red contactus-btn">{{ __('reseller.contact_btn') }}</button>
            </form>
        </div>
    </section>



    <script>
        // FAQ Accordion Toggle
        document.querySelectorAll(".faq-question").forEach(button => {
            button.addEventListener("click", () => {
                const item = button.parentElement;
                item.classList.toggle("active");
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Function to handle form submission
            function handleFormSubmit(event) {
                event.preventDefault(); // Prevent default form submission

                // Check if reCAPTCHA is completed
                let recaptchaResponse = document.querySelector(".g-recaptcha-response");
                if (!recaptchaResponse || !recaptchaResponse.value) {
                    alert("Please complete the reCAPTCHA verification.");
                    return;
                }
                let activeForm = document.querySelector(".form");

                // Validate all required fields
                let isValid = true;
                activeForm.querySelectorAll("[required]").forEach((field) => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add("error"); // Add error class to highlight the field
                        field.nextElementSibling?.classList.add(
                            "error-message"); // Show error message if available
                    } else {
                        field.classList.remove("error"); // Remove error class if field is valid
                        field.nextElementSibling?.classList.remove("error-message"); // Hide error message
                    }
                });

                // If form is valid, submit it
                if (isValid) {
                    HTMLFormElement.prototype.submit.call(activeForm);
                } else {
                    alert("Please fill in all required fields.");
                }
            }

            // Attach event listeners to all submit buttons
            document.querySelectorAll(".contactus-btn").forEach((button) => {
                button.addEventListener("click", handleFormSubmit);
            });

            // Add novalidate attribute to all forms to disable HTML5 validation
            document.querySelectorAll(".form").forEach((form) => {
                form.setAttribute("novalidate", true);
            });
        });
    </script>
@endsection
