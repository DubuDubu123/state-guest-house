<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAmountToDriverSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('driver_subscriptions')) {            
            if (!Schema::hasColumn('driver_subscriptions', 'amount')) {
                Schema::table('driver_subscriptions', function (Blueprint $table) {
                    $table->double('amount', 10, 2)->after('paid_amount')->nullable();
                    });
            }   
            if (!Schema::hasColumn('driver_subscriptions', 'gst')) {
                Schema::table('driver_subscriptions', function (Blueprint $table) {
                    $table->double('gst', 10,2)->after('paid_amount')->nullable();     
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
