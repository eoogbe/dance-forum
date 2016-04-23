<?php

namespace App;

trait Viewable
{
  /**
   * Get the number of views for the model.
   */
  public function viewCount()
  {
    return $this->views()->sum('count');
  }
}
