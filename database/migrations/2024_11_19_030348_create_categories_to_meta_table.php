<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesToMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_to_meta', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->unsignedBigInteger('cid'); // Foreign key referencing the categories table
            $table->string('title'); // Meta title
            $table->text('description')->nullable(); // Meta description, nullable
            $table->text('keywords')->nullable(); // Meta keywords, nullable
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
        Schema::dropIfExists('categories_to_meta');
    }
}
