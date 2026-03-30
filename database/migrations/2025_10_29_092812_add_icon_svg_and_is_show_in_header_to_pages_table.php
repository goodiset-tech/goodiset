<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // store uploaded SVG path, e.g., "icons/yourfile.svg"
            $table->string('icon_svg')->nullable()->after('slug');
            $table->boolean('is_show_in_header')->default(false)->after('icon_svg');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['icon_svg', 'is_show_in_header']);
        });
    }
};
