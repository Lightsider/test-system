<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempTestingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_testing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('id_test')->unsigned();
            $table->foreign('id_test')->references('id')->on('tests');
            $table->integer('id_current_quest')->unsigned();
            $table->foreign('id_current_quest')->references('id')->on('questions');
            $table->string('quest_arr')->unique();
            $table->string('skip_quest_arr');
            $table->string('endtime');
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
        Schema::dropIfExists('temp_testing');
    }
}
