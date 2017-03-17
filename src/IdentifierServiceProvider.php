<?php

namespace DBonner\Identifier;

use DBonner\Identifier\PrimeId;
use Jenssegers\Optimus\Optimus;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class IdentifierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        collect($this->app['config']->get('identifier.cast.prime', []))->each(function ($key) {
            Route::bind($key, function ($value) {
                return PrimeId::decode($value);
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Optimus::class, function ($app) {
            return new Optimus(
                $app['config']['identifier.prime_identifier'],
                $app['config']['identifier.prime_inverted'],
                $app['config']['identifier.prime_random']
            );
        });
    }
}
