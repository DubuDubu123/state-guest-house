<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestIdToDriverCancellationFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasTable('driver_cancellation_fee')) {
            if (!Schema::hasColumn('driver_cancellation_fee', 'request_id')) {
                Schema::table('driver_cancellation_fee', function (Blueprint $table) {
                    $table->uuid('request_id')->after('driver_id')->nullable();

               $table->foreign('request_id')
                    ->references('id')
                    ->on('requests')
                    ->onDelete('cascade');
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
        Schema::table('driver_cancellation_fee', function (Blueprint $table) {
            //
        });
    }
}
