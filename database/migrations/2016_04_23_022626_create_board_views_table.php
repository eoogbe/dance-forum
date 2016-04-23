<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardViewsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('board_views', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('board_id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->integer('count')->unsigned()->default(0);
      $table->timestamps();
      $table->unique(['board_id', 'user_id']);
      $table->foreign('board_id')->references('id')->on('topics')->onDelete('cascade');
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
    Schema::drop('board_views');
  }
}
