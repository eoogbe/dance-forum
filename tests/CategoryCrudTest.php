<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryCrudTest extends TestCase
{
  use DatabaseTransactions;

  public function testIndexCategory()
  {
    $category = App\Category::first();

    $this->visit('/')
      ->see($category->name);
  }

  public function testShowCategory()
  {
    $category = App\Category::first();

    $this->visit("/categories/{$category->slug}")
      ->see($category->name);
  }
}
