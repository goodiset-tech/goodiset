<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Change the column types while keeping them nullable
            $table->string('category_id')->nullable()->change();
            $table->string('theme_id')->nullable()->change();
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
            // Revert columns back to their original type
            $table->bigInteger('category_id')->nullable(false)->change();
            $table->bigInteger('theme_id')->nullable()->change();
        });
    }
};
