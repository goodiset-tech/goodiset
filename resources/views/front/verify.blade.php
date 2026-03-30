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

@section('content')
    <div class="section contact_us">
        <div class="container">
            <div class="contact_us_wrapper">
                <div class="row">
                    <div class="side_image col-md-6">
                    </div>
                    <div class="form col-md-6">
                        <form action="{{ url('/') }}/verify_login" method="post">
                            @csrf
                            <h1 class="section_heading left red">{{ __('otp.page_title') }}</h1>
                            <div class="form_content">
                                <div class="content_outer">
                                    <p style="margin-bottom: 20px;">{{ __('otp.otp_description', ['email' => $user->email]) }}</p>
                                    <div id="inputs" class="inputs" style="display: flex; gap: 10px; justify-content: center; margin-bottom: 24px;">
                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                        <input required class="input otp_input" name="value1" type="text"
                                            inputmode="numeric" maxlength="1" style="width: 50px; height: 50px; text-align: center; font-size: 24px; border: 1px solid #ddd; border-radius: 8px;" />
                                        <input required class="input otp_input" name="value2" type="text"
                                            inputmode="numeric" maxlength="1" style="width: 50px; height: 50px; text-align: center; font-size: 24px; border: 1px solid #ddd; border-radius: 8px;" />
                                        <input required class="input otp_input" name="value3" type="text"
                                            inputmode="numeric" maxlength="1" style="width: 50px; height: 50px; text-align: center; font-size: 24px; border: 1px solid #ddd; border-radius: 8px;" />
                                        <input required class="input otp_input" name="value4" type="text"
                                            inputmode="numeric" maxlength="1" style="width: 50px; height: 50px; text-align: center; font-size: 24px; border: 1px solid #ddd; border-radius: 8px;" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn_primary width_100">{{ __('otp.verify_button') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select all input fields with the class "otp_input"
        const otpInputs = document.querySelectorAll('.otp_input');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                const nextInput = otpInputs[index + 1]; // Get the next input field
                if (input.value.length === 1 && nextInput) {
                    nextInput.focus(); // Move focus to the next input
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value.length === 0) {
                    const prevInput = otpInputs[index - 1]; // Get the previous input field
                    if (prevInput) {
                        prevInput.focus(); // Move focus to the previous input
                    }
                }
            });
        });
    </script>
@endsection
