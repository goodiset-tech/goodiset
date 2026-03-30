<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTypeConditionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $conditions = [
            ['name' => 'is equal to', 'value' => '='],
            ['name' => 'is not equal to', 'value' => '!='],
            ['name' => 'is greater than', 'value' => '>'],
            ['name' => 'is less than', 'value' => '<']
        ];

        foreach ($conditions as $condition) {
            DB::table('category_type_conditions')->insert([
                'name' => $condition['name'],
                'value' => $condition['value'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}