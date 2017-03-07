<?php

namespace Inferno\Foundation;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Flash\FlashServiceProvider;
use anlutro\LaravelSettings\ServiceProvider as SettingServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * The register function for the service provider
     */
    public function register()
    {
        $this->app->register(SettingServiceProvider::class);
        $this->app->register(FlashServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Setting', 'anlutro\LaravelSettings\Facade');
        $loader->alias('Flash', 'Laracasts\Flash\Facade');

        $this->app->bind('foundation', function ($app) {
            return new Foundation;
        });

        $this->mergeConfigFrom(
            __DIR__.'/./../publishable/foundation.php', 'foundation'
        );

        $this->registerPublishables();
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

    /**
     * This function will register what needs to be published
     * and where the resources needs to go.
     */
    public function registerPublishables()
    {
        // get the base path
        $basePath = dirname(__DIR__);

        // list of things to publish
        $arrPublishable = [
            'inferno_assets' => [
                "$basePath/assets" => public_path('vendor/amitavdevzone/foundation/assets')
            ],
            'config' => [
                "$basePath/publishable/foundation.php" => config_path('foundation.php'),
            ],
        ];

        foreach ($arrPublishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }
}
