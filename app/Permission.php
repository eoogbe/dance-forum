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
   * Breaks down the permission name into an array of the permissions represented by its parts.
   */
  public static function parseNames($name)
  {
    $names = [$name];

    for ($i = strpos($name, '.'); $i !== false; $i = strpos($name, '.', $i + 1)) {
      $names[] = substr($name, 0, $i);
    }

    return $names;
  }

  /**
   * Scope a query to only include permissions whose specificity is no greater than the given
   * depth.
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeMaxDepth($query, $depth)
  {
    return $query->where(DB::raw('LENGTH(name) - LENGTH(REPLACE(name, ".", ""))'), '<=',
      $depth);
  }

  /**
   * Scope a query to only include permissions whose specificity is no less than the given
   * depth.
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeMinDepth($query, $depth)
  {
    return $query->where(DB::raw('LENGTH(name) - LENGTH(REPLACE(name, ".", ""))'), '>=',
      $depth);
  }

  /**
   * Scope a query to only include permissions with the given names ordered by decreasing specificity.
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeByNames($query, $names)
  {
    return $query->whereIn('name', $names)->orderBy(DB::raw('LENGTH(permissions.name)'), 'desc');
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
      $modelClass = ucfirst($parts[1]);
      $model = call_user_func(["App\\$modelClass", 'find'], $parts[2]);
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
