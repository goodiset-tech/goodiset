<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku_no')->nullable()->after('product_name'); // Add SKU (unique)
            $table->string('article_number')->nullable()->after('sku_no'); // Add Article Number (nullable)
            $table->string('orignal_name')->nullable()->after('article_number');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku_no', 'article_number','orignal_name']);
        });
    }
};
