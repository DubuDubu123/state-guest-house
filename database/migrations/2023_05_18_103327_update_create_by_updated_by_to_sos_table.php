<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreateByUpdatedByToSosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sos', function (Blueprint $table) {
            if (Schema::hasTable('sos')) {
                if (!Schema::hasColumn('sos', 'updated_by')) {
                    Schema::table('sos', function (Blueprint $table) {
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
        Schema::table('sos', function (Blueprint $table) {
            //
        });
    }
}
