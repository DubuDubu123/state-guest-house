<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIdDetailsToFleetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('fleets')) {
            if (!Schema::hasColumn('fleets', 'vehicle_insurence_number')) {
                Schema::table('fleets', function (Blueprint $table) {
                    $table->string('vehicle_insurence_number')->after('license_number')->nullable();    
                });
            }
        }        
        if (Schema::hasTable('fleets')) {
            if (!Schema::hasColumn('fleets', 'rc_number')) {
                Schema::table('fleets', function (Blueprint $table) {
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
        Schema::table('fleets', function (Blueprint $table) {
            //
        });
    }
}
