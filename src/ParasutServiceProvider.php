<?php

namespace TarfinLabs\Parasut;

use TarfinLabs\Parasut\API\HttpClientGateway;
use Illuminate\Support\ServiceProvider;
use TarfinLabs\Parasut\Entities\Contact;
use TarfinLabs\Parasut\API\ClientGateway;

class ParasutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->mergeConfigs();

        if ($this->app->runningInConsole()) {
            $this->publishConfigs();
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Register the main class to use with the facade
        $this->app->singleton(ClientGateway::class, function () {
            return new HttpClientGateway(
                config('parasut.grant_type'),
                config('parasut.client_id'),
                config('parasut.client_secret'),
                config('parasut.username'),
                config('parasut.password'),
                config('parasut.redirect_uri'),
            );
        });
    }

    protected function mergeConfigs(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/parasut.php', 'parasut');
    }

    protected function publishConfigs(): void
    {
        $this->publishes([
            __DIR__.'/../config/parasut.php' => config_path('parasut.php'),
        ], 'config');
    }
}
