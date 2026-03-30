<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            // Change the 'cid' column data type to VARCHAR and make it nullable
            $table->string('cid')->nullable()->change();

            // Make the 'heading' column nullable
            $table->string('heading')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            // Revert the 'cid' column back to INT and non-nullable
            $table->integer('cid')->nullable(false)->change();

            // Revert the 'heading' column to non-nullable
            $table->string('heading')->nullable(false)->change();
        });
    }
}
