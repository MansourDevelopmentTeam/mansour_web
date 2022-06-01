<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomDbChannel;
use App\Notifications\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WalletRedeemNotification extends Notification
{
    private $walletAmount;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($walletAmount)
    {
        $this->walletAmount = $walletAmount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            CustomDbChannel::class,
            FcmChannel::class
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            "user_id" => $notifiable->id,
            "type" => 5,
            "item_id" => null,
            "item_link" => null,
            "read" => 0,
            "title" => trans('notifications.wallet_redeem_title', [],"en"),
            "title_ar" => trans('notifications.wallet_redeem_title', [], 'ar'),
            "body" => trans('notifications.wallet_redeem_body', ['amount' => $this->walletAmount], "en"),
            "body_ar" => trans('notifications.wallet_redeem_body', ['amount' => $this->walletAmount], 'ar'),
        ];
    }

    public function toFcm($notifiable)
    {
        $user_locale = $notifiable->getLang();
        return [
            "user_id" => $notifiable->id,
            "type" => 5,
            "item_id" => null,
            "title" => __('notifications.wallet_redeem_title', [], $user_locale),
            "body" => __('notifications.wallet_redeem_body', ['amount' => $this->walletAmount], $user_locale),
            "data" => null
        ];
    }
}

