<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBoardIdToTopicsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('topics', function (Blueprint $table) {
      $table->integer('board_id')->unsigned()->default(0);
      $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
      $table->unique(['board_id', 'name']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('topics', function (Blueprint $table) {
      $table->dropColumn('board_id');
    });
  }
}
