<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasAccessToPermissionRoleTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('permission_role', function (Blueprint $table) {
      $table->boolean('has_access')->default(true);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('permission_role', function (Blueprint $table) {
      $table->dropColumn('has_access');
    });
  }
}
