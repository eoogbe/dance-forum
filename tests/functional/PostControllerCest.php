<?php


class PostControllerCest
{
  public function createPost(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('create a post');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $I->amOnRoute('topics.posts.create', compact('topic'));
    $I->see($topic->firstPost()->content);

    $post = $I->makeModel('App\Post');
    $I->fillField('content', $post->content);

    $I->click('Create Post');
    $I->see($post->content);
  }

  public function createPostWithParent(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('create a post in reply to a parent post');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $parentPost = $I->makeModel('App\Post');
    $topic->posts()->save($parentPost);
    $I->amOnRoute('topics.posts.create', ['topic' => $topic, 'parent_id' => $parentPost->id]);
    $I->see($parentPost->content);

    $post = $I->makeModel('App\Post');
    $I->fillField('content', $post->content);

    $I->click('Create Post');
    $I->see('in reply to');
  }

  public function preventCreatePostWithContentAbsent(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from creating a post without content');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $I->amOnRoute('topics.posts.create', compact('topic'));

    $I->click('Create Post');
    $I->seeFormErrorMessage('content', 'The text field is required');
  }

  public function preventCreatePostWithoutAuthenticated(FunctionalTester $I)
  {
    $I->am('Guest');
    $I->wantTo('be prevented from creating a post');

    $topic = $I->createTopic();
    $I->amOnRoute('topics.posts.create', compact('topic'));

    $I->seeCurrentUrlEquals('/login');
  }

  public function updatePost(FunctionalTester $I)
  {
    $I->am('Post Author');
    $I->wantTo('update a post');

    $topic = $I->createTopic();
    $post = $topic->firstPost();
    $I->amLoggedAs($post->author);

    $I->amOnRoute('posts.edit', compact('post'));

    $updatedPost = $I->makeModel('App\Post');
    $I->fillField('content', $updatedPost->content);

    $I->click('Update Post');
    $I->see($updatedPost->content);
  }

  public function preventUpdatePostWithoutAuthor(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from updating a post');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $post = $topic->firstPost();
    $I->amOnRoute('posts.edit', compact('post'));

    $I->see('Access denied');
  }

  public function destroyPost(FunctionalTester $I)
  {
    $I->am('Post Author');
    $I->wantTo('destroy a post');

    $topic = $I->createTopic();
    $post = $topic->firstPost();
    $I->amLoggedAs($post->author);

    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('delete', 'section > ol > li');
    $I->see('[deleted]');
  }

  public function preventDestroyPostWithoutAuthor(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from destroying a post');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $I->amOnRoute('topics.show', compact('topic'));
    $I->dontSee('delete', 'section > ol > li');
  }

  public function restorePost(FunctionalTester $I)
  {
    $I->am('Admin');
    $I->wantTo('restore a post');

    $admin = $I->grabAdmin();
    $I->amLoggedAs($admin);

    $topic = $I->createTopic();
    $post = $topic->firstPost();
    $post->delete();

    $I->amOnRoute('topics.show', compact('topic'));
    $I->click('restore');
    $I->see($post->content);
  }

  public function preventDestroyPostWithoutAdmin(FunctionalTester $I)
  {
    $I->am('User');
    $I->wantTo('be prevented from restoring a post');

    $user = $I->createModel('App\User');
    $I->amLoggedAs($user);

    $topic = $I->createTopic();
    $post = $topic->firstPost();
    $post->delete();

    $I->amOnRoute('topics.show', compact('topic'));
    $I->dontSee('restore');
  }
}
