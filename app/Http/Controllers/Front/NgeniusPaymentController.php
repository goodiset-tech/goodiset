<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use App\Models\Admins\Order;
use App\Models\Admins\Product;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Cart;

class NgeniusPaymentController extends Controller
{
    private $outletId;
    private $apiKey;
    private $baseUrl;
    private $redirectUrl;

    public function __construct()
    {
        $this->outletId = env('NGENIUS_OUTLET_ID');
        $this->apiKey = env('NGENIUS_API_KEY');
        $this->baseUrl = env('NGENIUS_BASE_URL');
        $this->redirectUrl = env('NGENIUS_REDIRECT_URL');
    }
    private function getAccessToken()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $this->apiKey,
            'Content-Type' => 'application/vnd.ni-identity.v1+json',
        ])->post($this->baseUrl . '/identity/auth/access-token', [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->status() === 200) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to generate access token. ' . $response->body());
    }
    public function createPaymentOrder(Request $request)
    {
        try {

            $order = Order::where('order_no',$request->order_no)->first();
            $accessToken = $this->getAccessToken();
            $totalWithTax =$order->amount;
            $totalAmount = Session::get('cart')['amount'];
            $shipping = getSetting('shipping');
            $taxPercentage = getSetting('tax_value');
            $totalWithTax = $totalAmount + $shipping + ($totalAmount * $taxPercentage / 100);
            $totalWithTax =round($totalWithTax);
            $orderPayload = [
                'action' => 'SALE',
                'amount' => [
                    'currencyCode' => getSetting('currency'), 
                    'value' => $totalWithTax * 100, 
                ],
                'merchantAttributes' => [
                    'redirectUrl' => route('payment.status'),
                ],
                'emailAddress' => $order->email, 
                'billingAddress' => [
                    'firstName' => $order->customer_name, 
                    'lastName' => '',
                    'address1' => $order->address,
                    'city' => $order->city,
                    'countryCode' => 'AE',
                ],

            ];
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/vnd.ni-payment.v2+json',
            ])->post($this->baseUrl . "/transactions/outlets/{$this->outletId}/orders", $orderPayload);
            // dd($response->status());
            if ($response->status() == 201) {

                $paymentRef = $response->json()['reference'];
                Order::where('order_no',$request->order_no)->update([
                    'payment_ref' => $paymentRef,
                ]);
                
                $paymentLink = $response->json()['_links']['payment']['href'];
                return response()->json([ 'paymentLink' => $paymentLink]);
            }
            return response()->json([
                'error' => 'Failed to create payment order.',
                'details' => $response->json(),
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function handlePaymentStatus(Request $request)
    {
        \Log::info('Payment Callback Data:', $request->all());
        $ref = $request->get('ref');
        // dd($ref);
        if (!$ref) {
            \Log::error('Missing ref in callback data.');
            return view('payment.unknown', ['orderId' => 'Unknown']);
        }

        try {
            $accessToken = $this->getAccessToken();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/vnd.ni-payment.v2+json',
            ])->get($this->baseUrl . "/transactions/outlets/{$this->outletId}/orders/{$ref}");
            \Log::info('Payment Gateway Response:', $response->json());
            $order_detail = Order::where('payment_ref' ,$ref)->first();
            if ($response->status() === 200) {
                $responseData = $response->json();
                $paymentStatus = $paymentStatus = $responseData['_embedded']['payment'][0]['state'];
                switch (strtoupper($paymentStatus)) {
                    case 'SUCCESS':
                        $order_neew = Order::where('payment_ref' ,$ref)->first();
                        $order_data = Order::where('payment_ref' ,$ref)->get();
                        try {
                            $to_name = $order_neew->name;
                            $to_email = $order_neew->email;
                            $data = [
                                'order' => $order_data,
                            ];
                            Mail::send('emails.order', $data, function ($message) use ($to_name, $to_email) {
                                $message->to($to_email, $to_name)
                                    ->subject('Order Email');
                                $message->from(config('mail.from.address'), config('mail.from.name'));
                            });
                        } catch (\Exception $e) {
                            \Log::error('Failed to send order email to customer: ' . $e->getMessage());
                        }
                        Order::where('payment_ref' ,$ref)->update([
                            'payment_status' => $paymentStatus,
                        ]);
                        foreach (Cart::products() as $product) {
                            $productt = Product::find($product->id);
                            if ($productt->format == 3) {
                                $rpro = [];
                                if (isset($productt->bundle_product_id)) {
                                    $rpro = explode(',', $productt->bundle_product_id);
                                }
                                $rprod = Product::whereIn('id', $rpro)->get();
                                foreach ($rprod as $products) {
                                    $product_bundle = Product::find($products->id);
                                    $product_bundle->product_quantity -= 1;
                                    $product_bundle->save();
                                }
                            }
                            $productt->product_quantity -= $product['qty'];
                            $productt->save();
                        }
        
                        Session::forget('cart');
                        Session::forget('cart_customize');
                        Session::forget('selected_box');
                        return redirect()->route('thanks', ['order_no' => $order_detail->order_no]);
                    case 'FAILED':
                        Order::where('payment_ref', $ref)->delete();
                        Order::where('payment_ref' ,$ref)->update([
                            'payment_status' => $paymentStatus,
                        ]);
                        return redirect()->route('cart');
                    default:
                        \Log::warning("Unexpected payment status: $paymentStatus");
                        $order_neew = Order::where('payment_ref' ,$ref)->first();
                        $order_data = Order::where('payment_ref' ,$ref)->get();
                        try {
                            $to_name = $order_neew->name;
                            $to_email = $order_neew->email;
                            $data = [
                                'order' => $order_data,
                            ];
                            Mail::send('emails.order', $data, function ($message) use ($to_name, $to_email) {
                                $message->to($to_email, $to_name)
                                    ->subject('Order Email');
                                $message->from(config('mail.from.address'), config('mail.from.name'));
                            });
                        } catch (\Exception $e) {
                            \Log::error('Failed to send order email to customer: ' . $e->getMessage());
                        }
                        try {
                            $to = 'yusuf@goodiset.com';
                            $to_n = 'Admin';
                            Mail::send('emails.order', $data, function ($message) use ($to_n, $to) {
                                $message->to($to, $to_n)
                                    ->subject('Order Email');
                                $message->from(config('mail.from.address'), config('mail.from.name'));
                            });
                        } catch (\Exception $e) {
                            \Log::error('Failed to send order email to admin: ' . $e->getMessage());
                        }
                        try {
                            $to = 'gabriel@goodiset.com';
                            $to_n = 'Admin';
                            Mail::send('emails.order', $data, function ($message) use ($to_n, $to) {
                                $message->to($to, $to_n)
                                    ->subject('Order Email');
                                $message->from(config('mail.from.address'), config('mail.from.name'));
                            });
                        } catch (\Exception $e) {
                            \Log::error('Failed to send order email to admin: ' . $e->getMessage());
                        }
                        Order::where('payment_ref' ,$ref)->update([
                            'payment_status' => $paymentStatus,
                        ]);
                        foreach (Cart::products() as $product) {
                            $productt = Product::find($product->id);
                            if ($productt->format == 3) {
                                $rpro = [];
                                if (isset($productt->bundle_product_id)) {
                                    $rpro = explode(',', $productt->bundle_product_id);
                                }
                                $rprod = Product::whereIn('id', $rpro)->get();
                                foreach ($rprod as $products) {
                                    $product_bundle = Product::find($products->id);
                                    $product_bundle->product_quantity -= 1;
                                    $product_bundle->save();
                                }
                            }
                            $productt->product_quantity -= $product['qty'];
                            $productt->save();
                        }
        
                        Session::forget('cart');
                        Session::forget('cart_customize');
                        Session::forget('selected_box');
                        return redirect()->route('thanks', ['order_no' => $order_detail->order_no]);
                }
            }
            \Log::error('Failed to fetch payment status. Response:', ['body' => $response->body()]);
            return redirect()->route('thanks', ['order_no' => $order_detail->order_no]);
        } catch (\Exception $e) {
            $order_detail = Order::where('payment_ref' ,$ref)->first();
            \Log::error('Error during payment status check:', ['message' => $e->getMessage()]);
            return redirect()->route('thanks', ['order_no' => $order_detail->order_no]);
        }
    }

}
