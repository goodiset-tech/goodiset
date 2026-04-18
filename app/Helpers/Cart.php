<?php

namespace App\Helpers;

use App\Models\Admins\Coupon;
use App\Models\Admins\Order;
use App\Models\Admins\Product;
use App\Models\BoxCustomize;
use App\Models\PackageType;
use Illuminate\Support\Facades\Session;

class Cart
{
    public static function add($product_id, $qty, $package_type = '', $package_size = '')
    {
        $cart = [];
        $product = Product::find($product_id);
        $set = false;
        $set1 = false;
        $index = 0;
        $package_name = '';
        $package_price = 0;

        if ($package_type) {
            $packages = PackageType::where('id', $package_type)->first();
            if ($packages) {
                $package_name = $packages->name;
            }
        }

        if ($package_type && $package_size) {
            $package = BoxCustomize::where('package_id', $package_type)
                ->where('size_id', $package_size)
                ->first();

            if ($package) {
                $package_price = $package->price;
            }
        }

        if (Session::has('cart')) {
            $cart = Session::get('cart');
            if (!$product) {
                $cart = Session::get('cart');
                foreach ($cart['package_detail'] as $key => $item) {
                    if ($item['package_type'] == $package_type && $item['package_size'] == $package_size) {
                        $index = $key;
                        $set1 = true;
                    }
                }
                ///Cart Exists But Item is NEW
                if (!$set1) {
                    $cart['amount'] += $package_price;
                    $cart['qty'] += $qty;
                    array_push(
                        $cart['package_detail'],
                        [
                            'package_type' => $package_type,
                            'package_size' => $package_size,
                            'package_name' => $package_name,
                            'package_price' => $package_price,
                            'package_products' => json_encode(Session::get('cart_customize', [])),
                            'qty' => $qty
                        ]
                    );
                    $cart['package_type'] = $package_type;
                    $cart['package_size'] = $package_size;
                    $cart['package_name'] = $package_name;
                    $cart['package_price'] = $package_price;
                    $cart['package_qty'] = $qty;
                    Session::forget('cart_customize');
                    Session::forget('selected_box');
                } else {
                    if ($qty < $cart['package_detail'][$index]['qty']) {
                        $cart['amount'] -= ($cart['package_detail'][$index]['qty'] - $qty) * $package_price;
                        $cart['qty'] -= $cart['package_detail'][$index]['qty'] - $qty;
                    } else if ($qty > $cart['package_detail'][$index]['qty']) {
                        $cart['amount'] += ($qty - $cart['package_detail'][$index]['qty']) * $package_price;
                        $cart['qty'] += $qty - $cart['package_detail'][$index]['qty'];
                    }
                    $cart['package_detail'][$index]['qty'] = $qty;
                    Session::forget('cart_customize');
                    Session::forget('selected_box');
                }
            } else {
                foreach ($cart['items'] as $key => $item) {
                    if ($item['id'] == $product_id) {
                        $index = $key;
                        $set = true;
                    }
                }
                ///Cart Exists But Item is NEW
                if (!$set) {
                    $cart['amount'] += $qty * $product->discount_price;
                    $cart['qty'] += $qty;
                    array_push($cart['items'], ['id' => $product_id, 'qty' => $qty, 'name' => $product->product_name, 'price' => $product->discount_price, 'original_price' => $product->selling_price]);
                } else {
                    $cart['amount'] += $qty * $product->discount_price;
                    $cart['qty'] += $qty;
                    $cart['items'][$index]['qty'] += $qty;
                }
            }
        } else {
            if (!$product) {
                $cart = [
                    'qty' => $qty,
                    'amount' => $package_price,
                    'items' => [
                        [
                            'id' => null,
                            'qty' => null,
                            'ship' => null,
                            'name' => null,
                            'price' => null
                        ]
                    ],
                    'package_detail' =>  [
                        [
                            'package_type' => $package_type,
                            'package_size' => $package_size,
                            'package_name' => $package_name,
                            'package_price' => $package_price,
                            'package_products' => json_encode(Session::get('cart_customize', [])),
                            'qty' => $qty
                        ]
                    ],
                    'package_type' => $package_type,
                    'package_size' => $package_size,
                    'package_name' => $package_name,
                    'package_price' => $package_price,
                    'package_qty' => $qty,
                ];
                Session::forget('cart_customize');
                Session::forget('selected_box');
            } else {
                $cart = [
                    'discount' => 0,
                    'coupon_code' => null,
                    'total_after_discount' => null,
                    'item_removed' => null,
                    'qty' => $qty,
                    'amount' => $product->discount_price * $qty,
                    'items' => [
                        [
                            'id' => $product_id,
                            'qty' => $qty,
                            'ship' => $product->shipping_price,
                            'name' => $product->product_name,
                            'price' => $product->discount_price,
                            'original_price' => $product->selling_price,
                        ]
                    ],
                    'package_detail' =>  [
                        [
                            'package_type' => null,
                            'package_size' => null,
                            'package_name' => null,
                            'package_price' => null,
                            'package_products' => null,
                            'qty' => null
                        ]
                    ],
                    'package_type' => null,
                    'package_size' => null,
                    'package_name' => null,
                    'package_price' => null,
                    'package_qty' => null,
                ];
            }
        }
        Session::put('cart', $cart);
        self::applyAutoCoupons($cart);
        self::reEvaluateCoupon($cart);
        return true;
    }

