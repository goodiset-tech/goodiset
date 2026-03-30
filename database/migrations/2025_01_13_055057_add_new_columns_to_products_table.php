<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('shape')->nullable();
            $table->string('character')->nullable();
            $table->string('type')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name_eng')->nullable();
            $table->string('ingredients_ar')->nullable();
            $table->string('b2c_price')->nullable();
            $table->string('b2b_price')->nullable();
            $table->string('b2d_price')->nullable();
            $table->string('b2p')->nullable();
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
            $table->dropColumn([
                'shape',
                'character',
                'type',
                'name_ar',
                'name_eng',
                'ingredients_ar',
                'b2c_price',
                'b2b_price',
                'b2d_price',
                'b2p',
            ]);
        });
    }
}
