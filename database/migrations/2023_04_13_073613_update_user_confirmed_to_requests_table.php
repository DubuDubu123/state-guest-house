<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserConfirmedToRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

          if (Schema::hasTable('requests')) {
            if (!Schema::hasColumn('requests', 'user_confirmed')) {
                Schema::table('requests', function (Blueprint $table) {
               $table->boolean('user_confirmed')->after('instant_ride')->default(false);

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
