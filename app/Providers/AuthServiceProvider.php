<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\User;
use App\Role;
use App\Board;
use App\Category;
use App\Topic;
use App\Post;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\BoardPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\TopicPolicy;
use App\Policies\PostPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Board::class => BoardPolicy::class,
        Category::class => CategoryPolicy::class,
        Topic::class => TopicPolicy::class,
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
