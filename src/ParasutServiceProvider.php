<?php

namespace TarfinLabs\Parasut;

use Illuminate\Support\ServiceProvider;
use TarfinLabs\Parasut\API\ClientGateway;
use TarfinLabs\Parasut\API\HttpClientGateway;

class ParasutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfigs();
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigs();

        // Register the main class to use with the facade
        $this->app->singleton(ClientGateway::class, fn() => new HttpClientGateway(
            config('parasut.grant_type'),
            config('parasut.client_id'),
            config('parasut.client_secret'),
            config('parasut.username'),
            config('parasut.password'),
            config('parasut.redirect_uri'),
        ));
    }

    /**
     * Merge the configs.
     */
    protected function mergeConfigs(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/parasut.php', 'parasut');
    }

    /**
     * Publish the configs.
     */
    protected function publishConfigs(): void
    {
        $this->publishes([
            __DIR__.'/../config/parasut.php' => config_path('parasut.php'),
        ], 'config');
    }
}
