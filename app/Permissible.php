<?php

namespace App;

trait Permissible
{
  /**
  * Get all the permissions for the model.
  */
  public function permissions()
  {
    return $this->belongsToMany(Permission::class)->withPivot('has_access');
  }

  /**
   * Get all the allowed permissions for the model.
   */
  public function allowedPermissions()
  {
    return $this->permissions()->wherePivot('has_access', true)->orderBy('name');
  }

  /**
   * Creates permissions with the given names for the model.
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
   * Attaches existing permissions with the given names to the model.
   */
  public function attachPermission($names)
  {
    if (!is_array($names)) {
      $names = [$names];
    }

    $permissionIds = Permission::whereIn('name', $names)->pluck('id')->toArray();
    $this->permissions()->attach(array_fill_keys($permissionIds, ['has_access' => true]));
  }
}
