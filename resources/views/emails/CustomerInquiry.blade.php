<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Inquiry</title>
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

        .details {
            width: 100%;
        }

        .details h4 {
            font-size: 20px;
            font-weight: 700;
            color: #000000;
            margin-bottom: 16px;
        }

        .nameandemail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .nameandemail p {
            font-size: 18px;
            font-weight: 400;
            color: #4A5566;
            margin: 0;
        }

        .b-text {
            font-weight: 600;
            text-align: right;
        }

        .hr-line {
            width: 100%;
            height: 1px;
            background-color: #E5E7EB;
            margin-bottom: 16px;
        }

        .message {
            padding: 24px;
            background: #F9F9F9;
            border-radius: 12px;
        }

        .title-message {
            font-size: 24px;
            font-weight: 500;
            color: #000000;
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 32px 0;
        }

        table td {
            padding: 16px 0;
            border-bottom: 1px solid #E5E7EB;
            text-wrap: wrap;
        }

        .email-content {
            font-size: 16px;
        }


        @media screen and (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }

            .email-content h2 {
                font-size: 24px;
            }

            .email-content {
                /* padding: 16px; */
                font-size: 16px;
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

            .b-text {
                max-width: 100px;
                overflow-wrap: break-word
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
            <h2>New Customer Inquiry</h2>
            <p>A new customer inquiry has been submitted through the Contact Us form.</p>

            <div class="details">
                <h4>Details</h4>
                <table>
                    <tr>
                        <td>Full Name</td>
                        <td class="b-text">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email Address</td>
                        <td class="b-text">{{ $user->email }} </td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td class="b-text">{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <td>Company Name</td>
                        <td class="b-text">{{ $user->company }}</td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td class="b-text">{{ $user->category }}</td>
                    </tr>
                </table>
            </div>

            <div class="message">
                <p class="title-message">Message</p>
                <p><?= $user->meg ?>
                </p>
            </div>

            <p style="font-size: 18px;">Please follow up with the customer at your earliest convenience.</p>


            <p class="name">Thank You, <br /> <span class="team">The Goodiset Team</span> </p>
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
