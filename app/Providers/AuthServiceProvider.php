<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Post;
use App\Models\Profil;
use App\Models\Comment;
use App\Policies\UserPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\ProfilePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Profil::class => ProfilePolicy::class,
        Comment::class => CommentPolicy::class,
        Post::class => PostPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
