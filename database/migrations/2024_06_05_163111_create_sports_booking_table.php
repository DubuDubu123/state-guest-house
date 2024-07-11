<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportsBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports_booking', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('booking_id'); 
            $table->integer('user_id');  
            $table->timestamp('checkin_date');
            $table->timestamp('checkout_date'); 
            $table->integer('no_of_day'); 
            $table->string('subscription_type'); 
            $table->string('guest_type');     
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
        Schema::dropIfExists('sports_booking');
    }
}
