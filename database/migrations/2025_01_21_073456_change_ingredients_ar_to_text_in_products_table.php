<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIngredientsArToTextInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('ingredients_ar')->nullable()->change();
        });

        // Optional: Update existing NULL values to a default value
        DB::table('products')->whereNull('ingredients_ar')->update(['ingredients_ar' => '']);
        
        Schema::table('products', function (Blueprint $table) {
            $table->text('ingredients_ar')->nullable(false)->change();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('ingredients_ar', 255)->change();
        });
    }
}
