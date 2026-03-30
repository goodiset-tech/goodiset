<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class LocationsController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('admins.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admins.locations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'location_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'open_close_time' => 'nullable|string|max:255',
            'google_place_id' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $directory = public_path('/images/locations/');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            $file = $request->file('image');
            $extension = 'webp';
            $name = time() . '.' . $extension;
            $file->move($directory, $name);
            $data['image'] = 'images/locations/' . $name;
        }

        Location::create($data);

        return redirect()->route('admins.locations.index')->with([
            'msg' => 'Location created successfully.',
            'msg_type' => 'success'
        ]);
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('admins.locations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'location_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'open_close_time' => 'nullable|string|max:255',
            'google_place_id' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $location = Location::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $directory = public_path('/images/locations/');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            $file = $request->file('image');
            $extension = 'webp';
            $name = time() . '.' . $extension;
            $file->move($directory, $name);
            $data['image'] = 'images/locations/' . $name;

            // Delete the old image if it exists
            if ($location->image && file_exists(public_path($location->image))) {
                unlink(public_path($location->image));
            }
        }

        $location->update($data);

        return redirect()->route('admins.locations.index')->with([
            'msg' => 'Location updated successfully.',
            'msg_type' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        // Delete the image file if it exists
        if ($location->image && file_exists(public_path($location->image))) {
            unlink(public_path($location->image));
        }

        $location->delete();

        return redirect()->route('admins.locations.index')->with([
            'msg' => 'Location deleted successfully.',
            'msg_type' => 'success'
        ]);
    }
}