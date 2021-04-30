<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviAndonStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_andon_status_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('andon_id');
            $table->String('code');
            $table->Integer('status');
            $table->datetime('error_at');
            $table->datetime('finish_at')->nullable();
            $table->timestamps();
        });

        Schema::table('avi_andon_status', function (Blueprint $table) {
            $table->datetime('finish_at')->after('error_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avi_andon_status_histories');
        Schema::table('avi_andon_status', function (Blueprint $table) {
            $table->dropColumn('finish_at');
        });
    }
}
