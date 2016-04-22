<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminCategoryCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testIndexCategory()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $category = App\Category::first();

    $this->actingAs($user)
      ->visit('/admin/categories')
      ->see($category->name);
  }

  public function testIndexCategoryWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', '/admin/categories');
    $this->assertEquals(403, $response->status());
  }

  public function testShowCategory()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $category = App\Category::first();

    $this->actingAs($user)
      ->visit("/admin/categories/{$category->slug}")
      ->see($category->name);
  }

  public function testShowCategoryWithoutAdmin()
  {
    $user = factory(App\User::class)->create();
    $category = App\Category::first();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/categories/{$category->slug}");
    $this->assertEquals(403, $response->status());
  }

  public function testNewCategory()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $category = factory(App\Category::class)->make();

    $this->actingAs($user)
      ->visit('/admin/categories/create')
      ->type($category->name, 'name')
      ->press('Create Category')
      ->see("Manage {$category->name}");
  }

  public function testNewCategoryNameAbsent()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $this->actingAs($user)
      ->visit('/admin/categories/create')
      ->press('Create Category')
      ->see('The name field is required');
  }

  public function testNewCategoryNameTooLong()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $this->actingAs($user)
      ->visit('/admin/categories/create')
      ->type(str_random(256), 'name')
      ->press('Create Category')
      ->see('The name may not be greater than 255 characters');
  }

  public function testNewCategoryNameDuplicate()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $category = App\Category::first();

    $this->actingAs($user)
      ->visit('/admin/categories/create')
      ->type($category->name, 'name')
      ->press('Create Category')
      ->see('The name has already been used.');
  }


  public function testNewCategoryWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', '/admin/categories/create');
    $this->assertEquals(403, $response->status());
  }

  public function testEditCategory()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $category = App\Category::first();
    $updatedCategory = factory(App\Category::class)->make();

    $this->actingAs($user)
      ->visit("/admin/categories/{$category->slug}/edit")
      ->type($updatedCategory->name, 'name')
      ->press('Update Category')
      ->see("Manage {$updatedCategory->name}");
  }

  public function testEditCategoryWithoutAdmin()
  {
    $user = factory(App\User::class)->create();
    $category = App\Category::first();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/categories/{$category->slug}/edit");
    $this->assertEquals(403, $response->status());
  }

  public function testDeleteCategory()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $category = App\Category::first();

    $this->actingAs($user)
      ->visit('/admin/categories')
      ->press('delete')
      ->dontSee($category->name);
  }
}
