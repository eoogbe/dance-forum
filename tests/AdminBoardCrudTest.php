<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminBoardCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testIndexBoard()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = App\Board::orderBy('position')->first();

    $this->actingAs($user)
      ->visit('/admin/boards')
      ->see($board->name);
  }

  public function testIndexBoardWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', '/admin/boards');
    $this->assertEquals(403, $response->status());
  }

  public function testShowBoard()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = App\Board::orderBy('position')->first();

    $this->actingAs($user)
      ->visit("/admin/boards/{$board->slug}")
      ->see($board->name);
  }

  public function testShowBoardWithoutAdmin()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/boards/{$board->slug}");
    $this->assertEquals(403, $response->status());
  }

  public function testNewBoard()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = factory(App\Board::class)->make();

    $this->actingAs($user)
      ->visit('/admin/boards/create')
      ->type($board->name, 'name')
      ->type($board->description, 'description')
      ->select($board->category_id, 'category_id')
      ->press('Create Board')
      ->see("Manage {$board->name}");
  }

  public function testNewBoardNameAbsent()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = factory(App\Board::class)->make();

    $this->actingAs($user)
      ->visit('/admin/boards/create')
      ->type($board->description, 'description')
      ->select($board->category_id, 'category_id')
      ->press('Create Board')
      ->see('The name field is required');
  }

  public function testNewBoardNameTooLong()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = factory(App\Board::class)->make();

    $this->actingAs($user)
      ->visit('/admin/boards/create')
      ->type(str_random(256), 'name')
      ->type($board->description, 'description')
      ->select($board->category_id, 'category_id')
      ->press('Create Board')
      ->see('The name may not be greater than 255 characters');
  }

  public function testNewBoardNameDuplicate()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $category = App\Category::sortedFirst();
    $board = factory(App\Board::class)->create();

    $this->actingAs($user)
      ->visit('/admin/boards/create')
      ->type($board->name, 'name')
      ->type($board->description, 'description')
      ->select($category->id, 'category_id')
      ->press('Create Board')
      ->see("Manage {$board->name}");
  }

  public function testNewBoardNameAndCategoryDuplicate()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = factory(App\Board::class)->create();

    $this->actingAs($user)
      ->visit('/admin/boards/create')
      ->type($board->name, 'name')
      ->type($board->description, 'description')
      ->select($board->category_id, 'category_id')
      ->press('Create Board')
      ->see('The name has already been used.');
  }

  public function testNewBoardDescrptionAbsent()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = factory(App\Board::class)->make();

    $this->actingAs($user)
      ->visit('/admin/boards/create')
      ->type($board->name, 'name')
      ->select($board->category_id, 'category_id')
      ->press('Create Board')
      ->see('The description field is required');
  }

  public function testNewBoardWithoutAdmin()
  {
    $user = factory(App\User::class)->create();

    $this->actingAs($user);
    $response = $this->call('GET', '/admin/boards/create');
    $this->assertEquals(403, $response->status());
  }

  public function testEditBoard()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();

    $board = App\Board::orderBy('position')->first();
    $updatedBoard = factory(App\Board::class)->make();

    $this->actingAs($user)
      ->visit("/admin/boards/{$board->slug}/edit")
      ->type($updatedBoard->name, 'name')
      ->type($updatedBoard->description, 'description')
      ->select($updatedBoard->category_id, 'category_id')
      ->press('Update Board')
      ->see("Manage {$updatedBoard->name}");
  }

  public function testEditBoardWithoutAdmin()
  {
    $user = factory(App\User::class)->create();
    $board = App\Board::orderBy('position')->first();

    $this->actingAs($user);
    $response = $this->call('GET', "/admin/boards/{$board->slug}/edit");
    $this->assertEquals(403, $response->status());
  }

  public function testDeleteBoard()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = App\Board::orderBy('position')->first();

    $this->actingAs($user)
      ->visit('/admin/boards')
      ->press('delete')
      ->dontSee($board->name);
  }

  public function testPositionBoardFirst()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $category = App\Category::sortedFirst();
    $board = factory(App\Board::class)->create(['category_id' => $category->id]);

    $this->actingAs($user)
      ->visit("/admin/categories/{$category->slug}")
      ->within('section > ul > li:last-child', function() {
        $this->press('first');
      })
      ->within('section > ul > li:first-child', function() use ($board) {
        $this->see($board->name);
      });
  }

  public function testPositionBoardUp()
  {
    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $category = App\Category::sortedFirst();
    $board = factory(App\Board::class)->create(['category_id' => $category->id]);

    $this->actingAs($user)
      ->visit("/admin/categories/{$category->slug}")
      ->within('section > ul > li:last-child', function() {
        $this->press('up');
      })
      ->within('section > ul > li:nth-last-child(2)', function() use ($board) {
        $this->see($board->name);
      });
  }

  public function testPositionBoardDown()
  {
    $category = App\Category::sortedFirst();
    factory(App\Board::class)->create(['category_id' => $category->id]);

    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = $category->firstBoard();

    $this->actingAs($user)
      ->visit("/admin/categories/{$category->slug}")
      ->within('section > ul > li:first-child', function() {
        $this->press('down');
      })
      ->within('section > ul > li:nth-child(2)', function() use ($board) {
        $this->see($board->name);
      });
  }

  public function testPositionBoardLast()
  {
    $category = App\Category::sortedFirst();
    factory(App\Board::class)->create(['category_id' => $category->id]);

    $user = App\Role::where('name', 'admin')->first()->users()->first();
    $board = $category->firstBoard();

    $this->actingAs($user)
      ->visit("/admin/categories/{$category->slug}")
      ->within('section > ul > li:first-child', function() {
        $this->press('last');
      })
      ->within('section > ul > li:last-child', function() use ($board) {
        $this->see($board->name);
      });
  }
}
