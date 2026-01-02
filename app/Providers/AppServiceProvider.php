<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Portfolio;
use App\Models\Chat;
use App\Models\Comment;
use App\Policies\PortfolioPolicy;
use App\Policies\ChatPolicy;
use App\Policies\CommentPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Portfolio::class, PortfolioPolicy::class);
        Gate::policy(Chat::class, ChatPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
    }
}
