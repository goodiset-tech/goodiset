<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameProductColumnsInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Rename product_name to name_sw
            $table->renameColumn('product_name', 'name_sw');
            // Rename name_eng to product_name
            $table->renameColumn('name_eng', 'product_name');
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
            // Reverse name_sw to product_name
            $table->renameColumn('name_sw', 'product_name');
            // Reverse product_name to name_eng
            $table->renameColumn('product_name', 'name_eng');
        });
    }
}
