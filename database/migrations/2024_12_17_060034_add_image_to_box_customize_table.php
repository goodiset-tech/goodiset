<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToBoxCustomizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('box_customize', function (Blueprint $table) {
            $table->string('image')->nullable()->after('existing_column'); // Replace 'existing_column' with the column after which you want to add the new one
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
            $table->dropColumn('image');
        });
    }
}
