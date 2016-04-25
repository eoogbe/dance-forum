<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testNewPost()
  {
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());

    $post = factory(App\Post::class)->make();

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}/posts/create")
      ->see($topic->posts()->first()->content)
      ->type($post->content, 'content')
      ->press('Create Post')
      ->see($post->content);
  }

  public function testNewPostWithParent()
  {
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());
    $topic->posts()->save(factory(App\Post::class)->make());
    $parentPost = $topic->lastPost();

    $post = factory(App\Post::class)->make();

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}/posts/create?parent_id={$parentPost->id}")
      ->see($parentPost->content)
      ->type($post->content, 'content')
      ->press('Create Post')
      ->see('in reply to');
  }

  public function testNewPostContentAbsent()
  {
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}/posts/create")
      ->press('Create Post')
      ->see('The text field is required');
  }

  public function testEditPost()
  {
    $topic = factory(App\Topic::class)->create();
    $post = factory(App\Post::class)->make();
    $topic->posts()->save($post);

    $updatedPost = factory(App\Post::class)->make();

    $this->actingAs($post->author)
      ->visit("/posts/{$post->id}/edit")
      ->type($updatedPost->content, 'content')
      ->press('Update Post')
      ->see($updatedPost->content);
  }

  public function testEditPostWithAdmin()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();

    $topic = factory(App\Topic::class)->create();
    $post = factory(App\Post::class)->make();
    $topic->posts()->save($post);

    $this->actingAs($user)
      ->visit("/posts/{$post->id}/edit")
      ->assertResponseOk();
  }

  public function testEditPostWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $post = factory(App\Post::class)->make();
    $topic->posts()->save($post);

    $this->actingAs($user);
    $response = $this->call('GET', "/posts/{$post->id}/edit");
    $this->assertEquals(403, $response->status());
  }

  public function testDeletePost()
  {
    $topic = factory(App\Topic::class)->create();
    $post = factory(App\Post::class)->make();
    $topic->posts()->save($post);

    $this->actingAs($post->author)
      ->visit("/topics/{$topic->slug}")
      ->press('delete')
      ->see('[deleted]');
  }

  public function testDeletePostWithAdmin()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();

    $topic = factory(App\Topic::class)->create();
    $post = factory(App\Post::class)->make();
    $topic->posts()->save($post);

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->press('delete')
      ->assertResponseOk();
  }

  public function testDeletePostWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $post = factory(App\Post::class)->make();
    $topic->posts()->save($post);

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->dontSee('delete');
  }

  public function testRestorePost()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();

    $topic = factory(App\Topic::class)->create();
    $post = factory(App\Post::class)->make();
    $topic->posts()->save($post);
    $post->delete();

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->press('restore')
      ->see($post->content);
  }
}
