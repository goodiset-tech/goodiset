<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('category')->nullable();
            $table->string('country')->nullable();
            $table->string('model_type')->nullable();
            $table->string('estimated_investment_budget')->nullable();
            $table->string('shop_count')->nullable();
            $table->string('monthly_kilo_order')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('event_location')->nullable();
            $table->string('event_type')->nullable();
            $table->string('estimated_attendance')->nullable();
            $table->string('preferred_product_types')->nullable();
            $table->string('contact_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'company',
                'category',
                'country',
                'model_type',
                'estimated_investment_budget',
                'shop_count',
                'monthly_kilo_order',
                'organization_name',
                'event_location',
                'event_type',
                'estimated_attendance',
                'preferred_product_types',
                'contact_type',
            ]);
        });
    }
}
