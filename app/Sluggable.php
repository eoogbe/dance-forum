<?php

namespace App;

trait Sluggable
{
  /**
   * Get the route key for the model.
   *
   * @return string
   */
  public function getRouteKeyName()
  {
    return 'slug';
  }

  /**
   * Set the name and generate the slug from the name.
   *
   * @param string $value
   */
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = $value;
    $this->setSlugAttribute($value);
  }

  /**
   * Sluggify the slug.
   *
   * @param string $value
   */
  public function setSlugAttribute($value)
  {
    $this->attributes['slug'] = $this->sluggify($value);
  }

  /**
   * Generate the slug from the name.
   *
   * @param  string  $name
   * @return string
   */
  private function sluggify($name) {
    $slug = str_slug($name);

    return static::where(['slug' => $slug])->exists() ? uniqid($slug) : $slug;
  }
}
