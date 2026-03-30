<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingMethod;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $shippingMethods = ShippingMethod::all();
        return response()->json($shippingMethods);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_default' => 'boolean'
        ]);
    
        if ($request->is_default) {
            ShippingMethod::setDefault(null); // Remove default from others
        }
    
        $method = ShippingMethod::create([
            'name' => $request->name,
            'enabled' => $request->enabled ?? true,
            'is_default' => $request->is_default ?? false
        ]);
    
        return response()->json(['message' => 'Shipping method added!', 'method' => $method]);
    }
    
    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'is_default' => 'boolean'
        // ]);
    
        if ($request->is_default) {
            ShippingMethod::setDefault($shippingMethod->id);
            return response()->json(['message' => 'Shipping method updated!', 'method' => $shippingMethod]);
        }
    
        $shippingMethod->update([
            'name' => $request->name,
            'enabled' => $request->enabled ?? true,
            'is_default' => $request->is_default ?? false
        ]);
    
        return response()->json(['message' => 'Shipping method updated!', 'method' => $shippingMethod]);
    }
    

    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        return response()->json(['message' => 'Shipping method deleted!']);
    }
}
