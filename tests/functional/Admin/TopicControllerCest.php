<?php

namespace Admin;

use \FunctionalTester;
use Carbon\Carbon;

class TopicControllerCest
{
  public function showTopicWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from viewing admin actions on the topic show page');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $I->amOnRoute('topics.show', compact('topic'));
    $I->dontSee('manage permissions', 'header');
    $I->dontSeeLink('edit');
    $I->dontSee('delete', 'header');
    $I->dontSee('pin', 'header');
    $I->dontSee('lock', 'header');
    $I->dontSee('hide', 'header');
  }

  public function updateTopic(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('update a topic');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic();
    $I->amOnRoute('admin.topics.edit', compact('topic'));

    $updatedTopic = $I->makeModel('App\Topic');
    $I->fillField('Name', $updatedTopic->name);

    $I->click('Update Topic');
    $I->see($updatedTopic->name);
  }

  public function preventUpdateTopicWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating a topic');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $I->amOnRoute('admin.topics.edit', compact('topic'));
    $I->see('Access denied');
  }

  public function destroyTopic(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('destroy a topic');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic();
    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('delete');
    $I->dontSee($topic->name);
  }

  public function pinTopic(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('pin a topic');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic([], ['created_at' => Carbon::now()->subDay()]);
    $I->createTopic(['board_id' => $topic->board_id]);

    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->see($topic->name, 'section > ul > li:last-child');

    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('pin');
    $I->see('pinned');

    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->see($topic->name, 'section > ul > li:first-child');
  }

  public function unpinTopic(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('unpin a topic');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic(['pinned_at' => Carbon::now()],
      ['created_at' => Carbon::now()->subDay()]);
    $I->createTopic(['board_id' => $topic->board_id]);

    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('unpin');
    $I->dontSee('pinned');

    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->see($topic->name, 'section > ul > li:last-child');
  }

  public function lockTopic(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('lock a topic');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic();
    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('lock');
    $I->see('locked');

    $I->amOnRoute('topics.show', compact('topic'));
    $I->dontSee('reply');

    $I->amLoggedAs($topic->firstPost()->author);
    $I->dontSee('edit', 'section > ol > li a');
    $I->dontSee('delete', 'section > ol > li');
  }

  public function unlockTopic(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('unlock a topic');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic(['locked_at' => Carbon::now()]);
    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('unlock');
    $I->dontSee('locked');

    $I->amOnRoute('topics.show', compact('topic'));
    $I->see('reply');

    $I->amLoggedAs($topic->firstPost()->author);
    $I->see('edit', 'section > ol > li');
    $I->see('delete', 'section > ol > li');
  }

  public function hideTopic(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('hide a topic');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic();
    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('hide');
    $I->see('hidden');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);
    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->dontSee($topic->name);
  }

  public function unhideTopic(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('unmark a topic as hidden');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic(['hidden_at' => Carbon::now()]);
    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('show');
    $I->dontSee('hidden');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);
    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->see($topic->name);
  }

  public function updateTopicPermissions(FunctionalTester $I, \Page\Login $loginPage)
  {
    $I->am('Admin');
    $I->wantTo('update the permissions assigned to a topic');

    $password = str_random(12);
    $admin = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $adminRole = $I->grabRole();
    $admin->roles()->attach($adminRole);
    $loginPage->login($admin->email, $password);

    $user = $I->createModel('App\User', ['password' => bcrypt($password)]);
    $role = $I->createModel('App\Role');
    $user->roles()->attach($role);

    $topic = $I->createModel('App\Topic');
    $role->createPermission("delete.topic.{$topic->id}");
    $I->amOnRoute('admin.topics.editPermissions', compact('topic'));

    $I->submitForm('form', ['update_roles' => [$adminRole->id, $role->id], 'destroy_roles' => [$adminRole->id]]);

    $I->amOnRoute('topics.show', compact('topic'));
    $I->seeLink('edit');
    $I->see('delete');

    $I->click('logout');
    $loginPage->login($user->email, $password);
    $I->amOnRoute('topics.show', compact('topic'));
    $I->seeLink('edit');
    $I->dontSee('delete');
  }

  public function preventUpdateTopicPermissionsWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating the permissions assigned to a topic');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createModel('App\Topic');
    $I->amOnRoute('admin.topics.editPermissions', compact('topic'));
    $I->see('Access denied');
  }
}
