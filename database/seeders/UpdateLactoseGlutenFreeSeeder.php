<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateLactoseGlutenFreeSeeder extends Seeder
{
    /**
     * Run the database seeds..
     */
    public function run(): void
    {
        DB::table('products')
            ->where('format', 1)
            ->update([
                'lactose_free' => 0,
                'gluten_free' => 0,
            ]);
    }
}
