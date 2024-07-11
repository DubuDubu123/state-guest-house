<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoiceParamsToDriverInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('driver_invoices')) {            
            if (!Schema::hasColumn('driver_invoices', 'invoice_amount')) {
                Schema::table('driver_invoices', function (Blueprint $table) {
                    $table->double('invoice_amount', 10, 2)->after('amount')->nullable();
                    });
            }   
            if (!Schema::hasColumn('driver_invoices', 'gst')) {
                Schema::table('driver_invoices', function (Blueprint $table) {
                    $table->double('gst', 10,2)->after('invoice_amount')->nullable();     
                    });
            }  
            if (!Schema::hasColumn('driver_invoices', 'invoice_number')) {
                Schema::table('driver_invoices', function (Blueprint $table) {
                    $table->string('invoice_number')->after('gst')->nullable();     
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
        Schema::table('driver_invoices', function (Blueprint $table) {
            //
        });
    }
}
