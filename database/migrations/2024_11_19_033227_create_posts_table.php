<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('title_english'); // Title in English
            $table->string('slug')->unique(); // Slug for the post
            $table->string('title_urdu'); // Title in Urdu
            $table->text('description_english')->nullable(); // Description in English
            $table->text('description_urdu')->nullable(); // Description in Urdu
            $table->timestamps(); // created_at and updated_at columns
            $table->unsignedBigInteger('category_id'); // Foreign key for category
            $table->string('image')->nullable(); // Image file path for the post
            $table->string('title'); // General title
            $table->text('description')->nullable(); // General description
            $table->text('keywords')->nullable(); // Keywords for SEO
            $table->integer('status')->default(1); // Post status

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
