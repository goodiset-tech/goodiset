<?php

namespace App\Http\Controllers;

use App\Models\Admins\LogReport;
use App\Models\Admins\Order;
use App\Models\Admins\Product;
use App\Models\BoxCustomize;
use App\Models\BoxSize;
use App\Models\PackageType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DriverController extends Controller
{
    public function showOrder($token)
    {
        $order = Order::where('driver_token', $token)->firstOrFail();
        
        return view('driver.order', compact('order'));
    }

    public function updateStatus(Request $request, $token)
    {
        $order = Order::where('driver_token', $token)->firstOrFail();
        $oldValues = [];
        $newValues = [];
        $originalAttributes = $order->getAttributes();
        $request->validate([
            'dstatus' => 'required|in:0,1,2,3,4'
        ]);

        $order->dstatus = $request->dstatus;
        
        foreach ($originalAttributes as $key => $oldValue) {
            if ($order->$key != $oldValue) {
                $oldValues[$key] = $oldValue; // Store only changed old values
                $newValues[$key] = $order->$key; // Store new values
            }
        }
        $order->save();

        $changes = [
            'old' => $oldValues,
            'new' => $newValues, // Only changed attributes
        ];

        $logs = new LogReport();

        $data = [
            'type' => 'ORDER',
            'type_id' => $order->id,
            'message' => 'The status of Order No:<b>' . $order->order_no . '</b> changed to <b>' . $this->getOrderStatus($order->dstatus) . '</b> by user:<b>Driver</b>',
            'user_id' => '18794',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'changes' => json_encode($changes, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $logs->addLog($data);

        return redirect()->back()->with('success', 'Status updated successfully');
    }
    public function getOrderStatus($status)
    {
        $statusArray = [
            0 => 'Pending',
            1 => 'Confirmed',
            2 => 'Delivered',
            3 => 'Cancel',
            4 => 'Dispatched',
        ];
        return $statusArray[$status] ?? 'Unknown Status';
    }
}