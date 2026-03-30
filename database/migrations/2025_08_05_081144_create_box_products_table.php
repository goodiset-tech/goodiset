<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxProductsTable extends Migration
{
    public function up()
    {
        Schema::create('box_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('box_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->float('percentage');
            $table->integer('pieces');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('box_products');
    }
}