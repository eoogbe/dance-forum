<?php

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

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->dontSeeLink('edit')
      ->dontSee('delete');
  }

  public function testEditTopic()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $topic = factory(App\Topic::class)->create();
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

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/topics/{$topic->slug}/edit");
    $this->assertEquals(403, $response->status());
  }

  public function testDeleteTopic()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $topic = factory(App\Topic::class)->create();

    $this->actingAs($user)
      ->visit("/topics/{$topic->slug}")
      ->press('delete')
      ->dontSee($topic->name);
  }
}
