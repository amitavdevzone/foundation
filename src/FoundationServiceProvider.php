<?php

namespace Inferno\Foundation;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Inferno\Foundation\Commands\InstallCommand;
use Inferno\Foundation\FoundationEventProvider;
use Inferno\Foundation\Http\Middlewares\RoleMiddleware;
use Inferno\Foundation\Repositories\Watchdog\EloquentWatchdog;
use Inferno\Foundation\Repositories\Watchdog\WatchdogRepository;
use Laracasts\Flash\FlashServiceProvider;
use Laravel\Passport\PassportServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use anlutro\LaravelSettings\ServiceProvider as SettingServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * The register function for the service provider
     */
    public function register()
    {
        $this->app->register(FoundationEventProvider::class);

        // Register the packages
        $this->app->register(SettingServiceProvider::class);
        $this->app->register(FlashServiceProvider::class);
        $this->app->register(PassportServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Setting', 'anlutro\LaravelSettings\Facade');
        $loader->alias('Flash', 'Laracasts\Flash\Facade');

        $this->app->bind('foundation', function ($app) {
            return new Foundation;
        });

        $this->mergeConfigFrom(
            __DIR__.'/./../publishable/config/foundation.php', 'foundation'
        );

        $this->registerPublishables();
        $this->registerCommands();

        $this->app->bind(WatchdogRepository::class, EloquentWatchdog::class);
    }

    /**
     * This is the boot function where I will load and make other settings
     * required when the service provider is instantiated.
     */
    public function boot(Router $router)
    {
        Schema::defaultStringLength(191);

        // load the routes file
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadViewsFrom(__DIR__.'/./../resources/views', 'inferno-foundation');

        if (app()->version() >= 5.4) {
            $router->aliasMiddleware('role', RoleMiddleware::class);
        } else {
            $router->middleware('role', RoleMiddleware::class);
        }
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
                "$basePath/publishable/assets" => public_path('vendor/amitavdevzone/foundation/assets')
            ],
            'config' => [
                "$basePath/publishable/config/foundation.php" => config_path('foundation.php'),
            ],
            'migrations' => [
                "$basePath/publishable/database/migrations" => database_path('migrations'),
            ]
        ];

        foreach ($arrPublishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    /**
     * This function will register all commands for Inferno
     */
    public function registerCommands()
    {
        $this->commands(InstallCommand::class);
    }
}
