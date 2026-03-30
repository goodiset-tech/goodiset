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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['pickup', 'dropoff']); // Warehouse type
            $table->string('location_name')->nullable(); // Human-readable location name
            $table->string('address'); // Address from Google Maps
            $table->decimal('latitude', 10, 7); // Latitude from Google Maps
            $table->decimal('longitude', 10, 7); // Longitude from Google Maps
            $table->string('contact_name'); // Contact person name
            $table->string('contact_email'); // Contact person email
            $table->string('contact_phone'); // Contact person phone
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
