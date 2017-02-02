<?php

namespace App\Providers;

use App\Helpers\MarkDownHelper;
use Illuminate\Support\ServiceProvider;

class MarkdownServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MarkDownHelper::class, function () {
            return new MarkDownHelper;
        });
    }

    public function provides()
    {
        return [MarkDownHelper::class];
    }
}
