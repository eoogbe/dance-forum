<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLockedAtToTopicsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('topics', function (Blueprint $table) {
      $table->dateTime('locked_at')->nullable();
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
      $table->dropColumn('locked_at');
    });
  }
}
