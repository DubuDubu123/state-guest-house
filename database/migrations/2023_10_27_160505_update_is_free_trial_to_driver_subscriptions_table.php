<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIsFreeTrialToDriverSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('driver_subscriptions')) {
            
            if (!Schema::hasColumn('driver_subscriptions', 'is_free_trial')) {
                Schema::table('driver_subscriptions', function (Blueprint $table) {
                    $table->boolean('is_free_trial')->after('subscription_type')->default(false);
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
