<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoomBookingGuestDetails extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('room_booking_guest')) {            
            if (!Schema::hasColumn('room_booking_guest', 'guest_type')) {
                Schema::table('room_booking_guest', function (Blueprint $table) {
                    $table->text('guest_type')->nullable(); 
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
