<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->unsignedBigInteger('category_id'); // Foreign key for category
            $table->unsignedBigInteger('brand_id'); // Foreign key for brand
            $table->string('product_name'); // Name of the product
            $table->string('slug')->unique(); // Slug for the product URL
            $table->string('mpn')->nullable(); // Manufacturer part number (optional)
            $table->string('sku')->nullable(); // Stock keeping unit (optional)
            $table->string('product_code')->nullable(); // Product code (optional)
            $table->integer('product_quantity'); // Product quantity
            $table->text('product_details'); // Detailed description of the product
            $table->text('short_description')->nullable(); // Short description of the product (optional)
            $table->string('related_product_id')->nullable(); // Related product ID (optional)
            $table->string('product_color')->nullable(); // Product color (optional)
            $table->string('product_size')->nullable(); // Product size (optional)
            $table->string('product_clarity')->nullable(); // Product clarity (optional)
            $table->string('product_shape')->nullable(); // Product shape (optional)
            $table->text('tags')->nullable(); // Tags related to the product (optional)
            $table->integer('selling_price'); // Selling price of the product
            $table->integer('discount_price'); // Discount price (optional)
            $table->integer('shipping_price'); // Shipping price for the product
            $table->string('video_link')->nullable(); // Video link for the product (optional)
            $table->integer('main_slider')->default(0); // Whether the product is in the main slider
            $table->integer('hot_deal')->default(0); // Whether the product is a hot deal
            $table->integer('new_arrival')->default(0); // Whether the product is a new arrival
            $table->integer('featured')->default(0); // Whether the product is featured
            $table->integer('view')->default(0); // Product views
            $table->integer('best_rated')->default(0); // Whether the product is the best-rated
            $table->integer('mid_slider')->default(0); // Whether the product is in the middle slider
            $table->integer('hot_new')->default(0); // Whether the product is hot and new
            $table->integer('sale')->default(0); // Whether the product is on sale
            $table->integer('status')->default(1); // Product status
            $table->string('image_one')->nullable(); // Main image for the product (optional)
            $table->string('thumb')->nullable(); // Thumbnail image for the product (optional)
            $table->text('gallary_images')->nullable(); // Gallery images for the product (optional)
            $table->timestamps(); // created_at and updated_at columns
            $table->string('wpid')->nullable(); // WP ID (optional)
            $table->text('home_cats')->nullable(); // Categories for the home page (optional)
            $table->decimal('carat', 10, 2)->nullable(); // Carat (weight) of the product (optional)
            $table->string('certificate')->nullable(); // Certificate related to the product (optional)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
