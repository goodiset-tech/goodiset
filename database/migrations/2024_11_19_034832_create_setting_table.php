<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('site_title'); // Site title
            $table->string('email'); // Contact email
            $table->text('text')->nullable(); // Text for description or any other content
            $table->string('phone'); // Primary phone number
            $table->string('logo')->nullable(); // Logo image file path
            $table->string('logo1')->nullable(); // Additional logo image file path (optional)
            $table->string('timing')->nullable(); // Business hours/timing (optional)
            $table->string('homepage_image_one')->nullable(); // Homepage image 1 (optional)
            $table->string('homepage_image_two')->nullable(); // Homepage image 2 (optional)
            $table->string('homepage_image_3')->nullable(); // Homepage image 3 (optional)
            $table->string('homepage_image_4')->nullable(); // Homepage image 4 (optional)
            $table->text('homepage_footer')->nullable(); // Homepage footer content (optional)
            $table->text('footer_text')->nullable(); // Footer text content (optional)
            $table->text('history_text')->nullable(); // History text content (optional)
            $table->string('title'); // SEO title
            $table->text('description'); // SEO description
            $table->text('keywords')->nullable(); // SEO keywords (optional)
            $table->string('phonetwo')->nullable(); // Secondary phone number (optional)
            $table->string('instagram')->nullable(); // Instagram profile URL (optional)
            $table->string('about_image_one')->nullable(); // About image 1 (optional)
            $table->integer('status')->default(1); // Status of the setting
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
        Schema::dropIfExists('setting');
    }
}
