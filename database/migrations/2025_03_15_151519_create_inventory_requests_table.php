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
        Schema::create('inventory_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pickup_warehouse_id'); // Pickup warehouse
            $table->unsignedBigInteger('dropoff_warehouse_id'); // Dropoff warehouse
            $table->string('status')->default('pending'); // Request status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_requests');
    }
};
