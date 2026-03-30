<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $amount = (Session::get('cart')['amount']);
         $order = Order::create([
             'quantity' =>Session::get('cart')['qty'],
             'amount'=>$amount
         ]+$request->all());
         foreach(Cart::products() as $product){
             Orderitem::create([
                 'product_id' => $product->id,
                 'order_id' => $order->id,
                 'quantity' => $product['quantity'],
                 'price'=>$product['price']
             ]);
             $productt = Product::find($product->id);
             $productt->quantity=$productt->quantity-$product['qty'];
             $productt->update();
         }
         Session::forget('cart');
         if($request->type=='stripe'){
            return view('front.payment.index')->with('order',$order);
         }else{
            return redirect('/');
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
