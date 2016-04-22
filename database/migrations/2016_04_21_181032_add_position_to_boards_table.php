<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToBoardsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('boards', function (Blueprint $table) {
      $table->integer('position')->nullable();
      $table->unique(['category_id', 'position']);
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
      $table->dropColumn('position');
    });
  }
}
