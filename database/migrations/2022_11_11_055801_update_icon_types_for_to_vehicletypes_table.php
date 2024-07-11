<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIconTypesForToVehicletypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_types', function (Blueprint $table) {
            $table->enum('icon_types_for',['taxi','truck' , 'motor_bike','auto'])->after('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_types', function (Blueprint $table) {
            //
        });
    }
}
