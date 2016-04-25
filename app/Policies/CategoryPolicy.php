<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Category;

class CategoryPolicy
{
  use HandlesAuthorization;

  /**
  * Determine if the given user can view the index of categories.
  *
  * @param  User  $user
  * @return bool
  */
  public function index(User $user)
  {
    return $user->hasPermission('viewAdminPanel.board');
  }

  /**
  * Determine if the given user can view the given category.
  *
  * @param  User  $user
  * @param  Category  $category
  * @return bool
  */
  public function show(User $user, Category $category)
  {
    return $user->hasPermission('viewAdminPanel.board');
  }

  /**
  * Determine if the given user can store a newly created category.
  *
  * @param  User  $user
  * @return bool
  */
  public function store(User $user)
  {
    return $user->hasPermission('create.category');
  }

  /**
   * Determine if the given user can update the given category.
   *
   * @param  User  $user
   * @param  Category  $category
   * @return bool
   */
  public function update(User $user, Category $category)
  {
    return $user->hasPermission("update.category.{$category->id}");
  }

  /**
   * Determine if the given user can delete the given category.
   *
   * @param  User  $user
   * @param  Category  $category
   * @return bool
   */
  public function destroy(User $user, Category $category)
  {
    return $user->hasPermission("delete.category.{$category->id}");
  }
}
