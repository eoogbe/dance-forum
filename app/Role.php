<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
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
    return $this->permissions()->whereIn('name', $names)->exists();
  }

  /**
   * Creates permissions with the given names for the role.
   */
  public function createPermissions($names)
  {
    $records = array_map(function($name) {
      return compact('name');
    }, $names);

    $this->permissions()->createMany($records);
  }
}
