<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverCancellationFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_cancellation_fee', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('driver_id');
            $table->double('amount', 10,2)->nullable();
            $table->boolean('is_paid')->default(false);            
            $table->timestamps();

            $table->foreign('driver_id')
                    ->references('id')
                    ->on('drivers')
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
        Schema::dropIfExists('driver_cancellation_fee');
    }
}
