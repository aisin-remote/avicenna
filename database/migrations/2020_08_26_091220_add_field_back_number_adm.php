<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldBackNumberAdm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_program_number', function (Blueprint $table) {
            $table->string('back_number_adm', 20)->after('back_number')->nullable();
        });

        Schema::table('avi_trace_printers', function (Blueprint $table) {
            $table->string('back_number_adm', 20)->after('back_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
