<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFlatDiscountToZoneTypePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('zone_type_price')) {
            
            if (!Schema::hasColumn('zone_type_price', 'flat_discount')) {
                Schema::table('zone_type_price', function (Blueprint $table) {
                    $table->double('flat_discount', 10, 2)->after('free_waiting_time_in_mins_after_trip_start')->default(0);
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
        Schema::table('zone_type_price', function (Blueprint $table) {
            //
        });
    }
}
