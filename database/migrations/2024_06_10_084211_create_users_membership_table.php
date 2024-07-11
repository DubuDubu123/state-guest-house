<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersMembershipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_membership', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');  
            $table->integer('membership_type');
            $table->timestamp('date');  
            $table->double('amount');
            $table->integer('is_paid'); 
            $table->integer('payment_mode')->default(1); 
            $table->integer('is_lifetime_member'); 
            $table->integer('expiry_date');  
            $table->integer('is_manual')->default(1);  
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_membership');
    }
}
