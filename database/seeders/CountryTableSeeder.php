<?php

namespace Database\Seeders;

use App\Models\Countries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $countries = [
            ['name' => 'United Arab Emirates'],
            ['name' => 'Saudi Arabia'],
            ['name' => 'Kuwait'],
            ['name' => 'Bahrain'],
            ['name' => 'Qatar'],
            ['name' => 'Oman'],
        ];

        foreach ($countries as $country) {
            Countries::create($country);
        }
    }
}
