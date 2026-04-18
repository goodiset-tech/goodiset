@extends('layout.app')
<?php
use App\Models\Catagorie;
use App\Models\Subcatagorie;
use App\Models\Childcatagorie;
use App\Models\Admins\Product;
use App\Models\Gallerie;
use Illuminate\Support\Facades\Session;
use App\Models\Admins\Setting;
use App\Models\Admins\Rating;
use App\Models\Admins\Slider;
?>
<style>
    .side-img {
        background: url({{ asset('/') }}front/assets/images/Signup.jpg)
    }
</style>
@section('content')
    <div class="section contact_us">
        <div class="container">
            <div class="contact_us_wrapper">
                <div class="row" id="login-sign-up">
                    <div class="side_image col-md-6">
                    </div>
                    <div class="form col-md-6">
                        <form action="{{ url('/') }}/register" method="post" id="registrationForm">
                            @csrf
                            <h1 class="section_heading left red">{{ __('signup.page_title') }}</h1>
                            <div class="form_content">
                                <div class="content_outer">
                                    <div class="fields">
                                        <div class="field">
                                            <label for="Email">{{ __('signup.full_name_label') }}</label>
                                            <input type="text" name="name" required
                                                placeholder="{{ __('signup.full_name_label') }}">
                                        </div>
                                        <div class="field">
                                            <label for="Phone">{{ __('signup.phone_label') }}</label>
                                            <input type="text" name="phone" required
                                                placeholder="{{ __('signup.phone_label') }}">
                                        </div>
                                        <div class="field">
                                            <label for="Email">{{ __('signup.email_label') }}</label>
                                            <input type="email" name="email" required
                                                placeholder="{{ __('signup.email_placeholder') }}">
                                        </div>
                                    </div>
                                    <div class="remember">
                                        <span>
                                            <input type="checkbox" name="remember" class="fom" required id="remember">
                                            <label for="remember">{{ __('signup.terms_conditions_label') }}</label>
                                        </span>
                                        
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                </div>

                                <button type="submit" class="register">{{ __('signup.signup_button') }}</button>

                                <p class="dont_have_acc">{{ __('signup.have_account_message') }} <span><a
                                            href="{{ url('/') }}/login">{{ __('signup.login_link') }}</a></span></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function handleFormSubmit(event) {
                event.preventDefault(); // Prevent default form submission

                // Find the form
                let activeForm = document.querySelector("#registrationForm");
                if (!activeForm || !(activeForm instanceof HTMLFormElement)) {
                    alert("Form is invalid or not found.");
                    return;
                }

                // Check if reCAPTCHA is filled
                const recaptchaResponse = grecaptcha.getResponse();
                if (!recaptchaResponse) {
                    alert("{{ __('signup.recaptcha_message') }}");
                    return;
                }

                // Validate other required fields
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
                    activeForm.submit(); // Submit the form
                } else {
                    alert("Please fill in all required fields.");
                }
            }

            // Attach event listeners to all buttons with the class "register"
            document.querySelectorAll(".register").forEach((button) => {
                button.addEventListener("click", handleFormSubmit);
            });
        });
    </script>
@endsection
