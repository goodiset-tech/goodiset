<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderNotificationEmail;
use App\Models\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderNotificationController extends Controller
{
    public function index()
    {
        $notifications = OrderNotification::latest()->get();
        return view('admins.order_notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admins.order_notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $notification = OrderNotification::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => 'pending',
        ]);

        return redirect()->route('admins.order_notifications.index')->with('success', 'Notification created and email sent.');
    }

    public function edit($id)
    {
        $notification = OrderNotification::findOrFail($id);
        return view('admins.order_notifications.edit', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'status' => 'required',
        ]);

        $notification = OrderNotification::findOrFail($id);
        $notification->update($request->only('name', 'email', 'status'));

        return redirect()->route('admins.order_notifications.index')->with('success', 'Notification updated.');
    }

    public function destroy($id)
    {
        $notification = OrderNotification::findOrFail($id);
        $notification->delete();
        return redirect()->route('admins.order_notifications.index')->with('success', 'Notification deleted.');
    }

    public function toggleStatus(Request $request)
    {
        $notification = OrderNotification::findOrFail($request->notification_id);
        $notification->status = $request->status;
        $notification->save();

        return response()->json(['msg' => 'Status updated successfully', 'msg_type' => 'success']);
    }
}