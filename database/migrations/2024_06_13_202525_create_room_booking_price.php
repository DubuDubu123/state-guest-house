<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomBookingPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_booking_price', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('booking_id');  
            $table->double('initial_price')->default(0);
            $table->integer('initial_price_status')->default(0); 
            $table->double('amount_need_to_paid')->default(0);
            $table->double('total_price')->default(0);
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
        Schema::dropIfExists('room_booking_price');
    }
}
