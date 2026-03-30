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
            $table->string('palm_oil')->default(0); // Add the column after an existing one
            $table->string('vegan')->default(0);
            $table->string('gelatin_free')->default(0);
            $table->string('lactose_free')->default(0);
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
            $table->dropColumn('palm_oil');
            $table->dropColumn('vegan');
            $table->dropColumn('gelatin_free');
            $table->dropColumn('lactose_free');
        });
    }
};
