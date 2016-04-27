<?php


class ForumControllerCest
{
  public function search(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('search the forum');

    $category = $I->createModel('App\Category', ['name' => 'Performance']);
    $I->amOnPage('/');
    $I->fillField('term', 'Perf');
    $I->click('Search');
    $I->see($category->name);
  }
}
