<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasePriceRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_price_ranges', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('zone_type_id');
            $table->double('base_km_from', 10, 2)->default(0);
            $table->double('base_km_to', 10, 2)->default(0);
            $table->double('base_price', 10, 2)->default(0);
            $table->string('base_price_day')->nullable();   
            $table->time('base_from_time')->nullable();
            $table->time('base_to_time')->nullable();
            $table->timestamps();

            $table->foreign('zone_type_id')
                    ->references('id')
                    ->on('zone_types')
                    ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_price_ranges');
    }
}
