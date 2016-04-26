<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Role;

class RolePolicy
{
  use HandlesAuthorization;

  /**
  * Determine if the given user can view the index of roles.
  *
  * @param  User  $user
  * @return bool
  */
  public function index(User $user)
  {
    return $user->isAllowedTo('viewAdminPanel.role');
  }

  /**
  * Determine if the given user can view the given role.
  *
  * @param  User  $user
  * @param  Role  $role
  * @return bool
  */
  public function show(User $user, Role $role)
  {
    return $user->isAllowedTo('viewAdminPanel.role');
  }

  /**
  * Determine if the given user can store a newly created role.
  *
  * @param  User  $user
  * @return bool
  */
  public function store(User $user)
  {
    return $user->isAllowedTo('create.role');
  }

  /**
   * Determine if the given user can update the given role.
   *
   * @param  User  $user
   * @param  Role  $role
   * @return bool
   */
  public function update(User $user, Role $role)
  {
    return $user->isAllowedTo("update.role.{$role->id}");
  }

  /**
   * Determine if the given user can delete the given role.
   *
   * @param  User  $user
   * @param  Role  $role
   * @return bool
   */
  public function destroy(User $user, Role $role)
  {
    return $user->isAllowedTo("delete.role.{$role->id}");
  }

  /**
   * Determine if the given user can update users for the given role.
   *
   * @param  User  $user
   * @param  Role  $role
   * @return bool
   */
  public function updateUsers(User $user, Role $role)
  {
    return $user->isAllowedTo("update.role.{$role->id}");
  }
}
