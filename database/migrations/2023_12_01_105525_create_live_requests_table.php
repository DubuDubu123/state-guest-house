<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('request_id')->nullable();    
            $table->string('user_mobile', 14)->nullable();
            $table->string('driver_mobile', 14)->nullable();                
            $table->timestamps();
            
            $table->foreign('request_id')
                    ->references('id')
                    ->on('requests')
                    ->onDelete('cascade');
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_requests');
    }
}
