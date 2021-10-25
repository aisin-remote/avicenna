<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledAviTraceKanbans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_kanbans', function (Blueprint $table) {
            $table->string('code_part_2')->after('code_part')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_trace_kanbans', function (Blueprint $table) {
            $table->dropColumn('code_part_2');
        });
    }
}
