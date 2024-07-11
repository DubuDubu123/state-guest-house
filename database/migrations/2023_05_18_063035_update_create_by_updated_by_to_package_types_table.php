<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreateByUpdatedByToPackageTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_types', function (Blueprint $table) {
            if (Schema::hasTable('package_types')) {
                if (!Schema::hasColumn('package_types', 'created_by')) {
                    Schema::table('package_types', function (Blueprint $table) {
                        $table->unsignedInteger('created_by')->nullable()->after('description');
    
                        $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }
            if (Schema::hasTable('package_types')) {
                if (!Schema::hasColumn('package_types', 'updated_by')) {
                    Schema::table('package_types', function (Blueprint $table) {
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
        Schema::table('package_types', function (Blueprint $table) {
            //
        });
    }
}
