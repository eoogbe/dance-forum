<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('categories', function (Blueprint $table) {
      $table->integer('position')->default(-1)->unique();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('categories', function (Blueprint $table) {
      $table->dropUnique(['position']);
      $table->dropColumn('position');
    });
  }
}
