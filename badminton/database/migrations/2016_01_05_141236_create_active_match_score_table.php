<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveMatchScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_match_score', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('active_id');
            $table->string('group_name');
            $table->integer('group_uid');
            $table->integer('score1');
            $table->integer('score2');
            $table->integer('uid');//录入uid
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
        Schema::drop('active_match_score');
    }
}
