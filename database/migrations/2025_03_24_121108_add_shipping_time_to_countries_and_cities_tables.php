<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingTimeToCountriesAndCitiesTables extends Migration
{
    public function up()
    {
        // Add shipping_time to countries table
        Schema::table('countries', function (Blueprint $table) {
            $table->string('shipping_time')->nullable();
        });

        // Add shipping_time to cities table
        Schema::table('cities', function (Blueprint $table) {
            $table->string('shipping_time')->nullable();
        });
    }

    public function down()
    {
        // Remove shipping_time from countries table
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('shipping_time');
        });

        // Remove shipping_time from cities table
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('shipping_time');
        });
    }
}