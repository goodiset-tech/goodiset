<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    public function index()
    {
        $rates = ShippingRate::with(['zone', 'method'])->get();
        return view('admins.shipping_rates.index', compact('rates'));
    }

    public function create()
    {
        $zones = ShippingZone::all();
        $methods = ShippingMethod::all();
        return view('admins.shipping_rates.create', compact('zones', 'methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'condition_type' => 'nullable|in:weight,price,none',
            'min_value' => 'nullable|numeric',
            'max_value' => 'nullable|numeric',
            'rate' => 'required|numeric',
        ]);

        ShippingRate::create($request->all());

        return redirect()->route('admins.shipping-rates.index')->with('success', 'Shipping rate created successfully.');
    }

    public function edit(ShippingRate $shippingRate)
    {
        $zones = ShippingZone::all();
        $methods = ShippingMethod::all();
        return view('admins.shipping_rates.edit', compact('shippingRate', 'zones', 'methods'));
    }

    public function update(Request $request, ShippingRate $shippingRate)
    {
        $request->validate([
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'condition_type' => 'nullable|in:weight,price,none',
            'min_value' => 'nullable|numeric',
            'max_value' => 'nullable|numeric',
            'rate' => 'required|numeric',
        ]);

        $shippingRate->update($request->all());

        return redirect()->route('admins.shipping-rates.index')->with('success', 'Shipping rate updated successfully.');
    }

    public function destroy(ShippingRate $shippingRate)
    {
        $shippingRate->delete();
        return redirect()->route('admins.shipping-rates.index')->with('success', 'Shipping rate deleted successfully.');
    }
}