<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviDashboardModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_dashboard_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_group');
            $table->string('part_number');
            $table->string('back_number')->nullable();
            $table->integer('quantity');
            $table->float('min_stock')->nullable();
            $table->float('max_stock')->nullable();
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
        Schema::dropIfExists('avi_dashboard_models');
    }
}
