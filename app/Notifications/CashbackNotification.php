<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomDbChannel;
use App\Notifications\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CashbackNotification extends Notification
{
    use Queueable;

    private $walletAmount;

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
            FcmChannel::class,
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
            "title" => trans('notifications.cash_back_title', [],"en"),
            "title_ar" => trans('notifications.cash_back_title', [], 'ar'),
            "body" => trans('notifications.cash_back_added', ['amount' => $this->walletAmount], "en"),
            "body_ar" => trans('notifications.cash_back_added', ['amount' => $this->walletAmount], 'ar'),
        ];
    }

    public function toFcm($notifiable)
    {
        $lang = $notifiable->getLang();
        Log::info('CashbackNotification class');
        return [
            "user_id" => $notifiable->id,
            "type" => 5,
            "item_id" => null,
//            "data" => trans('notifications.cash_back_added', ['amount' => $this->walletAmount], $lang),
            "title" => trans('notifications.cash_back_title', [], $lang),
            "body" => trans('notifications.cash_back_added', ['amount' => $this->walletAmount], $lang)
        ];
    }
}
