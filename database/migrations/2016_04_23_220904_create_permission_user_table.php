<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionUserTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('permission_user', function (Blueprint $table) {
      $table->integer('permission_id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->boolean('has_access');
      $table->timestamps();
      $table->primary(['permission_id', 'user_id']);
      $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
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
    Schema::drop('permission_user');
  }
}
