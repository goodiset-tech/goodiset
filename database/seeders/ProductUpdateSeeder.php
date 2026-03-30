<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductUpdateSeeder extends Seeder
{
    public function run()
    {
        $products = [
            'selling_price' => null,
            'shipping_price' => null,
        ];
        $product = [
            'discount_price' => 20,
            'weight' => 100,
        ];
        
        
        DB::table('products')->update($products);
        DB::table('products')->where('format', 1)->update($product);
    }
}