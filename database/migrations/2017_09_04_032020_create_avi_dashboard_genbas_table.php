<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviDashboardGenbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_dashboard_genbas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('categories', 50)->nullable();
            $table->integer('normal')->nullable();
            $table->integer('abnormality')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avi_dashboard_genbas');
    }
}
