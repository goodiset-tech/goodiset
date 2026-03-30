<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admins\Product;
use App\Models\Admins\Category;
use App\Models\Admins\CategoryCondition;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        $products = Product::all(); // Fetch products for selection
        return view('admins.offers.index', compact('offers', 'products'));
    }

    public function create()
    {
        $offers = Offer::all();
        $products = Product::where('status', 1)->whereNull('selling_price')->get();
        return view('admins.offers.create', compact('offers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_type' => 'required|in:amount,percentage',
            'discount' => 'required|numeric|min:0',
            'products' => 'required|array',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $offer = Offer::create([
            'name' => $request->name,
            'type' => $request->discount_type,
            'discount' => $request->discount,
            'product_ids' => json_encode($request->products),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 1,
        ]);

        $this->applyOrRevertDiscount($offer, $request->input('apply_on_discounted', 0));

        return redirect()->route('admins.offers.index')->with(
            [
                'msg' => 'Offer created successfully.',
                'msg_type' => 'success',
            ]
        );
    }

    public function edit($id)
    {
        $edit = Offer::findOrFail($id);
        $offers = Offer::all();
        $products = Product::where('status', 1)->get();
        return view('admins.offers.create', compact('edit', 'offers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $oldProductIds = json_decode($offer->product_ids, true) ?? [];
        $newProductIds = $request->products;
        $diffProductIds = array_diff($oldProductIds, $newProductIds);

        if (!empty($diffProductIds)) {
            $diffProductIds = Product::whereIn('id', $diffProductIds)->get();
            foreach ($diffProductIds as $product) {
                if ($product->original_price) {
                    $originalPrice = ($product->original_price > $product->selling_price) ? $product->original_price : $product->selling_price;
                    $product->discount_price = $originalPrice;
                }
                $product->selling_price = null;
                $product->original_price = null;
                $product->save();
            }
        }

        $offer->update([
            'name' => $request->name,
            'type' => $request->discount_type,
            'discount' => $request->discount,
            'product_ids' => json_encode($request->products),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);
        $this->applyOrRevertDiscount($offer, $request->input('apply_on_discounted', 0));

        return redirect()->route('admins.offers.index')->with(
            [
                'msg' => 'Offer updated successfully.',
                'msg_type' => 'success',
            ]
        );
    }

    private function applyOrRevertDiscount($offer, $applyOnDiscounted = 0)
    {
        $productIds = json_decode($offer->product_ids, true);
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $originalPrice = ($product->original_price > $product->selling_price) ? $product->original_price  : $product->selling_price ?? $product->discount_price;

            // Check if user wants to apply on already discounted products (Use selling_price as base)
            if ($applyOnDiscounted == 1 && $product->original_price == null) {
                $originalPrice = $product->selling_price;
            }

            // Check if the offer is active and within the valid date range
            if ($offer->status == 1 && $offer->start_date <= now() && $offer->end_date >= now()) {

                // Skip if user doesn't want to apply on already discounted products and product is already discounted
                if ($applyOnDiscounted == 0 && $product->selling_price != null) {
                    continue;
                }

                // Apply the discount
                if ($offer->type == 'amount') {
                    $discountedPrice = $originalPrice - $offer->discount;
                } elseif ($offer->type == 'percentage') {
                    $discountedPrice = $originalPrice - ($originalPrice * ($offer->discount / 100));
                }

                $product->discount_price = $discountedPrice;
                $product->selling_price = $originalPrice;
                $product->original_price = $originalPrice;
            } else {
                // Revert to the original price
                $product->discount_price = ($product->original_price > $product->selling_price) ? $product->original_price  : $product->selling_price;
                $product->selling_price = null;
                $product->original_price = null;
            }

            $product->save();
        }
    }

    public function revertExpiredOrInactiveOffers()
    {
        $offers = Offer::where('status', 0)
            ->orWhere('end_date', '<', now())
            ->get();

        foreach ($offers as $offer) {
            $this->applyOrRevertDiscount($offer);
        }

        return redirect()->route('admins.offers.index')->with(
            [
                'msg' => 'Prices reverted for expired or inactive offers.',
                'msg_type' => 'success',
            ]
        );
    }

    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $oldProductIds = json_decode($offer->product_ids, true) ?? [];
        if (!empty($oldProductIds)) {
            $oldProductIds = Product::whereIn('id', $oldProductIds)->get();
            foreach ($oldProductIds as $product) {
                if ($product->original_price) {
                    $product->discount_price = $product->original_price;
                }
                $product->selling_price = null;
                $product->original_price = null;
                $product->save();
            }
        }
        $offer->delete();

        return redirect()->route('admins.offers.index')->with(
            [
                'msg' => 'Offer deleted successfully.',
                'msg_type' => 'success',
            ]
        );
    }

    public function getProductsByCategory(Request $request)
    {
        $category_id = $request->category_id;
        if ($category_id == 'all') {
            $products = Product::where('status', 1)->get();
            return response()->json(['products' => $products]);
        }

        $category = Category::find($category_id);

        if (!$category) {
            return response()->json(['products' => []]);
        }

        $query = Product::where('status', 1);

        if (isset($category->is_manual) && $category->is_manual == 2) {
            // Smart Category Logic
            $conditions = CategoryCondition::where('category_id', $category_id)->get();

            if ($conditions->count() > 0) {
                foreach ($conditions as $val) {
                    $method = $category->is_condition == 2 ? 'orWhere' : 'where';
                    $conditionValue = $val->condition_value;

                    switch (trim($val->type)) {
                        case 'Price':
                            $query->$method('discount_price', $val->condition, intval($conditionValue));
                            break;
                        case 'Format':
                            $query->$method('format', $val->condition, intval($conditionValue));
                            break;
                        case 'Tag':
                            $tags = explode(',', $conditionValue);
                            foreach ($tags as $tag) {
                                $query->$method('tags', 'LIKE', '%' . trim($tag) . '%');
                            }
                            break;
                        case 'Title':
                            $query->$method('product_name', $val->condition, $conditionValue);
                            break;
                        case 'Products':
                            $ids = explode(',', $conditionValue);
                            $query->whereIn('id', $ids);
                            break;
                        case 'Made in':
                            $query->$method('country', $val->condition, intval($conditionValue));
                            break;
                        case 'Brand':
                            $query->$method('brand_id', $val->condition, intval($conditionValue));
                            break;
                        case 'Theme':
                            $query->$method('theme_id', $val->condition, intval($conditionValue));
                            break;
                        case 'Flavour':
                            $query->$method('flavour_id', $val->condition, intval($conditionValue));
                            break;
                        case 'Color':
                            $query->$method('product_color', $val->condition, intval($conditionValue));
                            break;
                        case 'Allergens':
                            $query->$method('allergen', $val->condition, intval($conditionValue));
                            break;
                        case 'Weight':
                            $query->$method('weight', $val->condition, $conditionValue);
                            break;
                    }
                }
            }
        } else {
            // Manual Category Logic
            $query->whereRaw("? = ANY(string_to_array(category_id, ','))", [$category_id]);
        }

        $products = $query->get();
        $products->transform(function ($product) {

            $activeOffer = Offer::where('status', 1)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->get()
                ->filter(function ($offer) use ($product) {
                    $productIds = json_decode($offer->product_ids, true) ?? [];
                    return in_array($product->id, $productIds);
                })->first();

            $is_on_discount = false;
            if ($activeOffer) {
                $is_on_discount = true;
            } else if ($product->selling_price != null && $product->discount_price < $product->selling_price) {
                $is_on_discount = true;
            }

            $product->is_on_discount = $is_on_discount;
            return $product;
        });

        return response()->json(['products' => $products]);
    }
}
