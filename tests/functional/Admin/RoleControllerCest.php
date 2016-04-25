<?php
namespace Admin;
use \FunctionalTester;

class RoleControllerCest
{
  public function viewRoles(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('view the roles in the admin panel');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $role = $I->createModel('App\Role');
    $I->amOnRoute('admin.roles.index');
    $I->see($role->name);
  }

  public function preventViewRolesWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing the roles in the admin panel');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('admin.roles.index');
    $I->see('Access denied');
  }

  public function viewRole(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('view a role in the admin panel');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $role = $I->createModel('App\Role');
    $I->amOnRoute('admin.roles.show', compact('role'));
    $I->see("Manage {$role->name}");
  }

  public function preventViewRoleWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing a role in the admin panel');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $role = $I->createModel('App\Role');
    $I->amOnRoute('admin.roles.show', compact('role'));
    $I->see('Access denied');
  }

  public function createRole(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('create a role');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.roles.create');

    $role = $I->makeModel('App\Role');
    $I->fillField('Name', $role->name);

    $permission = $I->grabPermission();
    $I->checkOption($permission->generateDisplayName());

    $I->click('Create Role');
    $I->see("Manage {$role->name}");
  }

  public function preventCreateRoleWithNameAbsent(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a role without a name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.roles.create');

    $permission = $I->grabPermission();
    $I->checkOption($permission->generateDisplayName());

    $I->click('Create Role');
    $I->seeFormErrorMessage('name', 'The name field is required');
  }

  public function preventCreateRoleWithNameTooLong(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a role with a too long name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.roles.create');
    $I->fillField('Name', str_random(256));

    $permission = $I->grabPermission();
    $I->checkOption($permission->generateDisplayName());

    $I->click('Create Role');
    $I->seeFormErrorMessage('name', 'The name may not be greater than 255 characters');
  }

  public function preventCreateRoleWithNameDuplicate(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('be prevented from creating a role with a duplicate name');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $I->amOnRoute('admin.roles.create');

    $role = $I->createModel('App\Role');
    $I->fillField('Name', $role->name);

    $permission = $I->grabPermission();
    $I->checkOption($permission->generateDisplayName());

    $I->click('Create Role');
    $I->seeFormErrorMessage('name', 'The name has already been used');
  }

  public function preventCreateRoleWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from creating a role');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $I->amOnRoute('admin.roles.create');
    $I->see('Access denied');
  }

  public function updateRole(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('update a role');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $role = $I->createModel('App\Role');
    $I->amOnRoute('admin.roles.edit', compact('role'));

    $updatedRole = $I->makeModel('App\Role');
    $I->fillField('Name', $updatedRole->name);

    $I->click('Update Role');
    $I->see("Manage {$updatedRole->name}");
  }

  public function preventUpdateRoleWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating a role');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $role = $I->createModel('App\Role');
    $I->amOnRoute('admin.roles.edit', compact('role'));
    $I->see('Access denied');
  }

  public function destroyRole(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('destroy a role');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $role = $I->createModel('App\Role');
    $I->amOnRoute('admin.roles.show', compact('role'));
    $I->click('delete');
    $I->dontSee($role->name);
  }

  public function updateRoleUsers(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('update the users assigned to a role');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $role = $I->createModel('App\Role');
    $user = $I->createModel('App\User');

    $I->amOnRoute('admin.roles.editUsers', compact('role'));
    $I->checkOption($user->name);
    $I->click('Update Users');
    $I->see($user->name);
  }

  public function preventUpdateRoleUsersWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating the users assigned to a role');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $role = $I->createModel('App\Role');
    $I->amOnRoute('admin.roles.editUsers', compact('role'));
    $I->see('Access denied');
  }
}
