<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToNgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_ng_masters', function (Blueprint $table) {
            $table->string('category')->after('name')->nullable();
        });

        Schema::table('avi_trace_delivery', function (Blueprint $table) {
            $table->string('seri')->after('customer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_trace_ng_masters', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        Schema::table('avi_trace_delivery', function (Blueprint $table) {
            $table->dropColumn('seri');
        });
    }
}
