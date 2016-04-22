<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
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
   * Checks if the user has a role with the given name.
   */
  public function hasRole($name)
  {
    return $this->roles()->where('name', $name)->exists();
  }

  /**
   * Checks if the user has a permission with the given name.
   */
  public function hasPermission($name)
  {
    $names = $this->parsePermissionNames($name);

    foreach ($this->roles as $role) {
      if ($role->hasPermission($names)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Breaks down the permission name into an array of the permissions represented by its parts.
   */
  private function parsePermissionNames($name)
  {
    $names = [$name];

    for ($i = strpos($name, '.'); $i !== false; $i = strpos($name, '.', $i + 1)) {
      $names[] = substr($name, 0, $i);
    }

    return $names;
  }

  /**
   * Creates permissions with the given names for the shadow role of the user.
   */
  public function createPermissions($names)
  {
    return $this->shadowRole()->createPermissions($names);
  }

  /**
   * Gets the role unique to the user.
   */
  private function shadowRole()
  {
    return $this->roles()->where('name', "user.{$this->id}")->first();
  }
}
