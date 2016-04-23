<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BoardCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testShowBoard()
  {
    $board = App\Board::orderBy('position')->first();

    $this->visit("/boards/{$board->slug}")
      ->see($board->name);
  }

  public function testShowBoardView()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();

    $this->actingAs($user)
      ->visit("/boards/{$board->slug}")
      ->visit('/')
      ->within('tbody tr:first-child td:last-child', function () {
        $this->see('1');
      });
  }
}
