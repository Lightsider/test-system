<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_to_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_quest')->unsigned();
            $table->foreign('id_quest')->references('id')->on('questions')->onDelete('cascade');;
            $table->integer('id_category')->unsigned();
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quest_to_category');
    }
}
