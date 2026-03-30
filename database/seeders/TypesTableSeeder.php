<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->truncate();
        $types = [
            'nougats', 'jellies', 'caramels', 'fondants', 'hard candies','sugar dusted','no sugar dusted','glazed','no glaze'
        ];

        foreach ($types as $type) {
            DB::table('types')->insert(['name' => $type]);
        }
    }
}
