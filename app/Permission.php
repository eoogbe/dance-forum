<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name'];

  /**
   * Scope a query to only include permissions whose specificity is no greater than the given
   * depth.
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeMaxDepth($query, $depth)
  {
    return $query->where(DB::raw('LENGTH(name) - LENGTH(REPLACE(name, ".", ""))'), '<',
      $depth);
  }

  /**
   * Generate the displayName from the name.
   *
   * @return string
   */
  public function generateDisplayName()
  {
    $parts = explode('.', $this->name);
    $action = ucfirst(snake_case($parts[0], ' '));
    $object = snake_case(isset($parts[1]) ? $parts[1] : 'any', ' ');

    if (isset($parts[2])) {
      $model = call_user_func([ucfirst($parts[1]), 'find'], $parts[2]);
      $modelName = $model && $model->name ? $model->name : $parts[2];
      $suffix = "$object $modelName";
    } else if (isset($parts[1])) {
      $suffix = str_plural($object);
    } else {
      $suffix = $object;
    }

    return "$action for $suffix";
  }
}
