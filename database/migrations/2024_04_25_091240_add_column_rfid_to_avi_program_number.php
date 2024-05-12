<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRfidToAviProgramNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_program_number', function (Blueprint $table) {
            $table->string('rfid_tmmin')->after('back_number_adm')->nullable();
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
            $table->dropColumn('rfid_tmmin');
        });
    }
}
