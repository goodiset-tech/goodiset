<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_cum', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('name'); // Name of the blog/comment
            $table->text('comment'); // Comment content
            $table->bigInteger('bid')->unsigned(); // Reference to another table or identifier
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
        Schema::dropIfExists('blog_cum');
    }
}

