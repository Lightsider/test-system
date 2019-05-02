<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_status')->unsigned();
            $table->foreign('id_status')->references('id')->on('users_status')->onDelete('cascade')->onUpdate('cascade');
            $table->string('login',255)->unique();
            $table->string('password',255);
            $table->string('fullname',255);
            $table->string('group',255);
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
        Schema::dropIfExists('users');
    }
}
