<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

use App\User;
use App\Role;
use App\Topic;
use App\Post;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Blade::directive('role', function($expression) {
      return "<?php if (Auth::check() && Auth::user()->hasRole{$expression}): ?>";
    });

    Post::created(function ($post) {
      $post->author->createPermission([
        "update.post.{$post->id}",
        "delete.post.{$post->id}",
      ]);
    });
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
      //
  }
}
