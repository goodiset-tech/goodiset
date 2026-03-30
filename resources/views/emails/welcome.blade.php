<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caprasimo&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "DM Sans", serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            padding: 20px;
        }

        .email-content {
            padding: 20px;
            color: #4A5566;
            font-size: 20px;
        }

        .email-content h2 {
            font-size: 36px;
            margin-bottom: 24px;
            color: #000000;
            font-weight: 400;
            margin-top: 0;
        }

        .activate-btn {
            background: #E92827;
            border: none;
            padding: 18px 32px;
            border-radius: 8px;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
        }

        .email-footer {
            text-align: left;
            font-size: 14px;
            color: #4A5566;
            padding: 20px;
            background: #FFFAFA;
        }

        .email-footer a {
            color: #E92827;
            text-decoration: none;
        }

        .social-icons {
            margin-top: 10px;
        }

        .social-icons img {
            width: 24px;
            margin: 0 5px;
            vertical-align: middle;
        }

        .team {
            font-weight: bold;
        }

        .logo-icons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 32px;
        }


        @media screen and (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }

            .email-content h2 {
                font-size: 24px;
            }

            .reset-pin {
                font-size: 24px;
                letter-spacing: 6px;
            }

            .email-footer {
                font-size: 12px;
            }

            .social-icons img {
                width: 20px;
            }

        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="{{ asset('front/assets/images/logo.png') }}" alt="" width="110px">
        </div>

        <!-- Content -->
        <div class="email-content">
            <h2>Welcome Onboard</h2>
            <p style="margin-bottom: 0px;">Hi {{ $user->name }},</p>
            <p style="margin-top: 10px;">Welcome to Goodiset! We’re excited to have you join us. To get started, please
                activate your account.

                Click the button below to confirm your email address and unlock access to your account:</p>
            {{-- <p>
                Click the button below to confirm your email address and unlock access to your account:</p> --}}

            <a href="{{ url('/') }}/login" style="text-decoration: none"> <button class="activate-btn">
                    Start Shopping
                </button></a>

            <p>We can’t wait to have you on board!</p>

            <p class="name">Cheers, <br /> <span class="team">The Goodiset Team</span> </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>This email was sent to <a href="mailto:{{ getSetting('email') }}">{{ getSetting('email') }}</a>. If you'd
                rather not
                receive this kind of email, you can <a href="#">unsubscribe</a>.</p>
            <p>© Copyright {{ date('Y') }}, All Rights Reserved by Goodest</p>


            <div class="logo-icons">
                <img src="{{ asset('front/assets/images/logo.png') }}" alt="Goodiset Logo" width="62px">
                <div class="social-icons">
                    <a href="https://www.tiktok.com/@goodiset"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="https://www.facebook.com/share/1CkAwUTTgm/?mibextid=wwXIfr"><i
                            class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.instagram.com/goodiset"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
