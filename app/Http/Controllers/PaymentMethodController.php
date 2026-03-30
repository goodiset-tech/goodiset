<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function getSettings($method)
    {
        $setting = PaymentMethod::where('method_name', $method)->first();

        if (!$setting) {
            // Return default settings if none exist
            return response()->json([
                'method_name' => $setting->method_name,
                'enabled' => $setting->is_enabled,
                'details' => $setting->details,
            ]);
        }

        return response()->json($setting);
    }

    // Save payment settings
    public function saveSettings(Request $request)
    {
        try {
            $data = $request->validate([
                'payment_method' => 'required|string',
                'enabled' => 'required|boolean',
                'details' => 'nullable|string',
            ]);

            PaymentMethod::updateOrCreate(
                [
                    'method_name' => $data['payment_method']
                ],
                [
                    'is_enabled' => $data['enabled'],
                    'details' => $data['details']
                ]
            );

            return response()->json(['success' => true, 'message' => 'Settings saved successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving settings.',
                'error' => $e->getMessage() // For debugging purposes, remove in production
            ], 500);
        }
    }

}