    public static function increase($productId, $boxid)
    {
        if (!Session::has('cart')) return false;
        if ($productId) {
            $cart = Session::get('cart');
            $product = Product::find($productId);
            $index = 0;

            foreach ($cart['items'] as $key => $item) {
                if ($item['id'] == $productId) {
                    $index = $key;
                }
            }
            $cart['item_removed'] = null;
            $cart['amount'] += $product->discount_price;
            $cart['qty']++;
            $cart['items'][$index]['qty']++;
            if ($cart['items'][$index]['qty'] > $product->product_quantity) {
                return false;
            }

            Session::put('cart', $cart);
            self::applyAutoCoupons($cart);
            self::reEvaluateCoupon($cart);
            return true;
        }

        if ($boxid) {
            $cart = Session::get('cart');
            $product = BoxCustomize::find($boxid);
            $index = 0;

            foreach ($cart['package_detail'] as $key => $item) {
                if ($item['package_type'] == $product->package_id) {
                    $index = $key;
                }
            }

            $cart['amount'] += $product->price;
            $cart['qty']++;
            $cart['package_qty']++;
            $cart['package_detail'][$index]['qty']++;

            Session::put('cart', $cart);
            self::applyAutoCoupons($cart);
            self::reEvaluateCoupon($cart);
            return true;
        }
    }

    /**
     * Set absolute line quantity for a normal cart product (not package/box lines).
     *
     * @param  int  $productId
     * @param  int  $newQty  Cart units (for weight products, one unit is one 100g step).
     * @return array{ok:bool,error?:string,removed?:bool}
     */
    public static function setItemQuantity($productId, $newQty)
    {
        if (!Session::has('cart') || !$productId) {
            return ['ok' => false, 'error' => 'no_cart'];
        }

        $newQty = (int) $newQty;
        $cart = Session::get('cart');
        $product = Product::find($productId);
        if (!$product) {
            return ['ok' => false, 'error' => 'no_product'];
        }

        $index = null;
        foreach ($cart['items'] ?? [] as $key => $item) {
            if (isset($item['id']) && (int) $item['id'] === (int) $productId) {
                $index = $key;
                break;
            }
        }
        if ($index === null) {
            return ['ok' => false, 'error' => 'not_in_cart'];
        }

        if ($newQty < 1) {
            self::remove($productId, null);

            return ['ok' => true, 'removed' => true];
        }

        if ($newQty > $product->product_quantity) {
            return ['ok' => false, 'error' => 'out_of_stock'];
        }

        $oldQty = (int) $cart['items'][$index]['qty'];
        $delta = $newQty - $oldQty;
        if ($delta === 0) {
            return ['ok' => true];
        }

        $cart['qty'] += $delta;
        $cart['amount'] += $delta * (float) $product->discount_price;
        $cart['items'][$index]['qty'] = $newQty;
        $cart['item_removed'] = null;

        Session::put('cart', $cart);
        self::applyAutoCoupons($cart);
        self::reEvaluateCoupon($cart);

        return ['ok' => true];
    }

