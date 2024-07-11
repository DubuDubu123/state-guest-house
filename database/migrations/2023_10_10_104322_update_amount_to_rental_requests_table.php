<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAmountToRentalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

       if (Schema::hasTable('rental_requests')) {
            if (!Schema::hasColumn('rental_requests', 'amount')) {
                Schema::table('rental_requests', function (Blueprint $table) {
                    $table->double('amount', 10, 2)->default(0);
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
        Schema::table('rental_requests', function (Blueprint $table) {
            //
        });
    }
}
