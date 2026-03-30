<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventory_request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_request_id'); // Foreign key to inventory_requests
            $table->unsignedBigInteger('product_id'); // Product being requested
            $table->integer('quantity'); // Quantity of the product
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_request_items');
    }
};
