<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestIdToUserCancellationFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasTable('user_cancellation_fee')) {
            if (!Schema::hasColumn('user_cancellation_fee', 'request_id')) {
                Schema::table('user_cancellation_fee', function (Blueprint $table) {
                    $table->uuid('request_id')->after('user_id')->nullable();

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
        Schema::table('user_cancellation_fee', function (Blueprint $table) {
            //
        });
    }
}
