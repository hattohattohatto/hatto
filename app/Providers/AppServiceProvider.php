<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Support\Facades\Gate;



class AppServiceProvider extends ServiceProvider
{


    /**
     * ブートストラップの使用
     *
     * @return void
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Gate::define('update-tweet', function (User $user, Tweet $tweet) {
            return $user->id === $tweet->user_id;
        });
    }
}
