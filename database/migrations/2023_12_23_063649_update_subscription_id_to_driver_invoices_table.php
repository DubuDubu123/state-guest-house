<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSubscriptionIdToDriverInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasTable('driver_invoices')) {
            if (!Schema::hasColumn('driver_invoices', 'subscription_id')) {
                Schema::table('driver_invoices', function (Blueprint $table) {
                    $table->uuid('subscription_id')->after('is_subscription_invoice')->nullable();

               $table->foreign('subscription_id')
                    ->references('id')
                    ->on('driver_subscriptions')
                    ->onDelete('cascade');
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
