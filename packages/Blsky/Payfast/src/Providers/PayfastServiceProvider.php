<?php

namespace Blsky\Payfast\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Blsky\Payfast\Facades\PayfastCart;

class PayfastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/../Http/routes.php';
        include __DIR__ . '/../Http/helpers.php';
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'payfast');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerFacades();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php',
            'paymentmethods'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php',
            'core'
        );
    }

    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerFacades()
    {
        //to make the cart facade and bind the
        //alias to the class needed to be called.
        $loader = AliasLoader::getInstance();

        $loader->alias('payfastcart', PayfastCart::class);

        $this->app->singleton('payfastcart', function () {
            return new payfastcart();
        });

        $this->app->bind('payfastcart', 'Blsky\Payfast\PayfastCart');
    }
}
