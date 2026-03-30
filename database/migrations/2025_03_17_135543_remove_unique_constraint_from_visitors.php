<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropUnique('visitors_visit_date_unique'); // Remove unique constraint
        });
    }

    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->unique('visit_date'); // Re-add constraint if needed
        });
    }
};

