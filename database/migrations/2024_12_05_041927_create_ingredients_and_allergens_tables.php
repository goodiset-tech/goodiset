<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsAndAllergensTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the ingredients table
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Name column
            $table->timestamps(); // Timestamps (created_at and updated_at)
        });

        // Create the allergens table
        Schema::create('allergens', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Name column
            $table->timestamps(); // Timestamps (created_at and updated_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the allergens table
        Schema::dropIfExists('allergens');

        // Drop the ingredients table
        Schema::dropIfExists('ingredients');
    }
}
