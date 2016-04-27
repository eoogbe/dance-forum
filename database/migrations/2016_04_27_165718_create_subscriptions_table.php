<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('subscriptions', function (Blueprint $table) {
      $table->integer('topic_id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->timestamps();
      $table->primary(['topic_id', 'user_id']);
      $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
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
    Schema::drop('subscriptions');
  }
}
