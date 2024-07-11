<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreateByUpdatedByToZoneTypePackagePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zone_type_package_prices', function (Blueprint $table) {
            if (Schema::hasTable('zone_type_package_prices')) {
                if (!Schema::hasColumn('zone_type_package_prices', 'created_by')) {
                    Schema::table('zone_type_package_prices', function (Blueprint $table) {
                        $table->unsignedInteger('created_by')->nullable()->after('free_min');
    
                        $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }
            if (Schema::hasTable('zone_type_package_prices')) {
                if (!Schema::hasColumn('zone_type_package_prices', 'updated_by')) {
                    Schema::table('zone_type_package_prices', function (Blueprint $table) {
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
        Schema::table('zone_type_package_prices', function (Blueprint $table) {
            //
        });
    }
}
