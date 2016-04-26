<?php


class UserControllerCest
{
  public function viewUser(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('view a user profile');

    $user = $I->createModel('App\User');
    $I->amOnRoute('users.show', compact('user'));
    $I->see($user->name);
    $I->dontSee('edit profile');
    $I->dontSee('edit account settings');
  }
}
