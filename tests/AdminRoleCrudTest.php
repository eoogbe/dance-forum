<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminRoleCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testIndexRole()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();
    $role = factory(App\Role::class)->create();

    $this->actingAs($user)
      ->visit('/admin/roles')
      ->see($role->name);
  }

  public function testIndexRoleWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', '/admin/roles');
    $this->assertEquals(403, $response->status());
  }

  public function testShowRole()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();
    $role = factory(App\Role::class)->create();

    $this->actingAs($user)
      ->visit("/admin/roles/{$role->slug}")
      ->see("Manage {$role->name}");
  }

  public function testShowRoleWithoutAdmin()
  {
    $user = factory(App\User::class)->create();
    $role = factory(App\Role::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/roles/{$role->slug}");
    $this->assertEquals(403, $response->status());
  }

  public function testNewRole()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();
    $role = factory(App\Role::class)->make();

    $this->actingAs($user)
      ->visit('/admin/roles/create')
      ->type($role->name, 'name')
      ->press('Create Role')
      ->see("Manage {$role->name}");
  }

  public function testNewRoleNameAbsent()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();

    $this->actingAs($user)
      ->visit('/admin/roles/create')
      ->press('Create Role')
      ->see('The name field is required');
  }

  public function testNewRoleNameTooLong()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();

    $this->actingAs($user)
      ->visit('/admin/roles/create')
      ->type(str_random(256), 'name')
      ->press('Create Role')
      ->see('The name may not be greater than 255 characters');
  }

  public function testNewRoleNameDuplicate()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();
    $role = factory(App\Role::class)->create();

    $this->actingAs($user)
      ->visit('/admin/roles/create')
      ->type($role->name, 'name')
      ->press('Create Role')
      ->see('The name has already been used.');
  }

  public function testNewRoleWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', '/admin/roles/create');
    $this->assertEquals(403, $response->status());
  }

  public function testEditRole()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();

    $role = factory(App\Role::class)->create();
    $updatedRole = factory(App\Role::class)->make();

    $this->actingAs($user)
      ->visit("/admin/roles/{$role->slug}/edit")
      ->type($updatedRole->name, 'name')
      ->press('Update Role')
      ->see("Manage {$updatedRole->name}");
  }

  public function testEditRoleWithoutAdmin()
  {
    $user = factory(App\User::class)->create();
    $role = factory(App\Role::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/roles/{$role->slug}/edit");
    $this->assertEquals(403, $response->status());
  }

  public function testDeleteRole()
  {
    $user = App\Role::where('name', 'Admin')->first()->users()->first();
    $role = factory(App\Role::class)->create(['name' => 'Member']);

    $this->actingAs($user)
      ->visit('/admin/roles')
      ->within('section > ul > li:last-child', function () {
        $this->press('delete');
      })
      ->dontSee($role->name);
  }

  public function testEditRoleUsers()
  {
    $admin = App\Role::where('name', 'Admin')->first()->users()->first();
    $user = factory(App\User::class)->create();
    $role = factory(App\Role::class)->create();

    $this->actingAs($admin)
      ->visit("/admin/roles/{$role->slug}/users/edit")
      ->submitForm('Update Users', ['user_ids' => [$user->id]])
      ->see($user->name);
  }

  public function testEditRoleUsersWithoutAdmin()
  {
    $user = factory(App\User::class)->create();
    $role = factory(App\Role::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/roles/{$role->slug}/users/edit");
    $this->assertEquals(403, $response->status());
  }
}