    public static function decrease($productId, $boxid)
    {
        if (!Session::has('cart')) return false;
        if ($productId) {
            $cart = Session::get('cart');
            $product = Product::find($productId);
            $index = 0;

            foreach ($cart['items'] as $key => $item) {
                if ($item['id'] == $productId) {
                    $index = $key;
                }
            }
            $cart['item_removed'] = null;
            $cart['amount'] -= $product->discount_price;
            $cart['qty']--;
            $cart['items'][$index]['qty']--;

            if ($cart['items'][$index]['qty'] < 1) unset($cart['items'][$index]);

            if ($cart['qty'] < 1) {
                Session::forget('cart');
            } else {
                Session::put('cart', $cart);
                self::applyAutoCoupons($cart);
                self::reEvaluateCoupon($cart);
            }
        }

        if ($boxid) {
            $cart = Session::get('cart');
            $product = BoxCustomize::find($boxid);
            $index = 0;

            foreach ($cart['package_detail'] as $key => $item) {
                if ($item['package_type'] == $product->package_id) {
                    $index = $key;
                }
            }

            $cart['amount'] -= $product->price;
            $cart['qty']--;
            $cart['package_qty']--;
            $cart['package_detail'][$index]['qty']--;

            Session::put('cart', $cart);
            self::applyAutoCoupons($cart);
            self::reEvaluateCoupon($cart);
            return true;
        }
    }

    public static function remove($product_id, $boxid)
    {
        if ($product_id) {
            $cart = Session::get('cart');
            $product = Product::find($product_id);
            $index = 0;
            foreach ($cart['items'] as $key => $item) {
                if ($item['id'] == $product_id) {
                    $index = $key;
                    break;
                }
            }
            $cart['item_removed'] = null;
            $cart['amount'] -= $product->discount_price * $cart['items'][$index]['qty'];
            $cart['qty'] -= $cart['items'][$index]['qty'];
            unset($cart['items'][$index]);

            if ($cart['qty'] < 1) {
                Session::forget('cart');
            } else {
                Session::put('cart', $cart);
                self::applyAutoCoupons($cart);
                self::reEvaluateCoupon($cart);
            }
        }

        if ($boxid) {
            $cart = Session::get('cart');
            $product = BoxCustomize::find($boxid);
            $index = 0;

            foreach ($cart['package_detail'] as $key => $item) {
                if ($item['package_type'] == $product->package_id) {
                    $index = $key;
                    break;
                }
            }

            $cart['amount'] -= $product->price * $cart['package_detail'][$index]['qty'];
            $cart['qty'] -= $cart['package_detail'][$index]['qty'];
            unset($cart['package_detail'][$index]);

            if ($cart['qty'] < 1) {
                Session::forget('cart');
            } else {
                Session::put('cart', $cart);
                self::applyAutoCoupons($cart);
                self::reEvaluateCoupon($cart);
            }
        }
    }

    public static function update($products)
    {
        $cart = Session::get('cart');
        $totalamount = 0;
        $totalqty = 0;
        foreach ($cart['items'] as $key => $item) {
            $product = Product::find($item['id']);
            $cart['items'][$key]['qty'] = $products[$item['id']];
            if ($cart['items'][$key]['qty'] > $product->stock) {
                return redirect()->back()->with('msg', 'Item(s) out of stock');
            }
            $totalqty += $products[$item['id']];
            $totalamount += $products[$item['id']] * $product->discount_price;
        }
        $cart['amount'] = $totalamount;
        $cart['qty'] = $totalqty;
        Session::put('cart', $cart);
        self::applyAutoCoupons($cart);
        self::reEvaluateCoupon($cart);
        return;
    }

