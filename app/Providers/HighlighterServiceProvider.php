<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\Highlighter;

class HighlighterServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
      //
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->singleton('highlighter', function ($app) {
      return new Highlighter();
    });
  }
}
