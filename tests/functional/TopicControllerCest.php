<?php


class TopicControllerCest
{
  public function viewTopic(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('view a topic');

    $topic = $I->createTopic();
    $I->amOnRoute('topics.show', compact('topic'));
    $I->see($topic->name);
  }

  public function viewTopicWhenAuthenticated(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('view a topic and have that view counted');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $I->amOnRoute('topics.show', compact('topic'));
    $I->amOnRoute('boards.show', ['board' => $topic->board]);
    $I->see('1 view');
  }

  public function createTopic(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('create a topic');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $board = $I->grabBoard();
    $I->amOnRoute('boards.topics.create', compact('board'));

    $topic = $I->makeModel('App\Topic');
    $I->fillField('Name', $topic->name);

    $post = $I->makeModel('App\Post');
    $I->fillField('post_content', $post->content);

    $I->click('Create Topic');
    $I->see($topic->name);
  }

  public function preventCreateTopicWithNameAbsent(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from creating a topic without a name');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $board = $I->grabBoard();
    $I->amOnRoute('boards.topics.create', compact('board'));

    $post = $I->makeModel('App\Post');
    $I->fillField('post_content', $post->content);

    $I->click('Create Topic');
    $I->seeFormErrorMessage('name', 'The name field is required');
  }

  public function preventCreateTopicWithNameTooLong(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from creating a topic with a too long name');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $board = $I->grabBoard();
    $I->amOnRoute('boards.topics.create', compact('board'));

    $I->fillField('Name', str_random(256));

    $post = $I->makeModel('App\Post');
    $I->fillField('post_content', $post->content);

    $I->click('Create Topic');
    $I->seeFormErrorMessage('name', 'The name may not be greater than 255 characters');
  }

  public function preventCreateTopicWithNameDuplicate(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from creating a topic with a duplicate name');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $I->amOnRoute('boards.topics.create', ['board' => $topic->board]);
    $I->fillField('Name', $topic->name);

    $post = $I->makeModel('App\Post');
    $I->fillField('post_content', $post->content);

    $I->click('Create Topic');
    $I->seeFormErrorMessage('name', 'The name has already been used');
  }

  public function preventCreateTopicWithPostContentAbsent(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from creating a topic without post content');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $board = $I->grabBoard();
    $I->amOnRoute('boards.topics.create', compact('board'));

    $topic = $I->makeModel('App\Topic');
    $I->fillField('Name', $topic->name);

    $I->click('Create Topic');
    $I->seeFormErrorMessage('post_content', 'The post text field is required');
  }

  public function preventCreateTopicWithoutAuthenticated(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('be prevented from creating a topic');

    $board = $I->grabBoard();
    $I->amOnRoute('boards.topics.create', compact('board'));

    $I->seeCurrentUrlEquals('/login');
  }
}
