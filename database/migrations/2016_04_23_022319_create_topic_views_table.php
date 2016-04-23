<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicViewsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('topic_views', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('topic_id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->integer('count')->unsigned()->default(0);
      $table->timestamps();
      $table->unique(['topic_id', 'user_id']);
      $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('topic_views');
  }
}
