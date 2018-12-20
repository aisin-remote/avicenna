<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAviRunningModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('avi_running_model', function (Blueprint $table) {
            $table->integer('buffer')->after('updated_at');
            $table->string('word')->after('back_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_running_model', function (Blueprint $table) {
            $table->dropColumn('buffer');
            $table->dropColumn('word');
        });
    }
}
