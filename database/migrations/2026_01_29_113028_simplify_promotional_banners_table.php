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
        Schema::table('promotional_banners', function (Blueprint $table) {
            $table->renameColumn('desktop_image', 'image');
            $table->dropColumn('mobile_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotional_banners', function (Blueprint $table) {
            $table->renameColumn('image', 'desktop_image');
            $table->string('mobile_image')->nullable();
        });
    }
};
