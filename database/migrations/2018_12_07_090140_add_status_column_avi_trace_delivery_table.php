<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnAviTraceDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_delivery', function (Blueprint $table) {
            $table->boolean('status')->after('customer')->nullable();
            $table->string('npk_ng')->after('status')->nullable();
            $table->date('date_ng')->after('npk_ng')->nullable();
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
            $table->dropColumn('status');
            $table->dropColumn('npk_ng');
            $table->dropColumn('date_ng');
        });
    }
}
