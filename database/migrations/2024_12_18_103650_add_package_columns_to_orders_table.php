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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable(); // Adjust position if needed
            $table->unsignedBigInteger('package_size_id')->nullable()->after('package_id');
            $table->string('package_name')->nullable()->after('package_size_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['package_id', 'package_size_id', 'package_name']);
        });
    }
};
