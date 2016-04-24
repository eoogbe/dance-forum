<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUserCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testIndexUser()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $this->actingAs($user)
      ->visit('/admin/users')
      ->see($user->name);
  }

  public function testIndexUserWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', '/admin/users');
    $this->assertEquals(403, $response->status());
  }

  public function testShowUser()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $this->actingAs($user)
      ->visit("/admin/users/{$user->name}")
      ->see($user->name);
  }

  public function testShowUserWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/users/{$user->name}");
    $this->assertEquals(403, $response->status());
  }

  public function testEditUserRoles()
  {
    $role = App\Role::where('name', 'admin')->first();
    $admin = $role->users()->first();
    $user = factory(App\User::class)->create();

    $this->actingAs($admin)
      ->visit("/admin/users/{$user->name}/roles/edit")
      ->submitForm('Update Roles', ['role_ids' => [$role->id]])
      ->see('Admin');
  }

  public function testEditUserRolesWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/users/{$user->name}/roles/edit");
    $this->assertEquals(403, $response->status());
  }
}
