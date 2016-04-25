<?php
namespace Admin;
use \FunctionalTester;

class UserControllerCest
{
  public function viewUsers(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('view the users in the admin panel');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $model = $I->createModel('App\User');
    $I->amOnRoute('admin.users.index');
    $I->see($model->name);
  }

  public function preventViewUsersWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing the users in the admin panel');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('admin.users.index');
    $I->see('Access denied');
  }

  public function viewUser(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('view a user in the admin panel');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $model = $I->createModel('App\User');
    $I->amOnRoute('admin.users.show', ['user' => $model]);
    $I->see("Manage {$model->name}");
  }

  public function preventViewUserWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing a user in the admin panel');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $model = $I->createModel('App\User');
    $I->amOnRoute('admin.users.show', ['user' => $model]);
    $I->see('Access denied');
  }

  public function updateUserRoles(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('update the roles assigned to a user');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $model = $I->createModel('App\User');
    $role = $I->createModel('App\Role');

    $I->amOnRoute('admin.users.editRoles', ['user' => $model]);
    $I->checkOption($role->name);
    $I->click('Update Roles');
    $I->see($role->name);
  }

  public function preventUpdateUserRolesWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating the roles assigned to a user');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $model = $I->createModel('App\User');
    $I->amOnRoute('admin.users.editRoles', ['user' => $model]);
    $I->see('Access denied');
  }
}
