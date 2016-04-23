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

    User::created(function ($user) {
      $user->roles()->create([
        'name' => "user.{$user->id}"
      ]);
      
      $user->roles()->attach(Role::where('name', 'member')->first());
    });

    Topic::created(function ($topic) {
      Role::where('name', 'member')->first()->createPermissions(["createPost.topic.{$topic->id}"]);
    });

    Post::created(function ($post) {
      $post->author->createPermissions([
        "update.post.{$post->id}",
        "destroy.post.{$post->id}",
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
