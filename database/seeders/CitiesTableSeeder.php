<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Countries;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citiesByCountry = [
            "United Arab Emirates" =>["Abu Dhabi", "Dubai", "Sharjah", "Ajman", "Umm Al-Quwain", "Ras Al Khaimah", "Fujairah"],
            "Saudi Arabia" =>["Riyadh", "Jeddah", "Mecca", "Medina", "Dammam", "Khobar"],
            "Kuwait" =>["Kuwait City"],
            "Bahrain" => ["Manama", "Muharraq"],
            "Qatar" => ["Doha", "Al Wakrah", "Al Khor"],
            "Oman" =>["Muscat", "Salalah", "Sohar", "Nizwa"]
        ];
    
        foreach ($citiesByCountry as $countryName => $cities) {
            $country = Countries::where('name', $countryName)->first();
            foreach ($cities as $cityName) {
                City::firstOrCreate([
                    'country_id' => $country->id,
                    'name' => $cityName,
                ]);
            }
        }
    }
}
