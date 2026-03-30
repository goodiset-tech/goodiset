<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerToFlavourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flavours', function (Blueprint $table) {
            $table->string('banner')->nullable(); // Replace 'existing_column' with the column after which you want to add 'banner'.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flavours', function (Blueprint $table) {
            $table->dropColumn('banner');
        });
    }
}
