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
        Schema::table('box_customize', function (Blueprint $table) {
            $table->string('weight')->nullable(); // Replace 'existing_column' with the column name after which you want to add 'weight'.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('box_customize', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }
};
