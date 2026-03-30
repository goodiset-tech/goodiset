<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Admins\Product;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        return view('admins.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $products = Product::where('status',1)->get();
        return view('admins.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:amount,percentage,item',
            'discount' => 'nullable|numeric|min:0',
            'cart_minimum' => 'required|numeric|min:0',
            'products' => 'nullable|array',
            'free_products' => 'nullable|array',
            'customer_type' => 'required|in:new,anyone',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        Promotion::create([
            'name' => $request->name,
            'type' => $request->type,
            'discount' => $request->discount,
            'cart_minimum' => $request->cart_minimum,
            'product_ids' => json_encode($request->products),
            'free_product_ids' => json_encode($request->free_products),
            'customer_type' => $request->customer_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admins.promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        $products = Product::where('status',1)->get();
        return view('admins.promotions.edit', compact('promotion', 'products'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:amount,percentage,item',
            'discount' => 'nullable|numeric|min:0',
            'cart_minimum' => 'required|numeric|min:0',
            'products' => 'nullable|array',
            'status' => 'required|boolean',
        ]);

        $promotion->update([
            'name' => $request->name,
            'type' => $request->type,
            'discount' => $request->discount,
            'cart_minimum' => $request->cart_minimum,
            'product_ids' => json_encode($request->products),
            'status' => $request->status,
        ]);

        return redirect()->route('admins.promotions.index')->with('success', 'Promotion updated successfully.');
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        return redirect()->route('admins.promotions.index')->with('success', 'Promotion deleted successfully.');
    }
}

