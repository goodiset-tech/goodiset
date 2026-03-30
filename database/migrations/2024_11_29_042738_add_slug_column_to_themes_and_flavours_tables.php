<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugColumnToThemesAndFlavoursTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name'); // Add 'slug' column to 'themes'
        });

        Schema::table('flavours', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name'); // Add 'slug' column to 'flavours'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('flavours', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
