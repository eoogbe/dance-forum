<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Topic;

class TopicPolicy
{
  use HandlesAuthorization;

  /**
   * Determine if the given user can create posts for the given topic.
   *
   * @param  User  $user
   * @param  Topic  $topic
   * @return bool
   */
  public function createPost(User $user, Topic $topic)
  {
    return $user->hasPermission("createPost.topic.{$topic->id}");
  }
}
