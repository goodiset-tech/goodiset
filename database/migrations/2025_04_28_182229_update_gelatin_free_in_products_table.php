<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateGelatinFreeInProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all products and set gelatin_free to 1
        DB::table('products')->update(['gelatin_free' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally, you can reset it to 0 or null (depending on your need)
        DB::table('products')->update(['gelatin_free' => 0]);
    }
}
