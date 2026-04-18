<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Api;
use App\Helpers\Cart;
use App\Http\Controllers\Controller;
use App\Models\Admins\Product;
use App\Models\BoxCustomize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // $package = "";
        // $size = "";
        
        // if($request->packageType){

        //     $box = $request->packageType;
        //     $boxes = BoxCustomize::where('id',$box)->first();
        //     $package = $boxes->package_id;
        //     $size = $boxes->size_id;
        // }
        if (Cart::add($request->id, $request->qty ?? 1, $request->packageType ,$request->packageSize)) {
            // return Api::setResponse('qty', Cart::qty());
            return response()->json([
                'msg' => 'Product Added to Cart',
                'msg_type' => 'success',
                'qty' => Cart::qty(),
                'cart' => Session::get('cart')
            ]);
        } else {
            return Api::setError('Item out of stock!');
            return response()->json([
                'msg' => 'Product Added to Cart',
                'msg_type' => 'danger',
            ]);
        }
    }

    public function applyCoupon(Request $request) {
        $couponCode = $request->input('coupon_code');
        $response = Cart::applyCoupon($couponCode);
    
        return response()->json($response);
    }

    public function remove(Request $request)
    {
        Cart::remove($request->id ,$request->boxId);
        return Api::setResponse('cart', Session::get('cart'));
    }

    public function increment(Request $request)
    {
        if (Cart::increase($request->id,$request->boxid)) {
            return Api::setResponse('cart', Session::get('cart'));
        } else {
            return Api::setError('Item out of stock!');
        }
    }

    public function decrement(Request $request)
    {
        Cart::decrease($request->id,$request->boxid);
        return Api::setResponse('cart', Session::get('cart'));
    }

    public function setQuantity(Request $request)
    {
        $productId = $request->input('id');
        $qty = (int) $request->input('qty', 0);

        if ($qty < 1) {
            Cart::remove($productId, $request->input('boxid'));

            return Api::setResponse('cart', Session::get('cart'));
        }

        $result = Cart::setItemQuantity($productId, $qty);
        if (!$result['ok']) {
            $message = match ($result['error'] ?? '') {
                'out_of_stock' => 'Item out of stock',
                'not_in_cart' => 'Item is not in the cart',
                default => 'Unable to update quantity',
            };

            return Api::setError($message);
        }

        return Api::setResponse('cart', Session::get('cart'));
    }

    /**
     * Minimal cart snapshot for client refresh after bfcache / history navigation.
     */
    public function uiState()
    {
        if (!Session::has('cart')) {
            return response()->json(['qty' => 0, 'lines' => []]);
        }

        $cart = Session::get('cart');
        $lines = [];
        $items = $cart['items'] ?? [];
        if (is_array($items)) {
            foreach ($items as $item) {
                $id = $item['id'] ?? null;
                if ($id === null || $id === '') {
                    continue;
                }
                $lines[] = [
                    'id' => (int) $id,
                    'qty' => (int) ($item['qty'] ?? 0),
                ];
            }
        }

        return response()->json([
            'qty' => (int) ($cart['qty'] ?? 0),
            'lines' => $lines,
        ]);
    }

    public function clear()
    {
        Session::forget('cart');
        Session::forget('coupen');
        Session::forget('check');
        return redirect()->back();
    }

    public function addToCart(Request $request)
    {
        $productId = $request->id;
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }
        $cart = session()->get('cart_customize', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += (int)$request->quantity ?? 1;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->discount_price,
                'image' => $product->image_one,
                'quantity' => (int)$request->quantity ?? 1,
            ];
        }
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        
        session(['cart_customize' => $cart]);
        return response()->json(['status' => true, 'cart' => $cart,'cart_total'=> $totalQuantity]);
    }
    public function decrementToCart(Request $request)
    {
        $productId = $request->id;
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }
        $cart = session()->get('cart_customize', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] -= (int)$request->quantity ?? 1;
        } 
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        session(['cart_customize' => $cart]);
        return response()->json(['status' => true, 'cart' => $cart ,'cart_total'=> $totalQuantity]);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart_customize', []);
        $productId = $request->id;
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart_customize' => $cart]);
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false, 'message' => 'Product not found in cart']);
    }

}
