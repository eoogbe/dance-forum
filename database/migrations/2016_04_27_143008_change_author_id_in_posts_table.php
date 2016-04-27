<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAuthorIdInPostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('posts', function (Blueprint $table) {
      $table->integer('author_id')->unsigned()->nullable()->change();
      $table->dropForeign(['author_id']);
      $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    DB::table('posts')->whereNull('author_id')->delete();

    Schema::table('posts', function (Blueprint $table) {
      $table->integer('author_id')->unsigned()->change();
      $table->dropForeign(['author_id']);
      $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
    });
  }
}
