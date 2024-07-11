<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDispatcherTypeToAdminDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('admin_details')) {            
            if (!Schema::hasColumn('admin_details', 'dispatcher_type')) {
                Schema::table('admin_details', function (Blueprint $table) {
                    $table->string('dispatcher_type')->after('mobile')->nullable();
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
        Schema::table('admin_details', function (Blueprint $table) {
            //
        });
    }
}
