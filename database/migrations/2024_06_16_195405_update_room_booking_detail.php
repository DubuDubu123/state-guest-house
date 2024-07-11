<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoomBookingDetail extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('room_booking')) {            
            if (!Schema::hasColumn('room_booking', 'is_admin_approve')) {
                Schema::table('room_booking', function (Blueprint $table) {
                    $table->integer('is_admin_approve')->default(1);
                   
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
