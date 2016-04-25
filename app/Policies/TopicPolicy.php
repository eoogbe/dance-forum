<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Topic;

class TopicPolicy
{
  use HandlesAuthorization;

  /**
   * Determine if the given user can update the given topic.
   *
   * @param  User  $user
   * @param  Topic  $topic
   * @return bool
   */
  public function update(User $user, Topic $topic)
  {
    return $user->hasPermission("update.topic.{$topic->id}");
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
    return $user->hasPermission("delete.topic.{$topic->id}");
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
    return !$topic->isLocked();
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
    return $user->hasPermission("lock.topic.{$topic->id}");
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
    return $user->hasPermission("pin.topic.{$topic->id}");
  }
}
