<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxCustomizeTable extends Migration
{
    public function up()
    {
        Schema::create('box_customize', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('size_id');
            $table->string('price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('box_customize');
    }
}