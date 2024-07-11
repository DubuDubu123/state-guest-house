<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIsConfirmedToRentalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasTable('rental_requests')) {
            if (!Schema::hasColumn('rental_requests', 'is_confirmed')) {
                Schema::table('rental_requests', function (Blueprint $table) {
                    $table->boolean('is_confirmed')->after('is_completed');
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
