<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreatedByAndUpdatedByToCancellationReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cancellation_reasons', function (Blueprint $table) {
            if (Schema::hasTable('cancellation_reasons')) {
                if (!Schema::hasColumn('cancellation_reasons', 'created_by')) {
                    Schema::table('cancellation_reasons', function (Blueprint $table) {
                        $table->unsignedInteger('created_by')->nullable()->after('reason');
    
                        $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }
            if (Schema::hasTable('cancellation_reasons')) {
                if (!Schema::hasColumn('cancellation_reasons', 'updated_by')) {
                    Schema::table('cancellation_reasons', function (Blueprint $table) {
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
        Schema::table('cancellation_reasons', function (Blueprint $table) {
            //
        });
    }
}
