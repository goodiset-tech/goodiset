<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingTimeToCountryTable extends Migration
{
    public function up()
    {
        Schema::table('country', function (Blueprint $table) {
            $table->string('shipping_time')->nullable();
        });
    }

    public function down()
    {
        Schema::table('country', function (Blueprint $table) {
            $table->dropColumn('shipping_time');
        });
    }
}