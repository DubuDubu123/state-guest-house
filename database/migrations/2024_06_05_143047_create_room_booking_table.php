<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_booking', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('booking_id');  
            $table->integer('user_id');  
            $table->timestamp('checkin_date');
            $table->timestamp('checkout_date');
            $table->timestamp('actual_checkin_date')->nullable();
            $table->timestamp('actual_checkout_date')->nullable();
            $table->integer('no_of_rooms'); 
            $table->integer('no_of_guests'); 
            $table->integer('booking_count'); 
            $table->string('guest_type');  
            $table->integer('booked_by');  
            $table->integer('modified_by')->nullable();  
            $table->integer('modified_on')->nullable();  
            $table->integer('cancelled_by')->nullable();  
            $table->integer('cancelled_on')->nullable();  
            $table->integer('is_paid')->default(0);
            $table->integer('payment_mode')->default(0);
            $table->double('tariff')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_booking');
    }
}
