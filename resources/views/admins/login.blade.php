<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{ asset('') }}front/assets/sass/bootstrap.min.css">
    <link href="{{ asset('backend_assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('backend_assets/css/animate.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('backend_assets/css/style.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('front/assets/sass/main.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

</head>

<body>


    <div class="section contact_us">
        <div class="container">
            <div class="contact_us_wrapper">
                <div class="row" id="login-sign-up">
                    <div class="side_image col-md-6">
                    </div>
                    <div class="form col-md-6">
                        <form action="{{ url('/') }}/admin/login" method="post">
                            @csrf
                            @if (session('invalid'))
                                <div class="alert alert-danger mt-1 alert-validation-msg" role="alert"
                                    style="padding: 8px;margin:0px;position:absolute; top: 10px; left: 50%; transform : translate(-50%, 0%); width: 96%;">
                                    <i class="feather icon-info mr-1 align-middle"></i>
                                    <span>{{ session('invalid') }}</span>
                                </div>
                            @endif
                            <div class="form_content">
                                <div class="content_outer">
                                    <div class="fields">
                                        <div class="form-group field">
                                            <label for="Email">Email</label>
                                            <input type="email" class="" name="email" placeholder="Username"
                                                required="">
                                        </div>
                                        <div class="form-group field">
                                            <label for="Email">Password</label>
                                            <input type="password" name="password" class="" placeholder="Password"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                <button type="submit" class="login">{{ __('login.login_button') }}</button>
                                <p class="dont_have_acc">{{ __('login.no_account_message') }} <span> <a
                                            href="{{ url('/') }}/user_register">{{ __('login.sign_up_link') }}</a></span>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





</html>
