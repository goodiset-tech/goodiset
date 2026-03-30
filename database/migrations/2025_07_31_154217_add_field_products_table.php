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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight_per_unit', 8, 2)->nullable()->comment('Weight per unit in grams')->after('id');
            $table->integer('no_of_unit')->nullable()->comment('Number of units')->after('weight_per_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight_per_unit', 'no_of_unit']);
        });
    }
};