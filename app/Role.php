<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  use Permissible, Sluggable;

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
   * Checks if the role has a permission with the given name.
   */
  public function isAllowedTo($name)
  {
    $names = is_array($name) ? $name : Permission::parseNames($name);
    $permission = $this->permissions()->byNames($names)->first();

    return $permission ? $permission->pivot->has_access : false;
  }

  /**
   * Allows the role the permission with the given name.
   */
  public function allow($name)
  {
    $permission = $this->permissions()->byNames(Permission::parseNames($name))->first();

    if (!($permission && ($permission->name === $name || $permission->pivot->has_access))) {
      $permission = Permission::firstOrCreate(['name' => $name]);
      $this->permissions()->attach($permission, ['has_access' => true]);
    } else if ($permission->name === $name) {
      $this->permissions()->updateExistingPivot($permission->id, ['has_access' => true]);
    }
  }

  /**
   * Denies the role the permission with the given name.
   */
  public function deny($name)
  {
    $permission = $this->permissions()->where('name', $name)->first();

    if ($permission) {
      $this->permissions()->updateExistingPivot($permission->id, ['has_access' => false]);
    }
  }

  /**
   * Add all the permissions with the given ids to the role and remove the general permissions in
   * the role whose ids are not given.
   */
  public function setGeneralPermissions($permissionIds)
  {
    foreach (Permission::maxDepth(1) as $permission) {
      $isAllowed = in_array($permission->id, $permissionIds);

      if ($this->permissions->where('id', $permission->id)->exists()) {
        $this->permissions()->updateExistingPivot($permission->id, ['has_access' => $isAllowed]);
      } else if ($isAllowed) {
        $this->permissions->attach($permission, ['has_access' => true]);
      }
    }
  }
}
