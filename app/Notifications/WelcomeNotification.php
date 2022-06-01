<?php

namespace App\Notifications;

use App\Notifications\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        return [
            "user_id" => $notifiable->id,
            "type" => 1,
            "item_id" => null,
            "item_link" => null,
            "title" => trans('notifications.welcomeMessageTitle', [], $notifiable->getLang()),
            "body" => trans('notifications.welcomeMessageBody', [], $notifiable->getLang()),
            "data" => null
        ];
    }
}
