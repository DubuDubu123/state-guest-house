<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDayToPriceRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasTable('price_ranges')) {
            if (!Schema::hasColumn('price_ranges', 'day')) {
                Schema::table('price_ranges', function (Blueprint $table) {
                    $table->string('day')->after('to')->nullable();
                });
            }
            if (!Schema::hasColumn('price_ranges', 'from_time')) {
                Schema::table('price_ranges', function (Blueprint $table) {
                    $table->time('from_time')->after('day')->nullable();
                });
            }
            if (!Schema::hasColumn('price_ranges', 'to_time')) {
                Schema::table('price_ranges', function (Blueprint $table) {
                    $table->time('to_time')->after('from_time')->nullable();
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
        Schema::table('price_ranges', function (Blueprint $table) {
            //
        });
    }
}
