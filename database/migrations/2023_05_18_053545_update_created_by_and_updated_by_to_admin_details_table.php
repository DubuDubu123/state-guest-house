<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreatedByAndUpdatedByToAdminDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_details', function (Blueprint $table) {
            if (Schema::hasTable('admin_details')) {
                if (!Schema::hasColumn('admin_details', 'created_by')) {
                    Schema::table('admin_details', function (Blueprint $table) {
                        $table->unsignedInteger('created_by')->nullable()->after('mobile');
    
                        $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }
            if (Schema::hasTable('admin_details')) {
                if (!Schema::hasColumn('admin_details', 'updated_by')) {
                    Schema::table('admin_details', function (Blueprint $table) {
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
        Schema::table('admin_details', function (Blueprint $table) {
            //
        });
    }
}
