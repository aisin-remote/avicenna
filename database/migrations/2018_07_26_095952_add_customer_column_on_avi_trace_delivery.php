<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerColumnOnAviTraceDelivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_delivery', function (Blueprint $table) {
            $table->string('customer')->after('cycle')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_trace_delivery', function (Blueprint $table) {
            $table->dropColumn('customer');
        });
    }
}
