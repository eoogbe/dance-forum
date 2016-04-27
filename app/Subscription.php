<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['topic_id'];

  /**
   * Get the topic for the subscription.
   */
  public function topic()
  {
    return $this->belongsTo(Topic::class);
  }

  /**
   * Get the subscriber.
   */
   public function user()
   {
     return $this->belongsTo(User::class);
   }
}
