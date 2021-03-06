<?php
namespace Helper;

use App\Role;
use App\Permission;
use App\Category;
use App\Board;

class Functional extends \Codeception\Module
{
  public function grabRole()
  {
    return Role::where('name', 'Admin')->first();
  }

  public function grabPermission()
  {
    return Permission::first();
  }

  public function grabCategory()
  {
    return Category::orderBy('position')->first();
  }

  public function grabBoard()
  {
    return Board::first();
  }
}
