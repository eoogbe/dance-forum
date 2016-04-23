<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  use Sluggable, Viewable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'pinned_at'];

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['pinned_at'];

  /**
   * Get all the posts for the topic.
   */
  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  /**
   * Get all the views for the topic.
   */
  public function views()
  {
    return $this->hasMany(TopicView::class);
  }

  /**
   * Get the board for the topic.
   */
  public function board()
  {
    return $this->belongsTo(Board::class);
  }

  /**
   * Get all the posts written for the topic including the trashed ones.
   */
  public function postsWithTrashed()
  {
    return $this->posts()->withTrashed()->oldest();
  }

  /**
   * Get a paginator for all the posts written for the topic including the trashed ones.
   */
  public function paginatedPosts()
  {
    return $this->postsWithTrashed()->paginate();
  }

  /**
   * Get the number of posts for the topic.
   */
  public function postCount()
  {
    return $this->posts()->count();
  }

  /**
   * Get the first post written for the topic.
   */
  public function firstPost()
  {
    return $this->posts()->oldest()->first();
  }

  /**
  * Get the latest post written for the topic.
  */
  public function lastPost()
  {
    return $this->posts()->latest()->first();
  }

  /**
   * Get the name of the user who created the topic.
   */
  public function authorName()
  {
    return $this->firstPost()->authorName();
  }

  /**
   * Checks if the topic has any posts created after the given user last viewed the topic.
   */
  public function hasNewPosts($user)
  {
    return $this->newPosts($user)->exists();
  }

  /**
   * Get the first post for the topic that was created after the given user last viewed the topic.
   */
  public function firstNewPost($user)
  {
    return $this->newPosts($user)->first();
  }

  /**
   * Get all the posts for the topic that were created after the latest view by the given user.
   */
  private function newPosts($user)
  {
    $lastView = $this->lastViewBy($user);
    $posts = $this->posts();

    return $lastView ? $posts->where('created_at', '>', $lastView->updated_at) : $posts;
  }

  /**
   * Get the latest view by the given user for the topic.
   */
  private function lastViewBy($user)
  {
    return $this->views()
      ->where('user_id', $user->id)
      ->latest('updated_at')
      ->first();
  }

  /**
   * Check if the topic is pinned.
   */
  public function isPinned()
  {
    return !is_null($this->pinned_at);
  }
}
