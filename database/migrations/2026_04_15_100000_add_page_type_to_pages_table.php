<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (Schema::hasColumn('categories', 'partner_menu_link')) {
                    $table->dropColumn('partner_menu_link');
                }
                if (Schema::hasColumn('categories', 'partner_menu')) {
                    $table->dropColumn('partner_menu');
                }
            });
        }

        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'page_type')) {
                $table->string('page_type', 64)->nullable()->after('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'page_type')) {
                $table->dropColumn('page_type');
            }
        });

        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'partner_menu')) {
                    $table->integer('partner_menu')->default(0);
                    $table->string('partner_menu_link', 512)->nullable();
                }
            });
        }
    }
};
