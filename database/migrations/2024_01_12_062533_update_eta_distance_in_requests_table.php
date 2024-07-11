<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEtaDistanceInRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('requests')) {            
            if (!Schema::hasColumn('requests', 'eta_distance')) {
                Schema::table('requests', function (Blueprint $table) {
                    $table->double('eta_distance', 10, 2)->after('is_verified')->nullable();
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
        Schema::table('requests', function (Blueprint $table) {
            //
        });
    }
}
