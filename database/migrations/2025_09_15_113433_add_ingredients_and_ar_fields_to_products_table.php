<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Adjust the ->after() targets to match your schema if needed
            $table->longText('ingredients')->nullable()->after('description');        // detailed list
            $table->text('nutritions_ar')->nullable()->after('ingredients');          // Arabic nutrition info
            $table->text('product_description_ar')->nullable()->after('short_description'); // Arabic short blurb
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['ingredients', 'nutritions_ar', 'product_description_ar']);
        });
    }
};
