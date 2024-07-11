<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSurgePriceToPriceRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('price_ranges')) {
            
            if (!Schema::hasColumn('price_ranges', 'surge_price')) {
                Schema::table('price_ranges', function (Blueprint $table) {
                    $table->double('surge_price', 10, 2)->after('price')->default(0);
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
