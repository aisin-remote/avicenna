<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviPartPisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_part_pis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('part_number');
            $table->string('part_kind', 10);
            $table->string('part_dock', 10);
            $table->string('back_number')->nullable();
            $table->float('qty_kanban');
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
        Schema::dropIfExists('avi_part_pis');
    }
}
