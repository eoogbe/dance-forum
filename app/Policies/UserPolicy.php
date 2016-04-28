<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;

class UserPolicy
{
  use HandlesAuthorization;

  /**
  * Determine if the given user can view the index of users.
  *
  * @param  User  $user
  * @return bool
  */
  public function index(User $user)
  {
    return $user->isAllowedTo('viewAdminPanel.user');
  }

  /**
  * Determine if the given authethicated user can view the given user account.
  *
  * @param  User  $user
  * @param  User  $model
  * @return bool
  */
  public function show(User $user, User $model)
  {
    return $user->isAllowedTo('viewAdminPanel.user');
  }

  /**
  * Determine if the given authethicated user can update roles for the given user account.
  *
  * @param  User  $user
  * @param  User  $model
  * @return bool
  */
  public function updateRoles(User $user, User $model)
  {
    return $user->isAllowedTo("update.user.{$model->id}");
  }

  /**
  * Determine if the given authethicated user can ban the given user account.
  *
  * @param  User  $user
  * @param  User  $model
  * @return bool
  */
  public function ban(User $user, User $model)
  {
    return $user->isAllowedTo("update.user.{$model->id}");
  }
}
