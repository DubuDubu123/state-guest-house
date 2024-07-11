<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreatedbyUpdatedbyToRentalCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_categories', function (Blueprint $table) {
            if (Schema::hasTable('rental_categories')) {
                if (!Schema::hasColumn('rental_categories', 'created_by')) {
                    Schema::table('rental_categories', function (Blueprint $table) {
                        $table->unsignedInteger('created_by')->nullable()->after('active');
    
                        $table->foreign('created_by')
                            ->references('id')
                            ->on('users')
                            ->onDelete('cascade');
                    });
                }
            }
            if (Schema::hasTable('rental_categories')) {
                if (!Schema::hasColumn('rental_categories', 'updated_by')) {
                    Schema::table('rental_categories', function (Blueprint $table) {
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
        Schema::table('rental_categories', function (Blueprint $table) {
            //
        });
    }
}
