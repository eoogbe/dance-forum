<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Board;

class BoardPolicy
{
  use HandlesAuthorization;

  /**
  * Determine if the given user can view the index of boards.
  *
  * @param  User  $user
  * @return bool
  */
  public function index(User $user)
  {
    return $user->isAllowedTo('viewAdminPanel.board');
  }

  /**
  * Determine if the given user can view the given board.
  *
  * @param  User  $user
  * @param  Board  $board
  * @return bool
  */
  public function show(User $user, Board $board)
  {
    return $user->isAllowedTo('viewAdminPanel.board');
  }

  /**
  * Determine if the given user can store a newly created board.
  *
  * @param  User  $user
  * @return bool
  */
  public function store(User $user)
  {
    return $user->isAllowedTo('create.board');
  }

  /**
   * Determine if the given user can update the given board.
   *
   * @param  User  $user
   * @param  Board  $board
   * @return bool
   */
  public function update(User $user, Board $board)
  {
    return $user->isAllowedTo("update.board.{$board->id}");
  }

  /**
   * Determine if the given user can delete the given board.
   *
   * @param  User  $user
   * @param  Board  $board
   * @return bool
   */
  public function destroy(User $user, Board $board)
  {
    return $user->isAllowedTo("delete.board.{$board->id}");
  }

  /**
   * Determine if the given user can update permissions for the given board.
   *
   * @param  User  $user
   * @param  Board  $board
   * @return bool
   */
  public function updatePermissions(User $user, Board $board)
  {
    return $user->isAllowedTo('update.permission');
  }
}
