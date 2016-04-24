<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTopicCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testShowTopicWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->within('header', function () {
        $this->dontSeeLink('edit')
          ->dontSee('delete')
          ->dontSee('lock')
          ->dontSee('pin');
      });
  }

  public function testEditTopic()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());

    $updatedTopic = factory(App\Topic::class)->make();

    $this->actingAs($user)
      ->visit("/admin/topics/{$topic->slug}/edit")
      ->type($updatedTopic->name, 'name')
      ->press('Update Topic')
      ->see($updatedTopic->name);
  }

  public function testEditTopicWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/topics/{$topic->slug}/edit");
    $this->assertEquals(403, $response->status());
  }

  public function testDeleteTopic()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make());

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->press('delete')
      ->dontSee($topic->name);
  }

  public function testPinTopic()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $topic = factory(App\Topic::class)->create();
    $topic->posts()->save(factory(App\Post::class)->make(['created_at' => Carbon::now()->subDay()]));

    $topic2 = factory(App\Topic::class)->create(['board_id' => $topic->board_id]);
    $topic2->posts()->save(factory(App\Post::class)->make());

    $this->actingAs($user)
      ->visit("/boards/{$topic->board->slug}")
      ->within('section > ul > li:last-child', function () use ($topic) {
        $this->see($topic->name);
      })
      ->visit("/topics/{$topic->slug}")
      ->press('pin')
      ->visit("/boards/{$topic->board->slug}")
      ->within('section > ul > li:first-child', function () use ($topic) {
        $this->see($topic->name);
      });
  }

  public function testUnpinTopic()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $topic = factory(App\Topic::class)->create(['pinned_at' => Carbon::now()]);
    $topic->posts()->save(factory(App\Post::class)->make(['created_at' => Carbon::now()->subDay()]));

    $topic2 = factory(App\Topic::class)->create(['board_id' => $topic->board_id]);
    $topic2->posts()->save(factory(App\Post::class)->make());

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->press('unpin')
      ->visit("/boards/{$topic->board->slug}")
      ->within('section > ul > li:last-child', function () use ($topic) {
        $this->see($topic->name);
      });
  }

  public function testLockTopic()
  {
    $admin = App\Role::where('name', 'admin')->first()->users()->first();
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $post = $topic->posts()->save(factory(App\Post::class)->make());

    $this->actingAs($admin)
      ->visit("/topics/{$topic->slug}")
      ->press('lock')
      ->visit("/topics/{$topic->slug}")
      ->see('reply')
      ->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->dontSee('reply')
      ->actingAs($post->author)
      ->visit("/topics/{$topic->slug}")
      ->dontSeeLink('edit')
      ->dontSee('delete');
  }

  public function testUnlockTopic()
  {
    $admin = App\Role::where('name', 'admin')->first()->users()->first();
    $user = factory(App\User::class)->create();

    $topic = factory(App\Topic::class)->create();
    $post = $topic->posts()->save(factory(App\Post::class)->make());

    App\Role::where('name', 'member')->first()->detachPermission("createPost.topic.{$topic->id}");
    $post->author->detachPermission(["update.post.{$post->id}", "destroy.post.{$post->id}"]);

    $this->actingAs($admin)
      ->visit("/topics/{$topic->slug}")
      ->press('unlock')
      ->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->see('reply')
      ->actingAs($post->author)
      ->visit("/topics/{$topic->slug}")
      ->seeLink('edit')
      ->see('delete');
  }
}
