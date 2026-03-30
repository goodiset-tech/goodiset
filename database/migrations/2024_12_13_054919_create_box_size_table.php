<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxSizeTable extends Migration
{
    public function up()
    {
        Schema::create('box_sizes', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Column for the size name
            $table->timestamps(); // Created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('box_sizes');
    }
}
