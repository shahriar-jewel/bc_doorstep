<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurantid');
            $table->string('name');
            $table->string('otherdetail');
            $table->string('picture');
            $table->tinyInteger('is_active');
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
        Schema::dropIfExists('general_categories');
    }
}
