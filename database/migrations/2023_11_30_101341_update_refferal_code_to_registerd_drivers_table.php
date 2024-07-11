<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRefferalCodeToRegisterdDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasTable('registerd_drivers')) {
            if (!Schema::hasColumn('registerd_drivers', 'refferal_code')) {
                Schema::table('registerd_drivers', function (Blueprint $table) {
                    $table->string('refferal_code')->after('mobile')->nullable();
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
        Schema::table('registerd_drivers', function (Blueprint $table) {
            //
        });
    }
}
