<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportsBookingTariffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports_booking_tariff', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('booking_id'); 
            $table->unsignedInteger('tariff_id');
            $table->integer('price');
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
        Schema::dropIfExists('sports_booking_tariff');
    }
}
