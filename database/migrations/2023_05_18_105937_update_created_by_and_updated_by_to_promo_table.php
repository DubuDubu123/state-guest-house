<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreatedByAndUpdatedByToPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promo', function (Blueprint $table) {
            if (Schema::hasTable('promo')) {
                if (!Schema::hasColumn('promo', 'created_by')) {
                    Schema::table('promo', function (Blueprint $table) {
                        $table->unsignedInteger('created_by')->nullable()->after('to');
    
                        $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }
            if (Schema::hasTable('promo')) {
                if (!Schema::hasColumn('promo', 'updated_by')) {
                    Schema::table('promo', function (Blueprint $table) {
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
        Schema::table('promo', function (Blueprint $table) {
            //
        });
    }
}
