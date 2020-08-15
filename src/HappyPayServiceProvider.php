<?php

namespace Atxy2k\HappyPay;

use Illuminate\Support\ServiceProvider;

class HappyPayServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'atxy2k');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'atxy2k');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/happypay.php', 'happypay');

        // Register the service the package provides.
        $this->app->singleton('happypay', function ($app) {
            return new HappyPay;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['happypay'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/happypay.php' => config_path('happypay.php'),
        ], 'happypay.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/atxy2k'),
        ], 'happypay.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/atxy2k'),
        ], 'happypay.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/atxy2k'),
        ], 'happypay.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
