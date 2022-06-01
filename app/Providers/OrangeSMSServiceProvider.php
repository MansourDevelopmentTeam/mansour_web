<?php

namespace App\Providers;

use App\Services\Orange\SMSService;
use Illuminate\Support\ServiceProvider;

class OrangeSMSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SMSService::class, function($app) {
            return new SMSService(config('orange.sms'));
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
