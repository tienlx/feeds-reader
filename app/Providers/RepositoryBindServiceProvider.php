<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryBindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\RssFeedItemRepositoryInterface::class,
            \App\Repositories\Eloquent\RssFeedItemRepository::class
        );

    }
}
