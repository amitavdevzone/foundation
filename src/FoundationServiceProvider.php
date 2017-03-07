<?php

namespace Inferno\Foundation;

use Illuminate\Support\ServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * The register function for the service provider
     */
    public function register()
    {
        $this->app->register(anlutro\LaravelSettings\ServiceProvider::class);
        $this->app->bind('foundation', function ($app) {
            return new Foundation;
        });
    }

    /**
     * This is the boot function where I will load and make other settings
     * required when the service provider is instantiated.
     */
    public function boot()
    {
        // load the routes file
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/./../assets/views', 'inferno-foundation');
    }
}
