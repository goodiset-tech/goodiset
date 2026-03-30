<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('state')->nullable()->after('country'); // Replace 'existing_column' with the column after which you want these new columns
            $table->string('postal_code')->nullable()->after('state');
            $table->string('unit')->nullable()->after('postal_code');
            $table->string('unit_number')->nullable()->after('unit');
            $table->string('company_name')->nullable()->after('unit_number');
            $table->string('payment_method')->nullable()->after('company_name');
            $table->string('payment_status')->nullable()->after('payment_method');
            $table->string('transaction_id')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'state',
                'postal_code',
                'unit',
                'unit_number',
                'company_name',
                'payment_method',
                'payment_status',
                'transaction_id',
            ]);
        });
    }
}
