<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::all();
        return view('product_types.index', compact('productTypes'));
    }

    public function create()
    {
        return view('product_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ProductType::create($request->all());

        return redirect()->route('product_types.index')->with('success', 'Product Type created successfully.');
    }

    public function show(ProductType $productType)
    {
        return view('product_types.show', compact('productType'));
    }

    public function edit(ProductType $productType)
    {
        return view('product_types.edit', compact('productType'));
    }

    public function update(Request $request, ProductType $productType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $productType->update($request->all());

        return redirect()->route('product_types.index')->with('success', 'Product Type updated successfully.');
    }

    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return redirect()->route('product_types.index')->with('success', 'Product Type deleted successfully.');
    }
}
