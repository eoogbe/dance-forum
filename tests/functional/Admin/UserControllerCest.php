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

  public function banUser(FunctionalTester $I, \Page\Login $loginPage)
  {
    $I->am('Admin');
    $I->wantTo('ban a user');

    $password = str_random(12);
    $admin = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $adminRole = $I->grabRole();
    $admin->roles()->attach($adminRole);
    $loginPage->login($admin->email, $password);

    $user = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $topic = $I->createModel('App\Topic');
    $post = $I->makeModel('App\Post', ['author_id' => $user->id]);
    $topic->posts()->save($post);

    $I->amOnRoute('admin.users.show', compact('user'));
    $I->click('ban');

    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->dontSee($topic->name);

    $I->click('logout');
    $loginPage->login($user->email, $password);
    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->see($topic->name);
    $I->dontSee('New Topic');
  }

  public function shadowBanUser(FunctionalTester $I, \Page\Login $loginPage)
  {
    $I->am('Admin');
    $I->wantTo('shadow ban a user');

    $password = str_random(12);
    $admin = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $adminRole = $I->grabRole();
    $admin->roles()->attach($adminRole);
    $loginPage->login($admin->email, $password);

    $user = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $topic = $I->createTopic();
    $post = $I->makeModel('App\Post', ['author_id' => $user->id]);
    $topic->posts()->save($post);

    $I->amOnRoute('admin.users.show', compact('user'));
    $I->click('shadow ban');

    $I->amOnRoute('topics.show', compact('topic'));
    $I->dontSee($post->content);

    $I->click('logout');
    $loginPage->login($user->email, $password);
    $I->amOnRoute('topics.show', compact('topic'));
    $I->see($post->content);
    $I->see('reply');
  }

  public function unbanUser(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('shadow ban a user');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $blockedStatusId = \App\BlockedStatus::where('name', 'banned')->first()->id;
    $user = $I->createModel('App\User', ['blocked_status_id' => $blockedStatusId]);
    $topic = $I->createTopic([], ['author_id' => $user->id]);

    $I->amOnRoute('admin.users.show', compact('user'));
    $I->click('remove ban');

    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->see($topic->name);
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
