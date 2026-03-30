<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('theme_id')->nullable()->after('product_size');
            $table->unsignedBigInteger('package_type_id')->nullable()->after('theme_id');
            $table->unsignedBigInteger('flavour_id')->nullable()->after('package_type_id');
            $table->unsignedBigInteger('basket_type_id')->nullable()->after('flavour_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['theme_id']);
            $table->dropForeign(['package_type_id']);
            $table->dropForeign(['flavour_id']);
            $table->dropForeign(['basket_type_id']);

            $table->dropColumn([
                'theme_id',
                'package_type_id',
                'flavour_id',
                'basket_type_id',
            ]);
        });
    }
};
