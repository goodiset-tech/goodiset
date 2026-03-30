<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('slider_image'); // Image for the slider
            $table->unsignedBigInteger('cid'); // Foreign key for category (or related entity)
            $table->string('button')->nullable(); // Button text (optional)
            $table->string('heading'); // Heading text for the slider
            $table->text('p')->nullable(); // Paragraph text for the slider (optional)
            $table->timestamps(); // created_at and updated_at columns

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}

