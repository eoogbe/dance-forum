<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlockedStatusIdToUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->integer('blocked_status_id')->unsigned()->nullable();
      $table->foreign('blocked_status_id')->references('id')->on('blocked_statuses')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropForeign(['blocked_status_id']);
      $table->dropColumn('blocked_status_id');
    });
  }
}
