<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFromAndToDateToDriverInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('driver_invoices')) {            
            if (!Schema::hasColumn('driver_invoices', 'from')) {
                Schema::table('driver_invoices', function (Blueprint $table) {
                    $table->timestamp('from')->after('subscription_id')->nullable();
                });
            }            
        }
        if (Schema::hasTable('driver_invoices')) {            
            if (!Schema::hasColumn('driver_invoices', 'to')) {
                Schema::table('driver_invoices', function (Blueprint $table) {
                    $table->timestamp('to')->after('from')->nullable();
                });
            }            
        }   
        if (Schema::hasTable('driver_invoices')) {            
            if (!Schema::hasColumn('driver_invoices', 'no_of_rides')) {
                Schema::table('driver_invoices', function (Blueprint $table) {
                    $table->integer('no_of_rides')->after('to')->nullable();
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
