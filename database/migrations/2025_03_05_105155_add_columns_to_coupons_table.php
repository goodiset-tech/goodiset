<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('cart_minimum', 10, 2)->nullable(); // Minimum cart amount for coupon
            $table->date('end_date')->nullable()->after('cart_minimum'); // Expiry date of the coupon
            $table->json('products')->nullable()->after('end_date'); // Store product IDs as JSON
        });
    }

    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['cart_minimum', 'end_date', 'products']);
        });
    }
};
