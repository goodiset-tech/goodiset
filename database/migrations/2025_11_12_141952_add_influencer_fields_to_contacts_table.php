<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->string('influencer_platform')->nullable()->after('id');
            $table->string('follower_count')->nullable()->after('influencer_platform');
            $table->string('username')->nullable()->after('follower_count');
        });
    }

    public function down(): void
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->dropColumn(['influencer_platform', 'follower_count', 'username']);
        });
    }
};
