<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSportsCancelledBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasTable('sports_booking')) {            
            if (!Schema::hasColumn('sports_booking', 'cancelled_by')) {
                Schema::table('sports_booking', function (Blueprint $table) {
                    $table->integer('cancelled_by')->nullable();  
                    $table->timestamp('cancelled_on')->nullable();
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
        //
    }
}
