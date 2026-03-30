<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShapesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shapes')->truncate();
        $shapes = [
            'bottle', 'skull', 'circle', 'heart', 'fruit', 'crescent',
            'half moon', 'string', 'sphere', 'cube', 'square', 
            'oval', 'cylinder', 'diamond', 'triangle', 'star', 
            'banana', 'key', 'rectangle', 'strips', 'twisted', 
            'smileys', 'animals', 'characters'
        ];

        foreach ($shapes as $shape) {
            DB::table('shapes')->insert(['name' => $shape]);
        }
    }
}
