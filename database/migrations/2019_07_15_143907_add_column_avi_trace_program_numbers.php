<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAviTraceProgramNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_program_number', function (Blueprint $table) {
            $table->boolean('is_assy')->after('customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_trace_program_number', function (Blueprint $table) {
            $table->dropColumn('is_assy');
        });
    }
}
