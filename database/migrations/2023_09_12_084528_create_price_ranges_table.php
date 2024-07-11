<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_ranges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('zone_type_id');
            $table->double('from', 10, 2)->default(0);
            $table->double('to', 10, 2)->default(0);
            $table->double('price', 10, 2)->default(0);
            $table->timestamps();
            // $table->softDeletes();


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
        Schema::dropIfExists('price_ranges');
    }
}
