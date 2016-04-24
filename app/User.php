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
  * Get all the permissions for the user.
  */
  public function permissions()
  {
    return $this->belongsToMany(Permission::class)->withPivot('has_access');
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
  public function hasPermission($name)
  {
    $names = $this->parsePermissionNames($name);

    $userPermission = $this->permissions()->whereIn('name', $names)->first();

    if ($userPermission) {
      return $userPermission->pivot->has_access;
    }

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
   * Creates permissions with the given names for the user.
   */
  public function createPermission($names)
  {
    if (!is_array($names)) {
      $names = [$names];
    }

    foreach ($names as $name) {
      $permission = Permission::create(compact('name'));
      $this->permissions()->attach($permission, ['has_access' => true]);
    }
  }

  /**
   * Attaches existing permissions with the given names to the user.
   */
  public function attachPermission($names)
  {
    if (!is_array($names)) {
      $names = [$names];
    }

    $permissionIds = Permission::whereIn('name', $names)->pluck('id')->toArray();
    $this->permissions()->attach(array_fill_keys($permissionIds, ['has_access' => true]));
  }

  /**
   * Detaches permissions with the given names from the user.
   */
  public function detachPermission($names)
  {
    if (!is_array($names)) {
      $names = [$names];
    }

    $permissionIds = $this->permissions()->whereIn('name', $names)->getRelatedIds()->toArray();
    $this->permissions()->detach($permissionIds);
  }
}
