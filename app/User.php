<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Permissible;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'login_at', 'pronouns', 'description',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['login_at'];

  /**
   * Get the ids of users that are neither banned nor shadow banned.
   */
  public static function unblockedIds()
  {
    return static::whereNull('blocked_status_id')->pluck('id');
  }

  /**
   * Get the route key for the model.
   *
   * @return string
   */
  public function getRouteKeyName()
  {
    return 'name';
  }

  /**
   * Get all the posts the user wrote.
   */
  public function posts()
  {
    return $this->hasMany(Post::class, 'author_id');
  }

  /**
   * Get all the subscriptions for the user.
   */
  public function subscriptions()
  {
    return $this->hasMany(Subscription::class);
  }

  /**
   * Get the blocked status for the user.
   */
  public function blockedStatus()
  {
    return $this->belongsTo(BlockedStatus::class);
  }

  /**
  * Get all the roles for the user.
  */
  public function roles()
  {
    return $this->belongsToMany(Role::class);
  }

  /**
   * Get the number of posts for the user.
   */
  public function postCount()
  {
    return $this->posts()->count();
  }

  /**
   * Checks if the user has a role with the given name.
   */
  public function hasRole($name)
  {
    return $this->roles()->where('name', $name)->exists();
  }

  /**
   * Checks if the user has a permission with the given name.
   */
  public function isAllowedTo($name)
  {
    if ($this->isBanned()) {
      return false;
    }

    $names = Permission::parseNames($name);
    $userPermission = $this->permissions()->byNames($names)->first();

    if ($userPermission) {
      return $userPermission->pivot->has_access;
    }

    foreach ($this->roles as $role) {
      if ($role->isAllowedTo($names)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Create a subscription for the user to the given topic if not already exists.
   */
  public function subscribeTo($topic)
  {
    $this->subscriptions()->firstOrCreate(['topic_id' => $topic->id]);
  }

  /**
   * Checks if the user is subscribed to the given topic.
   */
  public function isSubscribedTo($topic)
  {
    return $this->subscriptions()->where('topic_id', $topic->id)->exists();
  }

  /**
   * Check if the user is banned.
   */
  public function isBanned()
  {
    return $this->blockedStatus ? $this->blockedStatus->name === 'banned' : false;
  }

  /**
   * Check if the user is shadow banned.
   */
  public function isShadowBanned()
  {
    return $this->blockedStatus ? $this->blockedStatus->name === 'shadow banned' : false;
  }
}
