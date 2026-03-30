<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBlogsTable extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->integer('read_time')->nullable()->after('content'); // Estimated read time in minutes
            $table->string('added_by')->nullable()->after('read_time'); // Name or ID of the user who added the blog
            $table->text('short_description')->nullable()->after('added_by'); // Brief summary of the blog
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['read_time', 'added_by', 'short_description']);
        });
    }
}