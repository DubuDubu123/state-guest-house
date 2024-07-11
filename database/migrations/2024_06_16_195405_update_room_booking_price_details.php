<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoomBookingPriceDetails extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('room_booking_price')) {            
            if (!Schema::hasColumn('room_booking_price', 'room_booking_price')) {
                Schema::table('room_booking_price', function (Blueprint $table) {
                    $table->text('room_price_details')->nullable(); 
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
