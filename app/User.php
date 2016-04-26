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
    'name', 'email', 'password', 'login_at',
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
}
