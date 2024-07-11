<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIdInformationsToDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('drivers')) {
            if (!Schema::hasColumn('drivers', 'aadhar_number')) {
                Schema::table('drivers', function (Blueprint $table) {
                    $table->bigInteger('aadhar_number')->after('car_number')->nullable();    
                });
            }
        }
        if (Schema::hasTable('drivers')) {
            if (!Schema::hasColumn('drivers', 'driving_license_number')) {
                Schema::table('drivers', function (Blueprint $table) {
                    $table->string('driving_license_number')->after('aadhar_number')->nullable();    
                });
            }
        }       
        if (Schema::hasTable('drivers')) {
            if (!Schema::hasColumn('drivers', 'vehicle_insurence_number')) {
                Schema::table('drivers', function (Blueprint $table) {
                    $table->string('vehicle_insurence_number')->after('driving_license_number')->nullable();    
                });
            }
        }        
        if (Schema::hasTable('drivers')) {
            if (!Schema::hasColumn('drivers', 'rc_number')) {
                Schema::table('drivers', function (Blueprint $table) {
                    $table->string('rc_number')->after('vehicle_insurence_number')->nullable();    
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
        Schema::table('drivers', function (Blueprint $table) {
            //
        });
    }
}
