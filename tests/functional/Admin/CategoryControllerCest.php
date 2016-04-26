<?php
namespace Admin;
use \FunctionalTester;

class CategoryControllerCest
{
  public function viewCategories(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('view the categories in the admin panel');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.index');
    $I->see($category->name);
  }

  public function preventViewCategoriesWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing the categories in the admin panel');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('admin.categories.index');
    $I->see('Access denied');
  }

  public function viewCategory(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('view a category in the admin panel');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->see("Manage {$category->name}");
  }

  public function preventViewCategoryWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing a category in the admin panel');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->see('Access denied');
  }

  public function createCategory(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('create a category');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.categories.create');

    $category = $I->makeModel('App\Category');
    $I->fillField('Name', $category->name);

    $I->click('Create Category');
    $I->see("Manage {$category->name}");
  }

  public function preventCreateCategoryWithNameAbsent(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a category without a name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.categories.create');

    $I->click('Create Category');
    $I->seeFormErrorMessage('name', 'The name field is required');
  }

  public function preventCreateCategoryWithNameTooLong(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a category with a too long name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.categories.create');
    $I->fillField('Name', str_random(256));

    $I->click('Create Category');
    $I->seeFormErrorMessage('name', 'The name may not be greater than 255 characters');
  }

  public function preventCreateCategoryWithNameDuplicate(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a category with a duplicate name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.categories.create');

    $category = $I->createModel('App\Category');
    $I->fillField('Name', $category->name);

    $I->click('Create Category');
    $I->seeFormErrorMessage('name', 'The name has already been used');
  }

  public function preventCreateCategoryWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from creating a category');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('admin.categories.create');
    $I->see('Access denied');
  }

  public function updateCategory(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('update a category');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.edit', compact('category'));

    $updatedCategory = $I->makeModel('App\Category');
    $I->fillField('Name', $updatedCategory->name);

    $I->click('Update Category');
    $I->see("Manage {$updatedCategory->name}");
  }

  public function preventUpdateCategoryWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating a category');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.edit', compact('category'));
    $I->see('Access denied');
  }

  public function destroyCategory(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('destroy a category');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->click('delete');
    $I->dontSee($category->name);
  }

  public function positionCategoryFirst(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('move a category to the first position');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.index');
    $I->click('first', 'section > ul > li:last-child');
    $I->see($category->name, 'section > ul > li:first-child');
  }

  public function positionCategoryUp(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('move a category up a position');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.index');
    $I->click('up', 'section > ul > li:last-child');
    $I->see($category->name, 'section > ul > li:nth-last-child(2)');
  }

  public function positionCategoryDown(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('move a category down a position');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->createModel('App\Category');
    $category = $I->grabCategory();

    $I->amOnRoute('admin.categories.index');
    $I->click('down', 'section > ul > li:first-child');
    $I->see($category->name, 'section > ul > li:nth-child(2)');
  }

  public function positionCategoryLast(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('move a category to the last position');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->createModel('App\Category');
    $category = $I->grabCategory();

    $I->amOnRoute('admin.categories.index');
    $I->click('last', 'section > ul > li:first-child');
    $I->see($category->name, 'section > ul > li:last-child');
  }

  public function updateCategoryPermissions(FunctionalTester $I, \Page\Login $loginPage)
  {
    $I->am('Admin');
    $I->wantTo('update the permissions assigned to a category');

    $password = str_random(12);
    $admin = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $adminRole = $I->grabRole();
    $admin->roles()->attach($adminRole);
    $loginPage->login($admin->email, $password);

    $user = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $role = $I->createModel('App\Role');
    $role->attachPermission('viewAdminPanel.board');
    $user->roles()->attach($role);

    $category = $I->createModel('App\Category');
    $role->createPermission("delete.categories.{$category->id}");
    $I->amOnRoute('admin.categories.editPermissions', compact('category'));

    $I->submitForm('form', ['update_roles' => [$adminRole->id, $role->id], 'destroy_roles' => [$adminRole->id]]);

    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->seeLink('edit');
    $I->see('delete');

    $I->click('logout');
    $loginPage->login($user->email, $password);
    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->seeLink('edit');
    $I->dontSee('delete');
  }

  public function preventUpdateCategoryPermissionsWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating the permissions assigned to a category');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $category = $I->createModel('App\Category');
    $I->amOnRoute('admin.categories.editPermissions', compact('category'));
    $I->see('Access denied');
  }
}
