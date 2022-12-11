<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_foods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categoryid');
            $table->integer('restaurantid');
            $table->string('foodname');
            $table->string('foodnamecolor');
            $table->string('otherdetail');
            $table->string('originalpicture');
            $table->tinyInteger('status');
            $table->integer('created_by');
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
        Schema::dropIfExists('general_foods');
    }
}
