<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreateByUpdatedByToServiceLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_locations', function (Blueprint $table) {
            if (Schema::hasTable('service_locations')) {
                if (!Schema::hasColumn('service_locations', 'created_by')) {
                    Schema::table('service_locations', function (Blueprint $table) {
                        $table->unsignedInteger('created_by')->nullable()->after('timezone');
    
                        $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }
            if (Schema::hasTable('service_locations')) {
                if (!Schema::hasColumn('service_locations', 'updated_by')) {
                    Schema::table('service_locations', function (Blueprint $table) {
                        $table->unsignedInteger('updated_by')->nullable()->after('created_by');
    
                        $table->foreign('updated_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_locations', function (Blueprint $table) {
            //
        });
    }
}
