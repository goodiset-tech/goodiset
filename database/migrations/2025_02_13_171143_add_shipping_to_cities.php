<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('cities', function (Blueprint $table) {
            $table->decimal('min_order', 8, 2)->default(0)->after('name');
            $table->decimal('shipping_cost', 8, 2)->default(0)->after('min_order');
            $table->decimal('free_shipping', 8, 2)->default(0)->after('shipping_cost');
        });
    }

    public function down() {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['min_order', 'shipping_cost', 'free_shipping']);
        });
    }
};

