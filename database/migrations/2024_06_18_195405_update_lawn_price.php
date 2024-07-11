<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLawnPrice extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('party_booking')) {            
            if (!Schema::hasColumn('party_booking', 'is_lawn')) {
                Schema::table('party_booking', function (Blueprint $table) {
                    $table->integer('is_lawn')->default(0); 
                    $table->double('party_amount')->default(0); 
                    $table->double('lawn_amount')->default(0); 
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
