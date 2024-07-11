<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCurrentLatLngToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('users')) {            
            if (!Schema::hasColumn('users', 'current_lat')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->double('current_lat', 15, 8)->after('is_deleted')->nullable();
                    });
            }   
            if (!Schema::hasColumn('users', 'current_lng')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->double('current_lng', 15, 8)->after('current_lat')->nullable();     
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
