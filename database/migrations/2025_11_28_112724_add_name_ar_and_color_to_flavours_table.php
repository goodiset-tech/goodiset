<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('flavours', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('color')->nullable()->after('name_ar');
        });
    }

    public function down(): void
    {
        Schema::table('flavours', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'color']);
        });
    }
};
