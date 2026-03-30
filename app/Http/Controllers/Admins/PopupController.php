<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PopupController extends Controller
{
    public function index()
    {
        $popup = Popup::first(); // Only one popup is allowed
        return view('admins.popup.index', compact('popup'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:0,1',
        ]);

        $popup = Popup::first();
        $data = $request->only(['start_date', 'end_date', 'status']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $directory = public_path('images/popups/');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            // Delete old image if it exists
            if ($popup && $popup->image && File::exists(public_path($popup->image))) {
                File::delete(public_path($popup->image));
            }

            $file = $request->file('image');
            $extension = 'webp';
            $name = time() . '.' . $extension;
            $file->move($directory, $name);
            $data['image'] = 'images/popups/' . $name;
        }

        if ($popup) {
            // Update existing popup
            $popup->update($data);
        } else {
            // Create new popup (only one will exist)
            Popup::create($data);
        }

        return redirect()->route('admins.popup')->with([
            'msg' => 'Popup saved successfully.',
            'msg_type' => 'success'
        ]);
    }

    public function destroy()
    {
        $popup = Popup::first();
        if ($popup) {
            // Delete image file if exists
            if ($popup->image && File::exists(public_path($popup->image))) {
                File::delete(public_path($popup->image));
            }
            $popup->delete();
        }

        return redirect()->route('admins.popup')->with('success', 'Popup deleted successfully.');
    }
}
