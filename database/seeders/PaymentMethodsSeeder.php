<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentMethod;

class PaymentMethodsSeeder extends Seeder
{
    public function run()
    {
        DB::table('payment_methods')->truncate();
        $paymentMethods = [
            [
                'method_name' => 'Ngenius',
                'is_enabled' => '1',
                'details' => 'Default Credit/Debit Card settings',
            ],
            [
                'method_name' => 'Stripe',
                'is_enabled' => '1',
                'details' => 'Default Credit/Debit Card settings',
            ],
            [
                'method_name' => 'Cod',
                'is_enabled' => '1',
                'details' => 'Default Cash on Delivery settings',
            ],
            [
                'method_name' => 'Google Pay',
                'is_enabled' => '0',
                'details' => 'Default Google Pay settings',
            ],
            [
                'method_name' => 'Apple Pay',
                'is_enabled' => '0',
                'details' => 'Default Apple Pay settings',
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::Create(
                [
                    'method_name' => $method['method_name'],
                    'is_enabled' => $method['is_enabled'],
                    'details' => $method['details']
                ]
            );
        }

    }
}
