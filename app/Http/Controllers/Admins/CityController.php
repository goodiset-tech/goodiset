<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Countries;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->get();
        return view('admins.cities.index', compact('cities'));
    }

    public function create()
    {
        $countries = Countries::all();
        return view('admins.cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required',
            'min_order' => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'free_shipping' => 'required|numeric',
            'shipping_time' => 'required',
        ]);

        City::create($request->all());

        return redirect()->route('admins.cities.index')->with('success', 'City created successfully.');
    }

    public function edit(City $city)
    {
        $countries = Countries::all();
        return view('admins.cities.edit', compact('city', 'countries'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required',
            'min_order' => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'free_shipping' => 'required|numeric',
            'shipping_time' => 'required',
        ]);

        $city->update($request->all());

        return redirect()->route('admins.cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('admins.cities.index')->with('success', 'City deleted successfully.');
    }
    public function toggleStatus(Request $request)
    {

        $City = City::findOrFail($request->city_id);
        $City->status = $request->Status;
        $City->save();

        return response()->json([
            'msg' => 'Status updated successfully',
            'msg_type' => 'success'
        ]);
    }
}
