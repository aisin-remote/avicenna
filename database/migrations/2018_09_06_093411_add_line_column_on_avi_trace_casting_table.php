<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineColumnOnAviTraceCastingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('avi_trace_casting', function (Blueprint $table) {
            $table->string('line')->after('npk')->nullable();
            $table->boolean('status')->after('line')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_trace_casting', function (Blueprint $table) {
            $table->dropColumn('line');
            $table->dropColumn('status');
        });
    }
}
