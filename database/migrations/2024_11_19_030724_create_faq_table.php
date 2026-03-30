<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->unsignedBigInteger('pid')->nullable(); // Foreign key or parent ID
            $table->string('name'); // Name or title of the FAQ
            $table->text('question'); // FAQ question
            $table->string('a_name')->nullable(); // Name of the person or entity answering
            $table->text('answer')->nullable(); // FAQ answer
            $table->BigInteger('status')->default(0); // Status of the FAQ
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
        Schema::dropIfExists('faq');
    }
}

