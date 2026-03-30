<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('name'); // Category name
            $table->string('slug')->unique(); // Unique slug for the category
            $table->string('image')->nullable(); // Image file path, nullable
            $table->string('title')->nullable(); // Meta title, nullable
            $table->text('description')->nullable(); // Meta description, nullable
            $table->text('keywords')->nullable(); // Meta keywords, nullable
            $table->BigInteger('status')->default(1); // Status, default to '1'
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}

