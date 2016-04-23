<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\Pagination;

class PaginationServiceProvider extends ServiceProvider
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
    $this->app->singleton('pagination', function ($app) {
      return new Pagination();
    });
  }
}
