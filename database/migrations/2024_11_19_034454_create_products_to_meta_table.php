<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsToMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_to_meta', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->unsignedBigInteger('pid'); // Foreign key for product
            $table->string('title'); // Meta title for the product
            $table->text('description')->nullable(); // Meta description for the product (optional)
            $table->text('keywords')->nullable(); // Meta keywords for the product (optional)
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
        Schema::dropIfExists('products_to_meta');
    }
}

