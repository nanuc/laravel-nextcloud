<?php

namespace Nanuc\Nextcloud;

use Illuminate\Support\ServiceProvider;

class NextcloudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-nextcloud.php' => config_path('laravel-nextcloud.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-nextcloud.php', 'laravel-nextcloud'
        );

        $this->app->singleton('nextcloud-api', fn() => new NextcloudFactory());
    }
}
