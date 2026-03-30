<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['amount', 'percentage', 'item']);
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('cart_minimum', 10, 2)->default(0);
            $table->json('product_ids')->nullable();
            $table->json('free_product_ids')->nullable();
            $table->enum('customer_type', ['new', 'anyone'])->default('anyone');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
};

