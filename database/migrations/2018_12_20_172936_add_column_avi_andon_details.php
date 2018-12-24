<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAviAndonDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('avi_andon_details', function (Blueprint $table) {
            $table->integer('buffer')->after('updated_at');
            $table->string('word')->after('line');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avi_andon_details', function (Blueprint $table) {
            $table->dropColumn('buffer');
            $table->dropColumn('word');
        });
    }
}
