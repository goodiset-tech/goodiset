<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Countries::all();
        return view('admins.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admins.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'min_order' => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'free_shipping' => 'required|numeric',
            'shipping_time' => 'required',
        ]);
    
        Countries::create($request->all());
        return redirect()->route('admins.countries.index')->with('success', 'Country created successfully.');
    }

    public function edit(Countries $country)
    {
        return view('admins.countries.edit', compact('country'));
    }

    public function update(Request $request, Countries $country)
    {
        $request->validate([
            'name' => 'required|string',
            'min_order' => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'free_shipping' => 'required|numeric',
            'shipping_time' => 'required',
        ]);
        $country->update($request->all());
        return redirect()->route('admins.countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Countries $country)
    {
        $country->delete();
        return redirect()->route('admins.countries.index')->with('success', 'Country deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {

        $country = Countries::findOrFail($request->country_id);
        $country->status = $request->Status;
        $country->save();

        return response()->json([
            'msg' => 'Status updated successfully',
            'msg_type' => 'success'
        ]);
    }
}
