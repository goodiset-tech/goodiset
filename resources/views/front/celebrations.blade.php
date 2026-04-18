@extends('layout.app')
<?php
use Illuminate\Support\Facades\Session;
$cate = DB::table('categories')->get();
?>
@section('content')
    <div class="main-container">

        <x-hero-section :title="__('celebration.hero_title')" :backgroundImage="asset('front/assets/images/faqsheroimage.png')" />

        <!-- POPULAR CELEBRATIONS -->
        <div class="limited-container celebration_container">
            <h1 class="section_heading red">{{ __('celebration.popular_title') }}</h1>
            <div class="row cards mb" style="margin: 0 auto;">
                @foreach ($theme as $v)
                    <div class="celebration_card col-md-3 col-sm-6 col-12"
                        style="background: url({{ $v->image ? asset($v->image) : asset('images/christmas-decoration-candies.png') }});">
                        <h1>{{ $v->name }}</h1>
                        <p>{{ __('celebration.popular_subtitle') }}</p>
                        <button>
                            <a href="{{ url('/') }}/celebration/{{ $v->slug }}">
                                {{ __('celebration.shop_button', ['name' => $v->name]) }}
                            </a>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- DISCOVER EVENTS -->
        <div class="limited-container celebration_container">
            <h1 class="section_heading red">{{ __('celebration.discover_title') }}</h1>
            <div class="row cards mb">
                @foreach ($theme as $v)
                    <div class="event_card col-md-3 col-sm-6 col-12"
                        style="background: url({{ $v->image ? asset($v->image) : asset('images/christmas-decoration-candies.png') }});">
                        <a href="{{ url('/') }}/celebration/{{ $v->slug }}">
                            <h1>{{ $v->name }}</h1>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- CONTACT FORM -->
        <div class="celebration_outer_form">
            {{-- <img src="{{ asset('') }}front/assets/images/star_red_full.png" alt="" class="star">
            <img src="{{ asset('') }}front/assets/images/star_red_full.png" class="star2" alt=""> --}}
            <div class="celebration_form">
                <div class="form contect_us_form"
                    style="max-width: 636px;width: 100%; background: transparent; margin: 0 auto;">

                    <!-- ORGANIZER FORM -->
                    <form action="{{ url('/') }}/contact-us" method="post" id="event-organizer">
                        @csrf
                        <h1 class="section_heading red">{{ __('celebration.form_title') }}</h1>

                        {{-- <div class="checkboxs">
                            <div class="checkbox">
                                <input type="radio" name="form-toggle" id="isOrgnizer" value="organizer" checked>
                                <label for="isOrgnizer">{{ __('celebration.organizer_option') }}</label>
                            </div>
                            <div class="checkbox">
                                <input type="radio" name="form-toggle" id="isHost" value="event">
                                <label for="isHost">{{ __('celebration.host_option') }}</label>
                            </div>
                        </div> --}}

                        <div id="organizer" class="fields event-organizers active">
                            <div class="field">
                                {{-- <label for="name">{{ __('celebration.field_fullname') }}</label> --}}
                                <input type="hidden" name="contact_type" value="Event Organizer">
                                <input required type="text" name="name" id="name"
                                    placeholder="{{ __('celebration.field_fullname') }}">
                            </div>

                            <div class="two-fields">
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_email') }}</label> --}}
                                    <input required type="email" name="email" id="email"
                                        placeholder="{{ __('celebration.field_email') }}">
                                </div>
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_phone') }}</label> --}}
                                    <input required type="text" name="phone" id="phone"
                                        placeholder="{{ __('celebration.field_phone') }}">
                                </div>
                            </div>

                            <div class="two-fields">
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_org_name') }}</label> --}}
                                    <input required type="text" name="organization_name" id="Companyname"
                                        placeholder="{{ __('celebration.field_org_name') }}">
                                </div>
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_event_location') }}</label> --}}
                                    <input required type="text" name="event_location" id="event_location"
                                        placeholder="{{ __('celebration.field_event_location') }}">
                                </div>
                            </div>

                            <div class="two-fields">
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_event_type') }}</label> --}}
                                    <select required name="event_type" id="event_type">
                                        <option value="">{{ __('celebration.select_placeholder') }}</option>
                                        <option value="Corporate">{{ __('celebration.option_corporate') }}</option>
                                        <option value="Wedding">{{ __('celebration.option_wedding') }}</option>
                                        <option value="Festival">{{ __('celebration.option_festival') }}</option>
                                    </select>
                                </div>
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_attendance') }}</label> --}}
                                    <select required name="estimated_attendance" id="est_att">
                                        <option value="">{{ __('celebration.select_placeholder') }}</option>
                                        <option value="50-100">50–100</option>
                                        <option value="100-200">100–200</option>
                                        <option value="200-400">200–400</option>
                                        <option value="400-600">400–600</option>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                {{-- <label>{{ __('celebration.field_product_type') }}</label> --}}
                                <select required name="preferred_product_types" id="kilos">
                                    <option value="">{{ __('celebration.select_placeholder') }}</option>
                                    <option value="Candy Stands">{{ __('celebration.option_candy_stands') }}</option>
                                    <option value="Candy Buffets">{{ __('celebration.option_candy_buffets') }}</option>
                                    <option value="Small Giveaways">{{ __('celebration.option_small_giveaways') }}
                                    </option>
                                    <option value="Gift Bags">{{ __('celebration.option_gift_bags') }}</option>
                                    <option value="Other">{{ __('celebration.option_other') }}</option>
                                </select>
                            </div>

                            <div class="field">
                                {{-- <label>{{ __('celebration.field_message') }}</label> --}}
                                <textarea name="meg" id="msg" required placeholder="{{ __('celebration.field_message') }}" rows="5"></textarea>
                            </div>
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

                            <button class="contactus-btn" type="submit" value="submit" name="submit">
                                {{ __('celebration.contact_button') }}
                            </button>
                        </div>
                    </form>

                    <!-- EVENT HOST FORM -->
                    <form action="{{ url('/') }}/contact-us" method="post" id="event-host" class="form">
                        @csrf
                        <div id="event" class="fields event-organizers">
                            <div class="field">
                                {{-- <label>{{ __('celebration.field_fullname') }}</label> --}}
                                <input type="hidden" name="contact_type" value="Event Host">
                                <input required type="text" name="name"
                                    placeholder="{{ __('celebration.field_fullname') }}">
                            </div>

                            <div class="two-fields">
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_email') }}</label> --}}
                                    <input required type="email" name="email"
                                        placeholder="{{ __('celebration.field_email') }}">
                                </div>
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_phone') }}</label> --}}
                                    <input required type="text" name="phone"
                                        placeholder="{{ __('celebration.field_phone') }}">
                                </div>
                            </div>

                            <div class="two-fields">
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_event_location') }}</label> --}}
                                    <input type="text" name="event_location" required
                                        placeholder="{{ __('celebration.field_event_location') }}">
                                </div>
                                <div class="field">
                                    {{-- <label>{{ __('celebration.field_event_type') }}</label> --}}
                                    <select required name="estimated_attendance">
                                        <option value="">{{ __('celebration.select_placeholder') }}</option>
                                        <option value="Corporate">{{ __('celebration.option_corporate') }}</option>
                                        <option value="Wedding">{{ __('celebration.option_wedding') }}</option>
                                        <option value="Festival">{{ __('celebration.option_festival') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                {{-- <label>{{ __('celebration.field_attendance') }}</label> --}}
                                <select name="kilos" required>
                                    <option value="">{{ __('celebration.select_placeholder') }}</option>
                                    <option value="50-100">50–100</option>
                                    <option value="100-200">100–200</option>
                                    <option value="200-400">200–400</option>
                                    <option value="400-600">400–600</option>
                                </select>
                            </div>

                            <div class="field">
                                {{-- <label>{{ __('celebration.field_message') }}</label> --}}
                                <textarea name="meg" required placeholder="{{ __('celebration.field_message') }}" rows="5"></textarea>
                            </div>

                            <button class="contactus-btn" type="submit" value="submit" name="submit">
                                {{ __('celebration.contact_button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <section class="faq-section">
            <div class="container">
                <h2 class="section_heading red">{{ __('celebration.faq_title') }}</h2>
                <p class="section-subtitle">{{ __('celebration.faq_subtitle') }}</p>

                @foreach ($faqs as $faq)
                    <div class="faq-item">
                        <h5>{{ app()->isLocale('ar') ? $faq->question_ar : $faq->question }}</h5>
                        <div class="faq-answer">{{ app()->isLocale('ar') ? $faq->answer_ar : $faq->answer }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>


    <script src="{{ asset('') }}front/Becomepartner.js"></script>
    <script>
        document.querySelectorAll('.faq-item').forEach(item => {
            item.addEventListener('click', () => item.classList.toggle('active'));
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
