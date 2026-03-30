<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('menu_type'); // Type of the menu
            $table->string('name'); // Name of the page
            $table->string('slug')->unique(); // Slug for the page URL
            $table->string('route'); // Route or URL for the page
            $table->string('position')->nullable(); // Position in menu or order
            $table->integer('parent')->default(0); // Parent page ID, nullable
            $table->integer('status')->default(1); // Page status
            $table->string('section')->nullable(); // Section of the page (optional)
            $table->text('content')->nullable(); // Content of the page
            $table->string('page_image')->nullable(); // Page image file path
            $table->integer('page_image_status')->nullable(); // Status of the page image
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
        Schema::dropIfExists('pages');
    }
}
