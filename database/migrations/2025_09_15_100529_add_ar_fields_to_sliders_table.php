<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('button_ar')->nullable()->after('button');
            $table->string('heading_ar')->nullable()->after('heading');
            $table->longText('paragraph_ar')->nullable()->after('paragraph');
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['button_ar', 'heading_ar', 'paragraph_ar']);
        });
    }
};
