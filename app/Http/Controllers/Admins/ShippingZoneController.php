<?php
namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ShippingZone;
use App\Models\Country;
use Illuminate\Http\Request;

class ShippingZoneController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::all();
        return view('admins.shipping_zones.index', compact('zones'));
    }

    public function create()
    {
        $countries = Country::all();
        $cities = City::all();
        return view('admins.shipping_zones.create', compact('countries','cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'countries' => 'required|array',
            'cities' => 'nullable|array'
        ]);

        ShippingZone::create([
            'name' => $request->name,
            'countries' => json_encode($request->countries),
            'cities' => json_encode($request->cities)
        ]);

        return redirect()->route('admins.shipping-zones.index')->with('success', 'Shipping zone created successfully.');
    }

    public function edit(ShippingZone $shippingZone)
    {
        $countries = Country::all();
        return view('admins.shipping_zones.edit', compact('shippingZone', 'countries'));
    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
        $request->validate([
            'name' => 'required',
            'countries' => 'required|array',
            'cities' => 'nullable|array'
        ]);

        $shippingZone->update([
            'name' => $request->name,
            'countries' => json_encode($request->countries),
            'cities' => json_encode($request->cities)
        ]);

        return redirect()->route('admins.shipping-zones.index')->with('success', 'Shipping zone updated successfully.');
    }

    public function destroy(ShippingZone $shippingZone)
    {
        $shippingZone->delete();
        return redirect()->route('admins.shipping-zones.index')->with('success', 'Shipping zone deleted successfully.');
    }
}