<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldMachiningStrainer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_machining', function (Blueprint $table) {
            $table->integer('strainer_id')->after('line');
        });

        Schema::table('avi_trace_strainers', function (Blueprint $table) {
            $table->string('line')->after('strainer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_trace_machining', function (Blueprint $table) {
            $table->dropColumn('strainer_id');
        });

        Schema::table('avi_trace_strainers', function (Blueprint $table) {
            $table->dropColumn('line');
        });
    }
}
