<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TopicCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testShowTopic()
  {
    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());

    $this->visit("/topics/{$topic->slug}")
      ->see($topic->name);
  }

  public function testNewTopic()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();
    $topic = factory(App\Topic::class)->make();
    $post = factory(App\Post::class)->make();

    $this->actingAs($user)
      ->visit("/boards/{$board->slug}/topics/create")
      ->type($topic->name, 'name')
      ->type($post->content, 'post_content')
      ->press('Create Topic')
      ->see($topic->name);
  }

  public function testNewTopicNameAbsent()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();
    $post = factory(App\Post::class)->make();

    $this->actingAs($user)
      ->visit("/boards/{$board->slug}/topics/create")
      ->type($post->content, 'post_content')
      ->press('Create Topic')
      ->see('The name field is required');
  }

  public function testNewTopicNameTooLong()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();
    $post = factory(App\Post::class)->make();

    $this->actingAs($user)
      ->visit("/boards/{$board->slug}/topics/create")
      ->type(str_random(256), 'name')
      ->type($post->content, 'post_content')
      ->press('Create Topic')
      ->see('The name may not be greater than 255 characters');
  }

  public function testNewTopicNameDuplicate()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());

    $post = factory(App\Post::class)->make();

    $this->actingAs($user)
      ->visit("/boards/{$board->slug}/topics/create")
      ->type($topic->name, 'name')
      ->type($post->content, 'post_content')
      ->press('Create Topic')
      ->see($user->name);
  }

  public function testNewTopicNameAndBoardDuplicate()
  {
    $user = factory(App\User::class)->create();
    $existingTopic = factory(App\Topic::class)->create();

    $topic = factory(App\Topic::class)->create(['board_id' => $existingTopic->board_id]);
    $topic->posts()->save(factory(App\Post::class)->make());

    $post = factory(App\Post::class)->make();

    $this->actingAs($user)
      ->visit("/boards/{$existingTopic->board->slug}/topics/create")
      ->type($topic->name, 'name')
      ->type($post->content, 'post_content')
      ->press('Create Topic')
      ->see('The name has already been used.');
  }

  public function testNewTopicPostContentAbsent()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();
    $topic = factory(App\Topic::class)->make();

    $this->actingAs($user)
      ->visit("/boards/{$board->slug}/topics/create")
      ->type($topic->name, 'name')
      ->press('Create Topic')
      ->see('The post text field is required');
  }
}
