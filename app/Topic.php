<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  use Sluggable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name'];

  /**
   * Get all the posts for the topic.
   */
  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  /**
   * Get the latest post written for the topic.
   */
  public function lastPost()
  {
    return $this->hasMany(Post::class)->latest()->first();
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
   * Get the name of the user who created the topic.
   */
  public function authorName()
  {
    return $this->firstPost()->authorName();
  }
}
