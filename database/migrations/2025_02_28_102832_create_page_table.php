<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\Command;

class CreatePageTable extends Migration
{
    // public function up()
    // {
    //     Schema::create('pages', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('slug')->unique();
    //         $table->string('page_image')->nullable();
    //         $table->integer('status')->default(1);
    //         $table->timestamps();
    //     });
    // }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
