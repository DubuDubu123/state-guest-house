<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderByToZoneTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (Schema::hasTable('zone_types')) {
            if (!Schema::hasColumn('zone_types', 'order_by')) {
                Schema::table('zone_types', function (Blueprint $table) {
                        $table->integer('order_by')->after('payment_type')->nullable();
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
        Schema::table('zone_types', function (Blueprint $table) {
            //
        });
    }
}
