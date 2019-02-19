<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAviTraceProgramNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_program_number', function (Blueprint $table) {
            $table->string('company_code')->after('id');
            $table->string('plant_code')->after('company_code');
            $table->string('supplier_code')->after('plant_code');
            $table->string('supplier_plant')->after('supplier_code');
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
            $table->dropColumn('company_code');
            $table->dropColumn('plant_code');
            $table->dropColumn('supplier_code');
            $table->dropColumn('supplier_plant');
        });
    }
}
