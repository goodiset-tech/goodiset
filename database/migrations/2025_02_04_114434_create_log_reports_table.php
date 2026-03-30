<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_reports', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); 
            $table->integer('type_id')->default(0); 
            $table->text('message');  
            $table->integer('user_id')->default(0); // Reference to user
            $table->string('ip_address')->nullable(); 
            $table->string('url')->nullable();
            $table->string('method')->nullable();
            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_reports');
    }
};
