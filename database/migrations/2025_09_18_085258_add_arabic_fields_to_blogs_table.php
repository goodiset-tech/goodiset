<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title_ar', 255)->nullable()->after('title');
            $table->text('content_ar')->nullable()->after('content');
            $table->string('short_description_ar', 500)->nullable()->after('short_description');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'content_ar', 'short_description_ar']);
        });
    }
};
