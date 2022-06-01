<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Facebook\ConversionAPI;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConversionAPI::class, function($app) {
            return new ConversionAPI(config('facebook.conversion_api'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
