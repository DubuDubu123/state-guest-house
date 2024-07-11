<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreatedByAndUpdatedByToComplaintTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaint_titles', function (Blueprint $table) {
            if (Schema::hasTable('complaint_titles')) {
                if (!Schema::hasColumn('complaint_titles', 'created_by')) {
                    Schema::table('complaint_titles', function (Blueprint $table) {
                        $table->unsignedInteger('created_by')->nullable()->after('complaint_type');
    
                        $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }
            if (Schema::hasTable('complaint_titles')) {
                if (!Schema::hasColumn('complaint_titles', 'updated_by')) {
                    Schema::table('complaint_titles', function (Blueprint $table) {
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
        Schema::table('complaint_titles', function (Blueprint $table) {
            //
        });
    }
}
