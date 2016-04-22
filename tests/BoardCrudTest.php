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
}
