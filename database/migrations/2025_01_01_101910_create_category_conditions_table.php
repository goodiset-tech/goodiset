<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_conditions', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->default(0);
            $table->string('type'); // Example: Price, Weight
            $table->string('condition'); // Example: =, !=, >, <
            $table->string('condition_value'); // Example: 100, 200
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_conditions');
    }
};
