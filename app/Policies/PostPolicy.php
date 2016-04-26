<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Post;

class PostPolicy
{
  use HandlesAuthorization;

  /**
   * Determine if the given user can update the given post.
   *
   * @param  User  $user
   * @param  Post  $post
   * @return bool
   */
  public function update(User $user, Post $post)
  {
    return !$post->topic->isLocked() && $user->isAllowedTo("update.post.{$post->id}");
  }

  /**
   * Determine if the given user can delete the given post.
   *
   * @param  User  $user
   * @param  Post  $post
   * @return bool
   */
  public function destroy(User $user, Post $post)
  {
    return !$post->topic->isLocked() && $user->isAllowedTo("delete.post.{$post->id}");
  }

  /**
   * Determine if the given user can restore the given post.
   *
   * @param  User  $user
   * @param  Post  $post
   * @return bool
   */
  public function restore(User $user, Post $post)
  {
    return $user->isAllowedTo("restore.post.{$post->id}");
  }
}
