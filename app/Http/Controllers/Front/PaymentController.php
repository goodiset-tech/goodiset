<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createNgeniusSession(Request $request)
    {
        $amount = $request->amount * 100; // Convert to smallest currency unit
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('NGENIUS_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('NGENIUS_BASE_URL') . '/orders', [
            'action' => 'SALE',
            'amount' => [
                'currencyCode' => 'AED',
                'value' => $amount,
            ],
            'merchantAttributes' => [
                'redirectUrl' => env('NGENIUS_REDIRECT_URL'),
            ],
        ]);
        //dd($response);

        if ($response->successful()) {
            $data = $response->json();
            return response()->json([
                'success' => true,
                'payment_url' => $data['_links']['payment']['href'],
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to create NGENIUS session.']);
    }
}
