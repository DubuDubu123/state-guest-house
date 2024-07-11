<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHourBeforeNotificationToDriverSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('driver_subscriptions')) {            
            if (!Schema::hasColumn('driver_subscriptions', 'hour_before_nofified')) {
                Schema::table('driver_subscriptions', function (Blueprint $table) {
                    $table->boolean('hour_before_nofified')->after('is_free_trial')->default(0);
                });
            }            
        }
        if (Schema::hasTable('driver_subscriptions')) {            
            if (!Schema::hasColumn('driver_subscriptions', 'day_before_nofified')) {
                Schema::table('driver_subscriptions', function (Blueprint $table) {
                    $table->boolean('day_before_nofified')->after('hour_before_nofified')->default(0);
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
        Schema::table('driver_subscriptions', function (Blueprint $table) {
            //
        });
    }
}
