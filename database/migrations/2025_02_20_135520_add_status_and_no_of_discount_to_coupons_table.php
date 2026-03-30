<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('discount'); // 1 = Active, 0 = Inactive
            $table->integer('no_of_discount')->default(0)->after('status'); // Number of times the coupon can be used
        });
    }

    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['status', 'no_of_discount']);
        });
    }
};
