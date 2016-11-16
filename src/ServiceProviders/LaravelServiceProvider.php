<?php

namespace DBonner\Identifier\ServiceProviders;

use Jenssegers\Optimus\Optimus;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
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
                env('IDENTIFIER_PRIME'),
                env('IDENTIFIER_INVERTED'),
                env('IDENTIFIER_RANDOM'),
            );
        });
    }
}
