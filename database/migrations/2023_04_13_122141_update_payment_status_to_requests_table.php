<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentStatusToRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (Schema::hasTable('requests')) {
            if (!Schema::hasColumn('requests', 'payment_confirmed_by_driver')) {
                Schema::table('requests', function (Blueprint $table) {
               $table->boolean('payment_confirmed_by_driver')->after('user_confirmed')->default(false);

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
        Schema::table('requests', function (Blueprint $table) {
            //
        });
    }
}
