<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIsSosToRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasTable('requests')) {
            if (!Schema::hasColumn('requests', 'is_sos')) {
                Schema::table('requests', function (Blueprint $table) {
                    $table->boolean('is_sos')->after('payment_confirmed_by_driver')->default(false);
                });
            }
            if (!Schema::hasColumn('requests', 'sos_type')) {
                Schema::table('requests', function (Blueprint $table) {
                 $table->enum('sos_type', ['user','driver'])->after('is_sos')->nullable();
                });
            }
            if (!Schema::hasColumn('requests', 'is_verified')) {
                Schema::table('requests', function (Blueprint $table) {
                    $table->boolean('is_verified')->after('sos_type')->default(false);
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
