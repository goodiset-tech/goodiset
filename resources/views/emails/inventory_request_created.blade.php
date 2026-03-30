<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Inventory Request</title>
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
            width: 100%;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            padding: 24px;
            text-align: center;
        }

        .email-content {
            padding: 20px;
            color: #4A5566;
            font-size: 18px;
        }

        .email-content h2 {
            font-size: 28px;
            margin-bottom: 16px;
            color: #000000;
            font-weight: 400;
            margin-top: 0;
            text-align: center;
        }

        .order-detailss {
            margin-top: 24px;
            margin-bottom: 24px;
            padding: 16px;
            background-color: #f9fafb;
            border-radius: 12px;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            flex-wrap: wrap;
        }

        .order-item img {
            width: 80px;
            height: auto;
            margin-right: 10px;
        }

        .order-name {
            font-size: 14px;
            font-weight: 600;
            color: #3b4251;
            margin-top: 5px;
        }

        .order-price {
            font-size: 14px;
            color: #8492a6;
        }

        .subtotal,
        .total {
            font-size: 16px;
            font-weight: 600;
            color: #3b4251;
            padding: 8px 0;
        }

        .email-footer {
            font-size: 14px;
            color: #4a5566;
            padding: 16px;
            background: #fffafa;
            text-align: center;
        }

        .email-footer a {
            color: #e92827;
            text-decoration: none;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .social-icons a {
            font-size: 24px;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                border-radius: 0;
                width: 100%;
                margin: 0;
            }

            .email-content {
                font-size: 16px;
                padding: 15px;
            }

            .email-content h2 {
                font-size: 22px;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
            }

            .order-item img {
                width: 60px;
            }

            .order-name,
            .order-price {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>

<body>
    <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f9f9f9">
        <tr>
            <td align="center">
                <table class="email-container" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                    <!-- Header -->
                    <tr>
                        <td class="email-header">
                            <img src="{{ asset('front/assets/images/logo.png') }}" alt="Company Logo" width="110px">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td class="email-content">
                            <h2>New Inventory Request Created</h2>
                            <p>Hello,</p>
                            <p>A new inventory request has been created with the following details:</p>

                            <div class="order-detailss">
                                <h3 style="text-align: center; font-size: 20px; color: #3b4251;">Request Details</h3>
                                <ul style="list-style: none; padding: 0;">
                                    <li><strong>Pickup Warehouse:</strong>
                                        {{ $inventoryRequest->pickupWarehouse->name }}</li>
                                    <li><strong>Dropoff Warehouse:</strong>
                                        {{ $inventoryRequest->dropoffWarehouse->name }}</li>
                                    <li><strong>Status:</strong> {{ $inventoryRequest->status }}</li>
                                </ul>

                                <h3 style="text-align: center; font-size: 20px; color: #3b4251; margin-top: 20px;">
                                    Requested Products</h3>
                                <table width="100%" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left; padding: 8px 0;">Product</th>
                                            {{-- <th style="text-align: left; padding: 8px 0;">Item Number</th>
                                            <th style="text-align: left; padding: 8px 0;">Barcode</th>
                                            <th style="text-align: left; padding: 8px 0;">Original Name</th>
                                            <th style="text-align: left; padding: 8px 0;">Article Number</th>
                                            <th style="text-align: left; padding: 8px 0;">Sku</th> --}}
                                            <th style="text-align: left; padding: 8px 0;">Quantity</th>
                                            <th style="text-align: left; padding: 8px 0;">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventoryRequest->items as $item)
                                            <tr class="">
                                                <td style="padding: 8px 0;">{{ $item->product->product_name }}</td>
                                                {{-- <td style="padding: 8px 0;">{{ $item->product->sku }}</td>
                                                <td style="padding: 8px 0;">{{ $item->product->product_code }}</td>
                                                <td style="padding: 8px 0;">{{ $item->product->orignal_name }}</td>
                                                <td style="padding: 8px 0;">{{ $item->product->article_number }}</td>
                                                <td style="padding: 8px 0;">{{ $item->product->sku_no }}</td> --}}
                                                <td style="padding: 8px 0;">{{ $item->quantity }}</td>
                                                <td style="padding: 8px 0;">{{ $item->unit }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <p>Please review the request and take appropriate action.</p>

                            <p>Thank you,<br>The {{ getSetting('site_title') }} Team</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            <p>This email was sent to you as part of your {{ getSetting('site_title') }} account.</p>
                            <p>{{ getSetting('site_title') }} © {{ date('Y') }}, All rights reserved.</p>
                            <div class="social-icons">
                                <a href="https://www.facebook.com/yourpage">
                                    <img src="https://goodiset.com/facebook.png" alt="Facebook" style="width: 24px;">
                                </a>
                                <a href="https://www.instagram.com/yourpage">
                                    <img src="https://goodiset.com/instagram.png" alt="Instagram" style="width: 24px;">
                                </a>
                                <a href="https://www.tiktok.com/@yourpage">
                                    <img src="https://goodiset.com/tiktok.png" alt="TikTok" style="width: 24px;">
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
