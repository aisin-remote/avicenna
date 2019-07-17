<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviTraceAssemblingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_trace_assemblings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('npk')->nullable();
            $table->string('line')->nullable();
            $table->boolean('status')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('avi_trace_assemblings');
    }
}
