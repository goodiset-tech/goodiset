<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToPackageTypeTable extends Migration
{
    public function up()
    {
        Schema::table('package_types', function (Blueprint $table) {
            $table->string('price')->nullable();
        });
    }

    public function down()
    {
        Schema::table('package_types', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}

