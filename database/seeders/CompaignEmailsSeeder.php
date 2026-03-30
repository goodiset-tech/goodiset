<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admins\CompaignEmail;

class CompaignEmailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CompaignEmail::truncate();

        $csvFile = fopen(base_path("database/data/final_sheet.csv"), "r");

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== false) {

            if (!$firstline) {

                CompaignEmail::create([

                    "id" => $data['0'],
                    "email" => $data['1'],
                    "name" => $data['2'],
                    "guests" => $data['3'],
                    "time" => $data['4'],
                    "created_at" => $data['5'],

                ]);

            }

            $firstline = false;

        }

        fclose($csvFile);
    }
}
