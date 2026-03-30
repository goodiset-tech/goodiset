<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitToInventoryRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_request_items', function (Blueprint $table) {
            // Add the 'unit' column
            $table->string('unit')->after('quantity')->nullable(); // You can change 'nullable()' to 'required()' if needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_request_items', function (Blueprint $table) {
            // Drop the 'unit' column if the migration is rolled back
            $table->dropColumn('unit');
        });
    }
}