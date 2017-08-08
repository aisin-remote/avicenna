<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();;
            $table->string('back_number', 100);
            $table->string('part_number', 100);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('m_customers')
            ->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_parts');
    }
}
