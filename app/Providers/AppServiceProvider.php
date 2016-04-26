<?php

namespace App\Providers;

use Auth;
use Blade;
use Validator;
use Illuminate\Support\ServiceProvider;

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

    Validator::extend('password', function($attribute, $value, $parameters, $validator) {
      return Auth::validate(['email' => Auth::user()->email, 'password' => $value]);
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
