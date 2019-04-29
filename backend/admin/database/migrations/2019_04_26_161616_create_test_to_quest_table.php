<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestToQuestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_to_quest', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_quest')->unsigned();
            $table->foreign('id_quest')->references('id')->on('questions')->onDelete('cascade');
            $table->integer('id_test')->unsigned();
            $table->foreign('id_test')->references('id')->on('tests')->onDelete('cascade');
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
        Schema::dropIfExists('test_to_quest');
    }
}
