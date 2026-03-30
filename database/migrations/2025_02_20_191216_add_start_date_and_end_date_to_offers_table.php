<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('offers', function (Blueprint $table) {
            $table->date('start_date')->after('status')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
        });
    }

    public function down() {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
};

