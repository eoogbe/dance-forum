<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdToBoardsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('boards', function (Blueprint $table) {
      $table->integer('category_id')->unsigned()->default(0);
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
      $table->unique(['category_id', 'name']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('boards', function (Blueprint $table) {
      $table->dropForeign(['category_id']);
      $table->dropColumn('category_id');
    });
  }
}
