<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSportsBooking extends Migration
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
            if (!Schema::hasColumn('sports_booking', 'booked_by')) {
                Schema::table('sports_booking', function (Blueprint $table) {
                    $table->integer('booked_by')->default(0);  
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
