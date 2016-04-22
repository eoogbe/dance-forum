<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['content', 'topic_id', 'parent_id'];

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['deleted_at'];

  /**
   * Get the user who wrote the post.
   */
   public function author()
   {
     return $this->belongsTo(User::class, 'author_id');
   }

   /**
    * Get the topic for the post.
    */
   public function topic()
   {
     return $this->belongsTo(Topic::class);
   }

   /**
    * Get the post replied to.
    */
   public function parentPost()
   {
     return $this->belongsTo(Post::class, 'parent_id');
   }

   /**
    * Checks if the post has been updated since it was created.
    */
   public function isUpdated()
   {
     return $this->created_at->ne($this->updated_at);
   }

   /**
    * Get the name of the user who wrote the post.
    */
   public function authorName()
   {
     return $this->author->name;
   }
}
