<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIsSubscriptionInvoiceToDriverInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('driver_invoices')) {            
            if (!Schema::hasColumn('driver_invoices', 'is_subscription_invoice')) {
                Schema::table('driver_invoices', function (Blueprint $table) {
                    $table->boolean('is_subscription_invoice')->after('is_paid')->default(false);
                });
            }            
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_invoices', function (Blueprint $table) {
            //
        });
    }
}
