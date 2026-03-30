<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetGlutenAndLactoseFreeZeroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->update([
            'gluten_free'  => 0,
            'lactose_free' => 0,
        ]);
    }
}
