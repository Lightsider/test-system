<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDockerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docker_containers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_quest')->unsigned();
            $table->foreign('id_quest')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name',255)->unique();
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
        Schema::dropIfExists('docker_containers');
    }
}
