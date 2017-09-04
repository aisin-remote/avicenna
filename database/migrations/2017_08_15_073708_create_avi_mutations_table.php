<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviMutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_mutations', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('mutation_date');
            $table->string('part_number', 50);
            $table->string('location', 4);                  // dev-1.0, Ferry, 20170830
            $table->integer('quantity');
            $table->integer('serial_no')->nullable();
            $table->string('loading_list', 50);
            $table->string('delivery', 50);
            $table->string('customer', 50);
            $table->string('part_name', 150)->nullable();   // dev-1.0, Ferry, 20170830
            $table->string('npk', 10);
            $table->integer('flag_confirm');
            $table->integer('quantity_edited');
            $table->string('npk_edited', 10);
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
        Schema::dropIfExists('avi_mutations');
    }
}
