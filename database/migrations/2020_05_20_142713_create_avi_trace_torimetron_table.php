<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAviTraceTorimetronTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avi_trace_torimetron', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('product_code', 15)->index();
            $table->dateTime('datetime_machine')->nullable();
            for ($i=1; $i < 19; $i++) {
                if ($i < 10) {
                    $table->float('avgt' . '0' . $i, 16, 10)->nullable();
                    continue;
                }

                $table->float('avgt'.$i, 16, 10)->nullable();
            }
            $table->char('status')->default('1')->comment = '1 = ok; 0 = ng';
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
        Schema::dropIfExists('avi_trace_torimetron');
    }
}
