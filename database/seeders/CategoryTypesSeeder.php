<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryTypes = [
            // 'Category',
            // 'Format',
            // 'Title',
            // 'Made in',
            // 'Brand',
            // 'Tag',
            // 'Price',
            // 'Theme',
            // 'Flavour',
            // 'Color',
            // 'Ingredients',
            // 'Allergens',
            // 'Weight',
            'Sku no',
        ];

        foreach ($categoryTypes as $type) {
            DB::table('category_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
