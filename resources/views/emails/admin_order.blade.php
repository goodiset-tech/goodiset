<?php
use App\Models\Admins\Product;
use App\Models\BoxCustomize;
use App\Models\BoxSize;
use App\Models\PackageType;
use App\Models\Customer;
use App\Models\Admins\Order;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
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

        .email-content h6 {
            font-size: 20px;
            margin-bottom: 16px;
            color: #000000;
            font-weight: 400;
            margin-top: 0;
            text-align: center;
        }


        .activate-btn {
            display: inline-block;
            background: #e92827;
            padding: 12px 24px;
            border-radius: 8px;
            color: #ffffff !important;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            margin: 16px auto;
            display: block;
            width: fit-content;
        }

        .order-detailss {
            margin-top: 24px;
            margin-bottom: 24px;
            padding: 16px;
            background-color: #f9fafb;
            border-radius: 12px;
        }

        .order-number {
            font-size: 18px;
            font-weight: 600;
            color: #3b4251;
            text-align: center;
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

            .activate-btn {
                font-size: 14px;
                padding: 10px 20px;
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
    <?php foreach ($order as $edit) {?>
    <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f9f9f9">
        <tr>
            <td align="center">
                <table class="email-container" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                    <!-- Header -->
                    <tr>
                        <td class="email-header">
                            <img src="{{ asset('front/assets/images/logo.png') }}" alt="Goodiset Logo" width="110px">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td class="email-content">
                            <?php
                            $customer = Customer::where('email', $edit->email)->first();
                            $orderCount = Order::where('email', $edit->email)->count();
                            $customerStatus = $orderCount > 1 ? 'Returning Customer' : 'New Customer';
                            ?>
                            <h2>New Order Received</h2>
                            <h6>{{ $customerStatus }}</h6>

                            <p>Hello Admin,</p>
                            <p>A new order <strong>#{{ $edit->order_no }}</strong> has been received from
                                {{ $edit->customer_name }}.</p>
                            <?php
                            $customer = Customer::where('email', $edit->email)->first();
                            $orderCount = Order::where('email', $edit->email)->count();
                            $customerStatus = $orderCount > 1 ? 'Returning Customer' : 'New Customer';
                            ?>
                            {{-- <p><strong>Customer Status:</strong> {{ $customerStatus }}</p> --}}
                            {{-- <p><strong>Estimated Turnaround Time:</strong><br>
                                <span style="color: #e92827;">{{ get_shipping_time($edit->city, $edit->country) }}</span>.
                            </p> --}}

                            <a href="{{ url('/') }}/thanks/{{ $edit->encrypted_order_no }}"
                                class="activate-btn">View or
                                Manage Order</a>

                            <div class="order-detailss">
                                <h3 class="order-number">Order #{{ $edit->order_no }}</h3>

                                <!-- Order Item -->
                                <table width="100%" cellspacing="0" cellpadding="0">
                                    <?php
                                        $pro = json_decode($edit->product_detail);
                                        $no = 1;
                                        foreach ($pro as $v) {
                                            if ($v->id != null) {
                                                $product = Product::where(['id' => $v->id])->first();
                                    ?>
                                    <tr class="order-item">
                                        <td align="left" style="width: 90px;">
                                            <img src="{{ asset('') }}{{ $product->thumb }}" alt="Product Image"
                                                style="width: 80px; height: 80px; display: block;">
                                        </td>
                                        <td style="padding-left: 10px; vertical-align: top;">
                                            <p class="order-name"
                                                style="font-size: 16px; font-weight: 600; color: #3b4251; margin-bottom: 5px;">
                                                {{ $product->product_name }}
                                            </p>
                                            <p class="order-price"
                                                style="font-size: 14px; color: #8492a6; margin-bottom: 5px;">
                                                Qty: {{ $v->qty }}
                                            </p>
                                            @if ($v->name == 'Free Product')
                                                <p style="font-size: 14px; font-weight: bold; color: #000;">
                                                    {{ $v->name }}</p>
                                            @else
                                                <p class="order-price"
                                                    style="font-size: 14px; font-weight: bold; color: #000;">
                                                    {{ $v->qty * $product->discount_price }}
                                                    <img src="{{ asset('front/assets/icons/aed_symbol.png') }}"
                                                        alt="AED" height="14"
                                                        style="vertical-align: middle; height:10px;width:10px">
                                                </p>
                                            @endif
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>

                                    <?php
                                        $pack = json_decode($edit->package_detail);
                                        foreach ($pack as $key => $value) {
                                            $package = BoxCustomize::where('package_id', $value->package_type)
                                                ->where('size_id', $value->package_size)
                                                ->first();
                                            if ($package) {
                                                $box_size = BoxSize::where('id', $value->package_size)->first();
                                                $PackageType = PackageType::where('id', $value->package_type)->first();
                                    ?>
                                    <tr class="order-item">
                                        <td align="center">
                                            <img src="{{ asset('') }}{{ $package->image }}" alt="Product Image">
                                        </td>
                                        <td>
                                            <p class="order-name">{{ $PackageType->name }}</p>
                                            <p class="order-name">{{ $box_size->name }}</p>
                                            <p class="order-price">Qty. {{ $value->qty }}</p>
                                        </td>
                                        <td align="right">
                                            <p style="font-weight: 600;">{{ $value->qty * $value->package_price }}
                                                <img src="{{ asset('front/assets/icons/aed_symbol.png') }}"
                                                    alt="AED" height="14" style="vertical-align: middle;">
                                            </p>
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </table>

                                <table width="100%" style="margin-top: 24px;" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="subtotal">Subtotal:</td>
                                        <td class="subtotal" align="right">
                                            <?= $edit->amount - $edit->shipping_fee ?>
                                            <img src="{{ asset('front/assets/icons/aed_symbol.png') }}" alt="AED"
                                                height="14" style="vertical-align: middle;">
                                        </td>
                                    </tr>
                                    @if ($edit->coupon_code)
                                        <tr>
                                            <td class="subtotal">Coupon Applied:</td>
                                            <td class="subtotal" align="right">{{ $edit->coupon_code }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($edit->discount)
                                        <tr>
                                            <td class="subtotal">Discount:</td>
                                            <td class="subtotal" align="right">{{ $edit->discount }}
                                                <img src="{{ asset('front/assets/icons/aed_symbol.png') }}"
                                                    alt="AED" height="14" style="vertical-align: middle;">
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="subtotal">Shipping:</td>
                                        <td class="subtotal" align="right">{{ $edit->shipping_fee }}
                                            <img src="{{ asset('front/assets/icons/aed_symbol.png') }}" alt="AED"
                                                height="14" style="vertical-align: middle;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="total" style="border-top: 1px solid #ddd;">Total:</td>
                                        <td class="total" style="border-top: 1px solid #ddd;" align="right">
                                            <?= $edit->amount ?> <img
                                                src="{{ asset('front/assets/icons/aed_symbol.png') }}" alt="AED"
                                                height="14" style="vertical-align: middle;">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <p>Thank You,<br>The Goodiset Team</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            <p>This email was sent to <a href="mailto:{{ $edit->email }}">{{ $edit->email }}</a>.
                            </p>
                            <p>Goodiset © {{ date('Y') }}, All rights reserved.</p>
                            <div class="social-icons"
                                style=" display:flex;    width: 100%;justify-content: space-between;">
                                <p style="display: inline;margin:auto;">
                                    <img src="{{ asset('front/assets/images/logo.png') }}" alt="Goodiset Logo"
                                        style="width:80px !important;">
                                </p>
                                <p style="display: inline; float: right;">
                                    <a href="https://www.tiktok.com/@goodiset">
                                        <img src="https://goodiset.com/tiktok.png" alt="Goodiset Logo"
                                            style="width:24px !important;">
                                    </a>
                                    <a href="https://www.facebook.com/share/1CkAwUTTgm/?mibextid=wwXIfr">
                                        <img src="https://goodiset.com/facebook.png" alt="Goodiset Logo"
                                            style="width:24px !important;">
                                    </a>
                                    <a href="https://www.instagram.com/goodiset">
                                        <img src="https://goodiset.com/instagram.png" alt="Goodiset Logo"
                                            style="width:24px !important;">
                                    </a>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php }?>
</body>

</html>
