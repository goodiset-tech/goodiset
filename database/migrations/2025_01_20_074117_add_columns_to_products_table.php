<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('HS_Code')->nullable();
            $table->string('Country_Code', 10)->nullable();
            $table->string('Country')->nullable();
            $table->string('Country_in_English')->nullable();
            $table->string('Country_in_Arabic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['HS_Code', 'Country_Code', 'Country', 'Country_in_English', 'Country_in_Arabic']);
        });
    }
}

