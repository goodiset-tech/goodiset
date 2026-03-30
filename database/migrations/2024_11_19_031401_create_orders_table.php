<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->text('product_detail'); // Product details
            $table->string('order_no')->unique(); // Order number
            $table->string('customer_name'); // Customer name
            $table->string('email'); // Customer email
            $table->unsignedBigInteger('uid'); // User ID (could reference users table)
            $table->Integer('amount'); // Order amount
            $table->string('city'); // Customer city
            $table->string('phone'); // Customer phone number
            $table->string('country'); // Customer country
            $table->text('address'); // Customer address
            $table->string('shipping_company')->nullable();; // Shipping company
            $table->string('track_url')->nullable(); // Tracking URL, nullable
            $table->string('track_no')->nullable(); // Tracking number, nullable
            $table->text('note')->nullable(); // Notes related to the order, nullable
            $table->Integer('status')->default('1'); // Order status
            $table->Integer('dstatus')->default('0'); // Delivery status
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
        Schema::dropIfExists('orders');
    }
}

