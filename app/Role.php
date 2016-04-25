<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  use Sluggable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name'];

  /**
  * Get all the users for the role.
  */
  public function users()
  {
    return $this->belongsToMany(User::class);
  }

  /**
  * Get all the permissions for the role.
  */
  public function permissions()
  {
    return $this->belongsToMany(Permission::class);
  }

  /**
   * Checks if the role has a permission with one of the given names.
   */
  public function hasPermission($names)
  {
    return $this->permissions()->whereIn('name', (array) $names)->exists();
  }

  /**
   * Creates permissions with the given names for the role.
   */
  public function createPermission($names)
  {
    $records = array_map(function($name) {
      return compact('name');
    }, (array) $names);

    $this->permissions()->createMany($records);
  }

  /**
   * Attaches existing permissions with the given names to the role.
   */
  public function attachPermission($names)
  {
    if (!is_array($names)) {
      $names = [$names];
    }

    $permissionIds = Permission::whereIn('name', $names)->pluck('id')->toArray();
    $this->permissions()->attach($permissionIds);
  }
}
