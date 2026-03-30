<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('setting', function (Blueprint $table) {
            $table->string('shipping_time')->nullable(); // Replace 'some_existing_column' with the column after which you want to add it.
        });
    }

    public function down()
    {
        Schema::table('setting', function (Blueprint $table) {
            $table->dropColumn('shipping_time');
        });
    }
};