    public static function products()
    {
        $cart = Session::get('cart');
        $products = [];
        if (isset($cart['items']) && count($cart['items']) > 0) {
            foreach ($cart['items'] as $item) {
                if ($item['id'] != null) {
                    $product = Product::find($item['id']);
                    $product['qty'] = $item['qty'];
                    $product['name'] = $item['name'];
                    array_push($products, $product);
                }
            }
        }
        return $products;
    }

    public static function package()
    {
        $cart = Session::get('cart');
        $packages = [];
        if (isset($cart['package_detail']) && count($cart['package_detail'])) {
            $packages = $cart['package_detail'];
        }
        return $packages;
    }

    public static function has($product_id)
    {
        $cart = Session::get('cart');
        foreach ($cart['items'] as $key => $item) {
            if ($item['id'] == $product_id) {
                return true;
            }
        }
        return false;
    }

    public static function has_pro($product_id)
    {
        $cart = Session::get('cart');
        if ($cart && isset($cart['items'])) {
            foreach ($cart['items'] as $item) {
                if ($item['id'] == $product_id) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function product_qty($product_id)
    {
        $cart = Session::get('cart');
        if ($cart && isset($cart['items'])) {
            foreach ($cart['items'] as $item) {
                if ($item['id'] == $product_id) {
                    return $item['qty'];
                }
            }
        }
        return 1;
    }

    public static function package_qty($package_type, $size_id)
    {
        $cart = Session::get('cart');
        if ($cart && isset($cart['package_detail'])) {
            foreach ($cart['package_detail'] as $item) {
                if ($item['package_type'] == $package_type && $item['package_size'] == $size_id) {
                    return $item['qty'];
                }
            }
        }
        return 0;
    }

    public static function cus_has_pro($product_id)
    {
        $cart_customize = session()->get('cart_customize', []);
        if (isset($cart_customize[$product_id])) {
            return true;
        }
        return false;
    }

    public static function cus_product_qty($product_id)
    {
        $cart_customize = session()->get('cart_customize', []);
        if (isset($cart_customize[$product_id])) {
            return $cart_customize[$product_id]['quantity'];
        }
        return 100;
    }

    public static function qty()
    {
        return Session::get('cart')['qty'];
    }

    public static function applyCoupon($couponCode)
    {
        $coupon = Coupon::where('code', $couponCode)->where('auto_apply', 0)->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Invalid coupon code.'];
        }

        if ($coupon->one_time_use == 1) {
            $session_id = Session::getId();
            if (Order::where('session_id', $session_id)->where('coupon_code', $couponCode)->exists()) {
                return ['success' => false, 'message' => 'This is one time coupon already applied.'];
            }
        }

        if ($coupon->end_date < now()) {
            return ['success' => false, 'message' => 'Coupon has expired.'];
        }

        // Check if the coupon is already applied
        $cart = Session::get('cart');
        if (isset($cart['coupon_code']) && $cart['coupon_code'] === $couponCode) {
            return ['success' => false, 'message' => 'Coupon already applied.'];
        }

        if ($coupon->num_of_coupons == $coupon->no_of_discount) {
            return ['success' => false, 'message' => 'Coupon usage limit reached.'];
        }

        $fullPriceSubtotal = 0;
        $discountedSubtotal = 0;

        foreach ($cart['items'] as $item) {
            $price = $item['price'] ?? 0;
            $originalPrice = $item['original_price'] ?? $price;

            if ($originalPrice > $price) {
                $discountedSubtotal += $price * ($item['qty'] ?? 1);
            } else {
                $fullPriceSubtotal += $price * ($item['qty'] ?? 1);
            }
        }

        $cartTotalForCoupon = $fullPriceSubtotal;

        if ($cartTotalForCoupon < $coupon->cart_minimum) {
            return [
                'success' => false,
                'message' => "Add more full-price items! Minimum {$coupon->cart_minimum} " . getSetting('currency') . " required (already discounted items don't count towards minimum)."
            ];
        }

        $discount = 0;

        if ($coupon->type == 'amount') {
            $discount = $coupon->discount;
        } elseif ($coupon->type == 'percentage') {
            $discount = ($cartTotalForCoupon * $coupon->discount) / 100;
        }

        // Handle free products if any
        if ($coupon->products != '') {
            $products = json_decode($coupon->products, true);

            if (is_array($products)) {
                foreach ($products as $productId) {
                    $productExists = false;
                    foreach ($cart['items'] as $item) {
                        if ($item['id'] == $productId) {
                            $productExists = true;
                            break;
                        }
                    }

                    if (!$productExists) {
                        $product = Product::find($productId);
                        array_push($cart['items'], [
                            'id' => $productId,
                            'qty' => 1,
                            'name' => $product ? $product->product_name : 'Free Product',
                            'price' => 0,
                        ]);
                    }
                }
            }
        }

        $cart['discount']           = $discount;
        $cart['coupon_code']        = $coupon->code;
        $cart['full_price_subtotal'] = $fullPriceSubtotal;
        $cart['total_after_discount'] = $fullPriceSubtotal - $discount + $discountedSubtotal;

        Session::put('cart', $cart);

        // $coupon->no_of_discount += 1;
        $coupon->save();

        return ['success' => true, 'message' => 'Coupon applied successfully.', 'discount' => $discount];
    }

    private static function applyAutoCoupons(&$cart)
    {
        // Get the most recent qualifying auto-apply coupon
        $coupon = Coupon::where('auto_apply', 1)
            ->where('status', 1)
            ->where('end_date', '>=', now())
            ->whereRaw('num_of_coupons > no_of_discount')
            ->orderBy('created_at', 'desc')     // newest first (or use 'updated_at' if preferred)
            ->first();                          // ← only take the latest one

        // If no coupon exists at all → nothing to do
        if (!$coupon) {
            self::clearAutoCoupon($cart);
            return;
        }

        // Calculate subtotals (same as before)
        $fullPriceSubtotal  = 0;
        $discountedSubtotal = 0;

        foreach ($cart['items'] ?? [] as $item) {
            $qty     = $item['qty'] ?? 1;
            $price   = $item['price'] ?? 0;
            $original = $item['original_price'] ?? $price;

            if ($original > $price && $price > 0) {
                $discountedSubtotal += $price * $qty;
            } else {
                $fullPriceSubtotal += $price * $qty;
            }
        }

        $currency = getSetting('currency');

        // Same checks as manual coupon apply
        if ($fullPriceSubtotal < $coupon->cart_minimum) {
            self::clearAutoCoupon($cart);
            return [
                'success' => false,
                'message' => "Add more full-price items! Minimum {$coupon->cart_minimum}  required (already discounted items don't count towards minimum)."
            ];
        }

        if ($coupon->one_time_use == 1) {
            $session_id = Session::getId();
            if (Order::where('session_id', $session_id)
                ->where('coupon_code', $coupon->code)
                ->exists()
            ) {

                self::clearAutoCoupon($cart);
                return;
            }
        }

        // All checks passed → apply it
        $discount = 0;
        if ($coupon->type === 'amount') {
            $discount = $coupon->discount;
        } elseif ($coupon->type === 'percentage') {
            $discount = ($fullPriceSubtotal * $coupon->discount) / 100;
        }

        // Handle free products
        if ($coupon->products != '') {
            $products = json_decode($coupon->products, true) ?? [];
            foreach ($products as $productId) {
                $exists = collect($cart['items'])->contains('id', $productId);
                if (!$exists) {
                    $product = Product::find($productId);
                    $cart['items'][] = [
                        'id'             => $productId,
                        'qty'            => 1,
                        'name'           => $product ? $product->product_name : 'Free Product',
                        'price'          => 0,
                        'original_price' => 0,
                    ];
                }
            }
        }

        $cart['discount']             = $discount;
        $cart['coupon_code']          = $coupon->code;
        $cart['total_after_discount'] = $fullPriceSubtotal - $discount + $discountedSubtotal;

        Session::put('cart', $cart);
    }

    private static function clearAutoCoupon(&$cart)
    {
        $cart['discount']             = 0;
        $cart['coupon_code']          = null;
        $cart['total_after_discount'] = ($cart['full_price_subtotal'] ?? 0) + ($cart['discounted_subtotal'] ?? 0);
        Session::put('cart', $cart);
    }

    // private static function applyAutoCoupons(&$cart)
    // {
    //     $autoCoupons = Coupon::where('auto_apply', 1)
    //         ->where('status', 1)
    //         ->where('end_date', '>=', now())
    //         ->whereRaw('num_of_coupons > no_of_discount')
    //         ->get();

    //     $cartTotal = $cart['amount'];
    //     $bestCoupon = null;
    //     $maxDiscount = 0;

    //     foreach ($autoCoupons as $coupon) {
    //         if ($cartTotal >= $coupon->cart_minimum) {
    //             $discount = $coupon->type == 'amount' ? $coupon->discount : ($cartTotal * $coupon->discount) / 100;

    //             if ($coupon->one_time_use == 1) {
    //                 $session_id = Session::getId();
    //                 if (Order::where('session_id', $session_id)->where('coupon_code', $coupon->code)->exists()) {
    //                     continue;
    //                 }
    //             }

    //             if ($discount > $maxDiscount) {
    //                 $maxDiscount = $discount;
    //                 $bestCoupon = $coupon;
    //             }
    //         }
    //     }

    //     if ($bestCoupon) {
    //         $discount = $bestCoupon->type == 'amount' ? $bestCoupon->discount : ($cartTotal * $bestCoupon->discount) / 100;

    //         if ($bestCoupon->products != '') {
    //             $products = json_decode($bestCoupon->products, true);
    //             if (is_array($products)) {
    //                 foreach ($products as $productId) {
    //                     $productExists = false;
    //                     foreach ($cart['items'] as $item) {
    //                         if ($item['id'] == $productId) {
    //                             $productExists = true;
    //                             break;
    //                         }
    //                     }

    //                     if (!$productExists) {
    //                         $product = Product::find($productId);
    //                         array_push($cart['items'], [
    //                             'id' => $productId,
    //                             'qty' => 1,
    //                             'name' => $product ? $product->product_name : 'Free Product',
    //                             'price' => 0,
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }

    //         $cart['discount'] = $discount;
    //         $cart['coupon_code'] = $bestCoupon->code;
    //         $cart['total_after_discount'] = $cartTotal - $discount;
    //         Session::put('cart', $cart);
    //     }
    // }

    // private static function reEvaluateCoupon(&$cart)
    // {
    //     if (isset($cart['coupon_code'])) {
    //         $coupon = Coupon::where('code', $cart['coupon_code'])->first();
    //         $cartTotal = $cart['amount'];

    //         if ($coupon) {
    //             if ($coupon->auto_apply == 1) {
    //                 self::applyAutoCoupons($cart);
    //                 return;
    //             }

    //             if ($cartTotal >= $coupon->cart_minimum && $coupon->end_date >= now() && $coupon->num_of_coupons > $coupon->no_of_discount) {
    //                 if ($coupon->type == 'amount') {
    //                     $cart['discount'] = $coupon->discount;
    //                 } elseif ($coupon->type == 'percentage') {
    //                     $cart['discount'] = ($cartTotal * $coupon->discount) / 100;
    //                 }
    //                 $cart['total_after_discount'] = $cartTotal - $cart['discount'];
    //                 Session::put('cart', $cart);
    //             } else {
    //                 $cart['discount'] = 0;
    //                 $cart['coupon_code'] = null;
    //                 $cart['total_after_discount'] = $cart['amount'];
    //                 $cart['item_removed'] = 1;

    //                 if ($coupon->products != '') {
    //                     $freeProducts = json_decode($coupon->products, true);
    //                     if (is_array($freeProducts)) {
    //                         foreach ($freeProducts as $productId) {
    //                             foreach ($cart['items'] as $key => $item) {
    //                                 if ($item['id'] == $productId && $item['price'] == 0) {
    //                                     unset($cart['items'][$key]);
    //                                     break;
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //                 Session::put('cart', $cart);
    //                 self::applyAutoCoupons($cart);
    //             }
    //         } else {
    //             $cart['discount'] = 0;
    //             $cart['coupon_code'] = null;
    //             $cart['total_after_discount'] = $cart['amount'];
    //             Session::put('cart', $cart);
    //             self::applyAutoCoupons($cart);
    //         }
    //     } else {
    //         self::applyAutoCoupons($cart);
    //     }
    // }
    private static function reEvaluateCoupon(&$cart)
    {
        // If no coupon code is set → just try auto-apply
        if (!isset($cart['coupon_code']) || empty($cart['coupon_code'])) {
            self::applyAutoCoupons($cart);
            return;
        }

        $coupon = Coupon::where('code', $cart['coupon_code'])->first();

        if (!$coupon) {
            $cart['discount']             = 0;
            $cart['coupon_code']          = null;
            $cart['total_after_discount'] = $cart['amount'] ?? 0;
            $cart['auto_coupon_message']  = null;
            Session::put('cart', $cart);
            self::applyAutoCoupons($cart);
            return;
        }
        $fullPriceSubtotal  = 0;
        $discountedSubtotal = 0;
        foreach ($cart['items'] ?? [] as $item) {
            $qty     = $item['qty'] ?? 1;
            $price   = $item['price'] ?? 0;
            $original = $item['original_price'] ?? $price;

            if ($original > $price && $price > 0) {
                $discountedSubtotal += $price * $qty;
            } else {
                $fullPriceSubtotal += $price * $qty;
            }
        }

        $currency = getSetting('currency');

        if ($coupon->auto_apply == 1) {
            self::applyAutoCoupons($cart);
            return;
        }
        $isValid =
            $fullPriceSubtotal >= $coupon->cart_minimum &&
            $coupon->end_date >= now() &&
            $coupon->num_of_coupons > $coupon->no_of_discount;

        if (!$isValid) {
            $cart['discount']             = 0;
            $cart['coupon_code']          = null;
            $cart['total_after_discount'] = $fullPriceSubtotal + $discountedSubtotal;
            $cart['item_removed']         = 1;

            if ($coupon->products != '') {
                $freeProducts = json_decode($coupon->products, true) ?? [];
                if (is_array($freeProducts)) {
                    foreach ($freeProducts as $productId) {
                        foreach ($cart['items'] as $key => $item) {
                            if (($item['id'] ?? null) == $productId && ($item['price'] ?? 0) == 0) {
                                unset($cart['items'][$key]);
                                break;
                            }
                        }
                    }
                    $cart['items'] = array_values($cart['items']);
                }
            }

            if ($fullPriceSubtotal < $coupon->cart_minimum) {
                return [
                    'success' => false,
                    'message' => "Add more full-price items! Minimum {$coupon->cart_minimum}  required (already discounted items don't count towards minimum)."
                ];
            }

            Session::put('cart', $cart);
            self::applyAutoCoupons($cart);
            return;
        }
        $discount = 0;
        if ($coupon->type === 'amount') {
            $discount = $coupon->discount;
        } elseif ($coupon->type === 'percentage') {
            $discount = ($fullPriceSubtotal * $coupon->discount) / 100;
        }
        $cart['discount']             = $discount;
        $cart['total_after_discount'] = $fullPriceSubtotal - $discount + $discountedSubtotal;
        $cart['auto_coupon_message']  = null; // success → clear message

        Session::put('cart', $cart);
    }

    /**
     * Store validated checkout contact on the cart session for guest tracking (pixels, hashed identifiers, etc.).
     */
    public static function mergeGuestContact(?string $email, ?string $phone, ?string $country = null): void
    {
        if (!Session::has('cart')) {
            return;
        }
        $cart = Session::get('cart');
        if (!is_array($cart)) {
            return;
        }
        if ($email !== null && $email !== '') {
            $cart['email'] = trim($email);
        }
        if ($phone !== null && $phone !== '') {
            $cart['phone'] = trim((string) $phone);
        }
        if ($country !== null && $country !== '') {
            $cart['country'] = trim((string) $country);
        }
        Session::put('cart', $cart);
    }
}
