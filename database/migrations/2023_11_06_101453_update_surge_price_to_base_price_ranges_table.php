<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSurgePriceToBasePriceRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('base_price_ranges')) {
            
            if (!Schema::hasColumn('base_price_ranges', 'surge_price')) {
                Schema::table('base_price_ranges', function (Blueprint $table) {
                    $table->double('surge_price', 10, 2)->after('base_price')->default(0);
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
        Schema::table('base_price_ranges', function (Blueprint $table) {
            //
        });
    }
}
