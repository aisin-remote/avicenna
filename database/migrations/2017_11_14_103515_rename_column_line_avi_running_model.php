<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnLineAviRunningModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_running_model', function (Blueprint $table) {
            $table->renameColumn('line_name', 'line_number');
            $table->integer('id_handled')->after('dandori_date');
            $table->integer('buffer')->after('id_handled');
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
        Schema::table('avi_running_model', function (Blueprint $table) {
            $table->renameColumn('line_number', 'line_name');
            $table->dropColumn('id_handled');
            $table->dropColumn('buffer');
        });        
    }

}
