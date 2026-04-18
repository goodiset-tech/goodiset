@extends('layout.app')

@section('content')
<div class="section contact_us">
    <div class="container">
        <div class="contact_us_wrapper">
            <div class="row" id="login-sign-up">
                <div class="side_image col-md-6">
                </div>
                <div class="form col-md-6">
                    <form action="{{url('/')}}/user_login" method="post" id="registrationForm">
                        @csrf
                        <h1 class="section_heading left red">{{ __('login.page_title') }}</h1>
                        <div class="form_content">
                            <div class="content_outer">
                                <div class="fields">
                                    <div class="field">
                                        <label for="Email">{{ __('login.email_label') }}</label>
                                        <input type="email" name="login_email" placeholder="{{ __('login.email_placeholder') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            <button type="submit" class="login">{{ __('login.login_button') }}</button>
                            <p class="dont_have_acc">{{ __('login.no_account_message') }} <span> <a href="{{url('/')}}/user_register">{{ __('login.sign_up_link') }}</a></span></p>
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
                alert("{{ __('login.recaptcha_message') }}");
                return;
            }

            // Validate other required fields
            let isValid = true;
            activeForm.querySelectorAll("[required]").forEach((field) => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add("error"); // Add error class to highlight the field
                    field.nextElementSibling?.classList.add("error-message"); // Show error message if available
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
        document.querySelectorAll(".login").forEach((button) => {
            button.addEventListener("click", handleFormSubmit);
        });
    });
</script>
@endsection
