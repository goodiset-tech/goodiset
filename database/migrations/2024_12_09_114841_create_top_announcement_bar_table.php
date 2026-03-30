<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopAnnouncementBarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_announcement_bar', function (Blueprint $table) {
            $table->id();
            $table->text('text'); // Text for the announcement bar
            $table->enum('status', ['active', 'inactive'])->default('inactive'); // Status of the announcement
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_announcement_bar');
    }
}
