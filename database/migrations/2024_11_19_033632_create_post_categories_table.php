<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('title_english'); // Title in English
            $table->string('slug')->unique(); // Slug for the category
            $table->string('title'); // General title
            $table->text('description')->nullable(); // Description of the category
            $table->text('keywords')->nullable(); // Keywords for SEO
            $table->string('title_urdu'); // Title in Urdu
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
        Schema::dropIfExists('post_categories');
    }
}

