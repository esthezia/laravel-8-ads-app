<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // make MySQL < 5.7.7 play nice with the utf8mb4 encoding
        // (https://laravel-news.com/laravel-5-4-key-too-long-error)
        \Illuminate\Support\Facades\Schema::defaultStringLength(200);
    }
}
