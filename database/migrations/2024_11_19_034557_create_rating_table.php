<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->unsignedBigInteger('pid'); // Foreign key for product
            $table->string('name'); // Name of the reviewer
            $table->text('review')->nullable(); // Review text (optional)
            $table->integer('rate'); // Rating score
            $table->string('email'); // Email of the reviewer
            $table->integer('status')->default(0); // Status of the review
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
        Schema::dropIfExists('rating');
    }
}

