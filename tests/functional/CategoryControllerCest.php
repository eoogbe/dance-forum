<?php


class CategoryControllerCest
{
  public function viewCategories(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('view categories');

    $category = $I->createModel('App\Category');
    $I->amOnRoute('categories.index');
    $I->see($category->name);
  }

  public function viewCategory(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('view a category');

    $category = $I->createModel('App\Category');
    $I->amOnRoute('categories.show', compact('category'));
    $I->see($category->name);
  }
}
