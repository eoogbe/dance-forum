<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
  use Sluggable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'description', 'position'];

  /**
   * Get all the topics for the board.
   */
  public function topics()
  {
    return $this->hasMany(Topic::class);
  }

  /**
   * Get the category for the board.
   */
  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  /**
   * Get the latest post written for the board.
   */
  public function lastPost()
  {
    return $this->posts()->orderBy('created_at', 'desc')->first();
  }

  /**
   * Get all the topics for the board sorted by the newest created post.
   */
  public function sortedTopics()
  {
    return $this->topics()
      ->join('posts', 'topics.id', '=', 'posts.topic_id')
      ->orderBy('posts.created_at', 'desc')
      ->select('topics.*')
      ->distinct();
  }

  /**
   * Get the number of topics for the board.
   */
  public function topicCount()
  {
    return $this->topics()->count();
  }

  /**
   * Get the number of posts for the board.
   */
  public function postCount()
  {
    return $this->posts()->count();
  }

  /**
   * Get all the posts for the board.
   */
  private function posts()
  {
    return $this->hasManyThrough(Post::class, Topic::class);
  }

  /**
   * Get the previous board for the board.
   */
  public function prevBoard()
  {
    return $this->category->boardBefore($this->position);
  }

  /**
   * Get the next board for the board.
   */
  public function nextBoard()
  {
    return $this->category->boardAfter($this->position);
  }

  /**
   * Check if the board is the first one in its category.
   */
  public function isFirst()
  {
    return $this->category->firstPosition() === $this->position;
  }

  /**
   * Check if the board is the last one in its category.
   */
  public function isLast()
  {
    return $this->category->lastPosition() === $this->position;
  }
}
