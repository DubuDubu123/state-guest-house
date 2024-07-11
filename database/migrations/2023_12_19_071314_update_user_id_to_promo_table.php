<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserIdToPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('promo')) {            
            if (!Schema::hasColumn('promo', 'user_id')) {
                Schema::table('promo', function (Blueprint $table) {
                       $table->unsignedInteger('user_id')->after('active')->nullable();


                  $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');   
                       
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
        Schema::table('promo', function (Blueprint $table) {
            //
        });
    }
}
