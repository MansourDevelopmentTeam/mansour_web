<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomDbChannel;
use App\Notifications\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderEdited extends Notification
{
    private $order;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDbChannel::class, FcmChannel::class, 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            "user_id" => $notifiable->id,
            "type" => 5,
            "item_id" => $this->order->id,
            "item_link" => null,
            "read" => 0,
            "title" => trans('notifications.orderEditedTitle', ['order_id' => $this->order->id], 'en'),
            "title_ar" => trans('notifications.orderEditedTitle', ['order_id' => $this->order->id], 'ar'),
            "body" => trans('notifications.orderEditedBody', ['order_id' => $this->order->id], 'en'),
            "body_ar" => trans('notifications.orderEditedBody', ['order_id' => $this->order->id], 'ar'),
        ];
    }

    public function toFcm($notifiable)
    {
        return [
            "user_id" => $notifiable->id,
            "type" => 5,
            "item_id" => $this->order->id,
            "title" => trans('notifications.orderEditedTitle', ['order_id' => $this->order->id], $notifiable->getLang()),
            "body" => trans('notifications.orderEditedBody', ['order_id' => $this->order->id], $notifiable->getLang()),
            "data" => null
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)->view(
            'emails.order_edited', ['order' => $this->order]
        );
    }
}
