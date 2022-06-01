<?php

namespace App\Listeners;

use App\Events\WalletRedeem;
use App\Notifications\WalletRedeemNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class WalletRedeemWithdraw
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\WalletRedeem  $event
     * @return void
     */
    public function handle(WalletRedeem $event)
    {
        $walletRedeemAmount = $event->walletAmount;
        $user = $event->user;
        Notification::send($user, new WalletRedeemNotification($walletRedeemAmount));
    }
}
