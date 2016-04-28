<?php

namespace App\Providers;

use Auth;
use Validator;
use Illuminate\Support\ServiceProvider;

use App\User;
use App\Role;
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
    Validator::extend('password', function($attribute, $value, $parameters, $validator) {
      return Auth::validate(['email' => Auth::user()->email, 'password' => $value]);
    });

    User::created(function ($user) {
      $user->roles()->attach(Role::autoAssigned()->pluck('id')->toArray());
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
