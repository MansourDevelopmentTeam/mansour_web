<?php

namespace App\Providers;

use App\Events\WalletRedeem;
use App\Listeners\WalletRedeemWithdraw;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\OrderCreated' => [
            'App\Listeners\OrderCreationListener',
        ],
        'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'SocialiteProviders\\Apple\\AppleExtendSocialite@handle'
        ],
        WalletRedeem::class => [
            WalletRedeemWithdraw::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
