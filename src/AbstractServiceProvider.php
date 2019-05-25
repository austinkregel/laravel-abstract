<?php

namespace Kregel\LaravelAbstract;

use Illuminate\Support\ServiceProvider;

class AbstractServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/AbstractRouteServiceProvider.php' => app_path('Providers/AbstractRouteServiceProvider.php'),
            ], 'provider');
        }
    }
}
