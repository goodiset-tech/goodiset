<?php 
use App\Models\Admins\Product;
$setting = DB::table('setting')
            ->where('id', '=', '1')
            ->first();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your products are on the way</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            width: 100%;
            max-width: auto;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            width: 150px;
        }
        .order-details {
            padding: 20px 0;
        }
        .order-details h2 {
            color: #333;
        }
        .order-summary {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .order-summary th, .order-summary td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .order-summary th {
            background-color: #f8f8f8;
        }
        .order-summary td {
            text-align: center;
        }
        .order-summary tfoot {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <a href="https://dealstore.com.pk/"> <img src="{{asset('')}}{{$setting->logo}}" alt="Your Website Logo"> </a>
        </div>
        <?php foreach ($order as $edit){?>
        <div class="order-details">
            <h2>Your Order Is Dispatched .Your Order Detail Are:</h2>
        </div>
        <table class="order-summary">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Shipping Company Name</th>
                    <th scope="col">Tracking Url</th>
                    <th scope="col">Tracking No</th>
                </tr>
            </thead>
            <tbody>
                <?php $pro = json_decode($edit->product_detail); 
                  $no = 1;
                   foreach($pro as $v){
                   
                   $product = Product::where(['id'=>$v->id])->first();
                   
                   ?>
                    <tr>
                      <td>{{$no++}}</td>
                      <td><a href="{{url('/product/')}}/{{$product->slug}}"><img src="{{url('')}}/{{$product->thumb}}" width="50px" height="50px"></a></td>
                       <td><a href="{{url('/product/')}}/{{$product->slug}}">{{$product->product_name}}</a></td>
                      <td>{{$v->qty}}</td>
                      <td>Rs:{{$v->qty*$product->discount_price}}</td>
                      <td>{{$edit->shipping_company}}</td>
                      <td>{{$edit->track_url}}</td>
                      <td>{{$edit->track_no}}</td>
                    </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">Subtotal</td>
                    <td>Rs:<?= $edit->amount - 250?></td>
                </tr>
                <tr>
                    <td colspan="7">Shipping</td>
                    <td>Rs 250</td>
                </tr>
                <tr>
                    <td colspan="7">Total</td>
                    <td>Rs:<?= $edit->amount?></td>
                </tr>
            </tfoot>
        </table>
        <?php }?>
        <div class="footer">
            <p>If you have any questions, feel free to <a href="{{url('/contact')}}">contact us</a>.</p>
            <p>Follow us on 
                <a href="https://www.facebook.com/Dealstore.com.pk">Facebook</a>, 
            </p>
            <p>&copy; <?= date('Y');?> Dealstore. All rights reserved.</p>
        </div>
    </div>
</body>
</html>