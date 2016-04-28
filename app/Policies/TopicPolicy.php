<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Topic;

class TopicPolicy
{
  use HandlesAuthorization;

  /**
  * Determine if the given user can view the given topic.
  *
  * @param  User  $user
  * @param  Topic  $topic
  * @return bool
  */
  public function show($user, Topic $topic)
  {
    return !$topic->isHidden() || $user &&
      ($user->isAllowedTo("update.topic.{$topic->id}") ||
      $user->isAllowedTo("delete.topic.{$topic->id}"));
  }

  /**
  * Determine if the given user can store a newly created topic.
  *
  * @param  User  $user
  * @return bool
  */
  public function store(User $user)
  {
    return $user->isAllowedTo('create.topic');
  }

  /**
   * Determine if the given user can update the given topic.
   *
   * @param  User  $user
   * @param  Topic  $topic
   * @return bool
   */
  public function update(User $user, Topic $topic)
  {
    return $user->isAllowedTo("update.category.{$topic->board->category_id}") ||
      $user->isAllowedTo("update.board.{$topic->board_id}") ||
      $user->isAllowedTo("update.topic.{$topic->id}");
  }

  /**
   * Determine if the given user can delete the given topic.
   *
   * @param  User  $user
   * @param  Topic  $topic
   * @return bool
   */
  public function destroy(User $user, Topic $topic)
  {
    return $user->isAllowedTo("delete.category.{$topic->board->category_id}") ||
      $user->isAllowedTo("delete.board.{$topic->board_id}") ||
      $user->isAllowedTo("delete.topic.{$topic->id}");
  }

  /**
   * Determine if the given user can add a post to the given topic.
   *
   * @param  User  $user
   * @param  Topic  $topic
   * @return bool
   */
  public function addPost(User $user, Topic $topic)
  {
    return !$topic->isLocked() && $user->isAllowedTo('create.post');
  }

  /**
  * Determine if the given user can pin the given topic.
  *
  * @param  User  $user
  * @param  Topic  $topic
  * @return bool
  */
  public function pin(User $user, Topic $topic)
  {
    return $this->update($user, $topic);
  }

  /**
   * Determine if the given user can lock the given topic.
   *
   * @param  User  $user
   * @param  Topic  $topic
   * @return bool
   */
  public function lock(User $user, Topic $topic)
  {
    return $this->update($user, $topic);
  }

  /**
   * Determine if the given user can hide the given topic.
   *
   * @param  User  $user
   * @param  Topic  $topic
   * @return bool
   */
  public function hide(User $user, Topic $topic)
  {
    return $this->update($user, $topic);
  }

  /**
   * Determine if the given user can update permissions for the given topic.
   *
   * @param  User  $user
   * @param  Topic  $topic
   * @return bool
   */
  public function updatePermissions(User $user, Topic $topic)
  {
    return $user->isAllowedTo('update.permission');
  }
}
