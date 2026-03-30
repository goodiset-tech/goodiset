<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPageToFaqsTable extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            // Check if the column already exists
            if (!Schema::hasColumn('faqs', 'page')) {
                $table->string('page')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            // Drop the 'page' column if it exists
            if (Schema::hasColumn('faqs', 'page')) {
                $table->dropColumn('page');
            }
        });
    }
}