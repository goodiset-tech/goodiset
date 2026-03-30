<?php

namespace Database\Seeders;

use App\Models\Format;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create multiple formats
        DB::table('formats')->truncate();
        Format::create(['name' => 'Pick & Mix']);
        Format::create(['name' => 'Individual']);
        Format::create(['name' => 'Bundle']);
    }
}
