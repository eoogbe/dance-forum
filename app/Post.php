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
     return $this->author ? $this->author->name : '[deleted]';
   }

   /**
    * Get the offset of the post in its topic.
    */
   public function offset()
   {
     return $this->topic
      ->postsWithTrashed()
      ->where('created_at', '<=', $this->created_at)
      ->count();
   }

   /**
    * Get an excerpt of the content with a 100 character radius of the given phrase.
    */
   public function excerpt($phrase)
   {
     $radius = 100;

     $phraseLength = strlen($phrase);

     if ($phraseLength >= $radius) {
       return str_limit($phrase, $radius * 2);
     }

     $contentParts = explode($phrase, $this->content, 2);

     if (!isset($contentParts[1])) {
       return str_limit($this->content, $radius * 2);
     }

     $partLength = $radius - floor($phraseLength / 2);

     $prefixStart = max(strlen($contentParts[0]) - $partLength, 0);
     $prefix = substr($contentParts[0], $prefixStart);

     if ($prefixStart > 0) {
       $prefix = "...$prefix";
     }

     $suffix = substr($contentParts[1], 0, $partLength);

     return str_limit("$prefix$phrase$suffix", $radius * 2);
   }
}
