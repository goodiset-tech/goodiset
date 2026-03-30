<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySortNoDefaultInCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Change existing sort_no column to have default value of 0
            $table->integer('sort_no')->default(0)->nullable(false)->change();
            
            // Update existing null values to 0
            \DB::statement('UPDATE categories SET sort_no = 0 WHERE sort_no IS NULL');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Revert back to nullable with no default
            $table->integer('sort_no')->nullable()->default(null)->change();
        });
    }
}