<?php
use App\Models\Admins\Product;
use App\Models\BoxCustomize;
use App\Models\BoxSize;
use App\Models\PackageType;
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
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            padding: 24px;
            /* text-align: center; */
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
            display: inline-block;
            background: #e92827;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            color: #ffffff !important;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            margin-top: 16px;
        }

        .order-detailss {
            margin-top: 32px;
            margin-bottom: 32px;
            padding: 16px;
            background-color: #f9fafb;
            border-radius: 12px;
        }

        .order-number {
            font-size: 18px;
            font-weight: 600;
            color: #3b4251;
        }

        .order-item {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .order-item td {
            padding-bottom: 20px;
        }

        .order-item img {
            display: block;
            width: 80px;
            height: 90;
            margin: 0 auto;
        }

        .order-name {
            font-size: 14px;
            font-weight: 600;
            color: #3b4251;
            margin-top: 10px;
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
            /* text-align: center; */
            padding: 16px;
            background: #fffafa;
        }

        .email-footer p {

            text-align: center;
        }

        .email-footer a {
            color: #e92827;
            text-decoration: none;
        }

        .social-icons img {
            width: 24px;
            margin: 5px;
        }

        .social-icons a {
            font-size: 26px;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }

            .email-content h2 {
                font-size: 20px;
            }

            .activate-btn {
                font-size: 14px;
                padding: 10px 20px;
            }

            .order-price {
                margin: 0;
                text-wrap: nowrap;
            }

            .order-item img {
                width: 60px;
                height: 70px;
            }
        }
    </style>
</head>

<body>
    <?php foreach ($order as $edit){?>
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

                            <p style="margin-bottom: 0px;">Hi letstango,</p>
                            <p style="margin-top: 10px;">You Have assigned a new order from goodiset for delivery.
                                Please check the order details below.</p>
                            <p style="margin-top: 10px;">
                                <b>Customer name: </b> <span>{{ $edit->customer_name }}</span>
                                <b>Customer phone: </b> <span>{{ $edit->phone }}</span>
                                <b>Customer address: </b> <span>{{ $edit->address }}</span>
                                <b>Customer city: </b> <span>{{ $edit->city }}</span>
                                <b>Customer country: </b> <span>{{ $edit->country }}</span>
                            </p>
                            @if ($edit->dstatus >= 1)
                                <p> Your Order tracking id is : <strong>{{ $edit->track_no }}</strong></p>
                            @endif




                            <div class="order-detailss">
                                <h3 class="order-number">Order #{{ $edit->order_no }}</h3>

                                <!-- Order Item -->
                                <table width="100%" cellspacing="0" cellpadding="0">
                                    <?php $pro = json_decode($edit->product_detail); 
                                        $no = 1;
                                        foreach($pro as $v){
                                        if($v->id != null){
                                        $product = Product::where(['id'=>$v->id])->first();
                                        if ($product) {
                                        ?>
                                    <tr class="order-item">
                                        <td align="center">
                                            <img src="{{ asset('') }}{{ $product->thumb }}" alt="Product Image">
                                        </td>
                                        <td>
                                            <p class="order-name">{{ $product->product_name }}</p>
                                            <p class="order-price">Qty: {{ $v->qty }}</p>
                                            {{-- <p class="order-price">Discount (-$5.00)</p> --}}
                                        </td>
                                        <td align="right">
                                            <p class="order-price">{{ $v->qty * $product->discount_price }}
                                                {{ getSetting('currency') }}</p>
                                        </td>
                                    </tr>
                                    <?php } } }?>

                                    <?php 
                                            $pack = json_decode($edit->package_detail);
                                            foreach ($pack as $key => $value) {
                                                $package = BoxCustomize::where('package_id', $value->package_type)
                                                        ->where('size_id', $value->package_size)
                                                        ->first();
                                            if($package){
                                                $box_size = BoxSize::where('id',$value->package_size)->first();
                                                $PackageType = PackageType::where('id',$value->package_type)->first();
                                            ?>
                                    <tr class="order-item">
                                        <td align="center">
                                            <img src="{{ asset('') }}{{ $package->image }}" alt="Product Image">
                                        </td>
                                        <td>
                                            <p class="order-name">{{ $PackageType->name }}</p>
                                            <p class="order-name">{{ $box_size->name }}</p>
                                            <p class="order-price">Qty. {{ $value->qty }}</p>
                                            {{-- <p class="order-price">Discount (-$5.00)</p> --}}
                                        </td>
                                        <td align="right">
                                            <p>{{ $value->qty * $value->package_price }} {{ getSetting('currency') }}
                                            </p>
                                        </td>
                                    </tr>
                                    <?php } }?>

                                </table>

                                <table width="100%" style="margin-top: 24px;" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="subtotal">Subtotal:</td>
                                        <td class="subtotal" align="right">
                                            <?= $edit->amount - getSetting('shipping') ?> {{ getSetting('currency') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="subtotal">Shipping:</td>
                                        <td class="subtotal" align="right">{{ getSetting('shipping') }}
                                            {{ getSetting('currency') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="total" style="border-top: 1px solid #ddd;">Total:</td>
                                        <td class="total" style="border-top: 1px solid #ddd;" align="right">
                                            <?= $edit->amount ?> {{ getSetting('currency') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <p>Thank You,<br>The Goodiset Team</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            <p>Goodiset © {{ date('Y') }}, All rights reserved.</p>
                            <div class="social-icons"
                                style=" display:flex;    width: 100%;justify-content: space-between;">
                                <p style="display: inline;margin:auto;">
                                    <img src="{{ asset('') }}{{ getSetting('logo') }}" alt="Goodiset Logo"
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
