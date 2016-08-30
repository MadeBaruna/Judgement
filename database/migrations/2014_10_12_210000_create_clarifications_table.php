<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClarificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clarifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('contest_id')->unsigned();
            $table->integer('problem_id')->unsigned();
            $table->string('title');
            $table->text('question');
            $table->text('answer');
            $table->timestamps();
            $table->boolean('is_answered');

            $table->foreign('user_id')->references('id')->on('problems')->onDelete('cascade');
            $table->foreign('contest_id')->references('id')->on('problems')->onDelete('cascade');
            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clarifications');
    }
}
