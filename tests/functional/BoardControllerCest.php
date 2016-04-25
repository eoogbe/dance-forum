<?php


class BoardControllerCest
{
  public function viewBoard(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('view a board');

    $board = $I->createModel('App\Board');
    $I->amOnRoute('boards.show', compact('board'));
    $I->see($board->name);
  }

  public function viewBoardWhenAuthenticated(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('view a board and have that view counted');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('boards.show', compact('board'));
    $I->amOnRoute('categories.show', ['category' => $board->category]);
    $I->see('1 view');
  }
}
