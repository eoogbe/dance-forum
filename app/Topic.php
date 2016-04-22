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
    return $this->hasMany(Post::class)->orderBy('created_at');
  }

  /**
   * Get the latest post written for the topic.
   */
  public function lastPost()
  {
    return $this->hasMany(Post::class)->orderBy('created_at', 'desc')->first();
  }

  /**
   * Get the board for the topic.
   */
  public function board()
  {
    return $this->belongsTo(Board::class);
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
    return $this->posts()->first();
  }

  /**
   * Get the name of the user who created the topic.
   */
  public function authorName()
  {
    return $this->firstPost()->authorName();
  }
}
