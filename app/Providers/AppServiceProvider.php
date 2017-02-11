<?php

namespace App\Providers;

use App\Repository\SettingRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('BlogSetting', function ($app) {
            return new SettingRepository($app, new \Illuminate\Support\Collection());
        });
    }
}
