<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSmtpSettingsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting', function (Blueprint $table) {
            // Adding SMTP settings columns
            $table->string('smtp_host')->nullable()->after('existing_column'); // Replace 'existing_column' with the last column of the table
            $table->string('smtp_port')->nullable()->after('smtp_host');
            $table->string('smtp_username')->nullable()->after('smtp_port');
            $table->string('smtp_password')->nullable()->after('smtp_username');
            $table->enum('smtp_encryption', ['tls', 'ssl', 'none'])->default('tls')->after('smtp_password');
            $table->string('smtp_from_email')->nullable()->after('smtp_encryption');
            $table->string('smtp_from_name')->nullable()->after('smtp_from_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting', function (Blueprint $table) {
            // Dropping the SMTP settings columns
            $table->dropColumn([
                'smtp_host', 
                'smtp_port', 
                'smtp_username', 
                'smtp_password', 
                'smtp_encryption', 
                'smtp_from_email', 
                'smtp_from_name'
            ]);
        });
    }
}
