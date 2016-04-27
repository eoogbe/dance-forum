<?php
namespace Admin;
use \FunctionalTester;

class BoardControllerCest
{
  public function viewBoards(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('view the boards in the admin panel');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('admin.boards.index');
    $I->see($board->name);
  }

  public function preventViewBoardsWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing the boards in the admin panel');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('admin.boards.index');
    $I->see('Access denied');
  }

  public function viewBoard(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('view a board in the admin panel');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('admin.boards.show', compact('board'));
    $I->see("Manage {$board->name}");
  }

  public function preventViewBoardWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing a board in the admin panel');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('admin.boards.show', compact('board'));
    $I->see('Access denied');
  }

  public function createBoard(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('create a board');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.boards.create');

    $board = $I->makeModel('App\Board');
    $I->fillField('Name', $board->name);
    $I->fillField('description', $board->description);

    $category = $I->grabCategory();
    $I->selectOption('Category', $category->id);

    $I->click('Create Board');
    $I->see("Manage {$board->name}");
  }

  public function preventCreateBoardWithNameAbsent(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a board without a name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.boards.create');

    $board = $I->makeModel('App\Board');
    $I->fillField('description', $board->description);

    $category = $I->grabCategory();
    $I->selectOption('Category', $category->id);

    $I->click('Create Board');
    $I->seeFormErrorMessage('name', 'The name field is required');
  }

  public function preventCreateBoardWithNameTooLong(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a board with a too long name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.boards.create');
    $I->fillField('Name', str_random(256));

    $board = $I->makeModel('App\Board');
    $I->fillField('description', $board->description);

    $category = $I->grabCategory();
    $I->selectOption('Category', $category->id);

    $I->click('Create Board');
    $I->seeFormErrorMessage('name', 'The name may not be greater than 255 characters');
  }

  public function preventCreateBoardWithNameDuplicate(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a board with a duplicate name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('admin.boards.create');
    $I->fillField('Name', $board->name);
    $I->fillField('description', $board->description);
    $I->selectOption('Category', $board->category_id);

    $I->click('Create Board');
    $I->seeFormErrorMessage('name', 'The name has already been used');
  }

  public function preventCreateBoardWithDescriptionAbsent(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a board without a description');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.boards.create');

    $board = $I->makeModel('App\Board');
    $I->fillField('Name', $board->name);

    $category = $I->grabCategory();
    $I->selectOption('Category', $category->id);

    $I->click('Create Board');
    $I->seeFormErrorMessage('description', 'The description field is required');
  }

  public function preventCreateBoardWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from creating a board');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('admin.boards.create');
    $I->see('Access denied');
  }

  public function updateBoard(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('update a board');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('admin.boards.edit', compact('board'));

    $updatedBoard = $I->makeModel('App\Board');
    $I->fillField('Name', $updatedBoard->name);
    $I->fillField('description', $updatedBoard->description);
    $I->selectOption('Category', $board->category_id);

    $I->click('Update Board');
    $I->see("Manage {$updatedBoard->name}");
  }

  public function preventUpdateBoardWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating a board');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('admin.boards.edit', compact('board'));
    $I->see('Access denied');
  }

  public function destroyBoard(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('destroy a board');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('admin.boards.show', compact('board'));
    $I->click('delete');
    $I->dontSee($board->name);
  }

  public function positionBoardFirst(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('move a board to the first position');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->grabCategory();
    $board = $I->createModel('App\Board', ['category_id' => $category->id]);
    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->click('first', 'section > ul > li:last-child');
    $I->see($board->name, 'section > ul > li:first-child');
  }

  public function positionBoardUp(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('move a board up a position');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->grabCategory();
    $board = $I->createModel('App\Board', ['category_id' => $category->id]);
    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->click('up', 'section > ul > li:last-child');
    $I->see($board->name, 'section > ul > li:nth-last-child(2)');
  }

  public function positionBoardDown(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('move a board down a position');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->grabCategory();
    $I->createModel('App\Board', ['category_id' => $category->id]);
    $board = $category->firstBoard();

    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->click('down', 'section > ul > li:first-child');
    $I->see($board->name, 'section > ul > li:nth-child(2)');
  }

  public function positionBoardLast(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('move a board to the last position');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $category = $I->grabCategory();
    $I->createModel('App\Board', ['category_id' => $category->id]);
    $board = $category->firstBoard();

    $I->amOnRoute('admin.categories.show', compact('category'));
    $I->click('last', 'section > ul > li:first-child');
    $I->see($board->name, 'section > ul > li:last-child');
  }

  public function updateBoardPermissions(FunctionalTester $I, \Page\Login $loginPage)
  {
    $I->am('Admin');
    $I->wantTo('update the permissions assigned to a board');

    $password = str_random(12);
    $admin = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $adminRole = $I->grabRole();
    $admin->roles()->attach($adminRole);
    $loginPage->login($admin->email, $password);

    $user = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $role = $I->createModel('App\Role');
    $role->attachPermission('viewAdminPanel.board');
    $user->roles()->attach($role);

    $board = $I->createModel('App\Board');
    $role->createPermission("delete.board.{$board->id}");
    $I->amOnRoute('admin.boards.editPermissions', compact('board'));

    $I->submitForm('section > form', [
      'update_roles' => [$adminRole->id, $role->id],
      'destroy_roles' => [$adminRole->id]
    ]);

    $I->amOnRoute('admin.boards.show', compact('board'));
    $I->seeLink('edit');
    $I->see('delete');

    $I->click('logout');
    $loginPage->login($user->email, $password);
    $I->amOnRoute('admin.boards.show', compact('board'));
    $I->seeLink('edit');
    $I->dontSee('delete');
  }

  public function preventUpdateBoardPermissionsWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating the permissions assigned to a board');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $board = $I->createModel('App\Board');
    $I->amOnRoute('admin.boards.editPermissions', compact('board'));
    $I->see('Access denied');
  }
}
