<?php

namespace App\Notifications;

use App\Facade\Sms;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use App\Models\Orders\OrderState;
use App\Models\Transformers\CustomerOrderTransformer;
use App\Notifications\Channels\FcmChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Channels\CustomDbChannel;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStateChanged extends Notification
{
    use Queueable;

    private $order;

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
        return [
            'mail',
            CustomDbChannel::class,
            FcmChannel::class,
//            SmsChannel::class
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            "user_id" => $notifiable->id,
            "type" => 5,
            "item_id" => $this->order->id,
            "item_link" => null,
            "read" => 0,
            "title" => trans('notifications.orderStateChangedTitle', ['order_state' => $this->order->state->name],"en"),
            "title_ar" => trans('notifications.orderStateChangedTitle', ['order_state' => $this->order->state->name_ar], 'ar'),
            "body" => trans('notifications.orderStateChangedBody', ['order_state' => $this->order->state->name, "order_id" => $this->order->id], "en"),
            "body_ar" => trans('notifications.orderStateChangedBody', ['order_state' => $this->order->state->name_ar, "order_id" => $this->order->id], 'ar'),
        ];
    }

    public function toFcm($notifiable)
    {
        $user_locale = ($notifiable->getLang() == "en" ? 1 : 2);
        $transformer = app()->make(CustomerOrderTransformer::class);
        return [
            "user_id" => $notifiable->id,
            "type" => 5,
            "item_id" => $this->order->id,
            "title" => trans('notifications.orderStateChangedTitle', ['order_state' => $this->order->state->getName($user_locale)], $notifiable->getLang()),
            "body" => trans('notifications.orderStateChangedBody', ['order_state' => $this->order->state->getName($user_locale), "order_id" => $this->order->id], $notifiable->getLang()),
            "data" => $this->order->state_id == OrderState::DELIVERED ? $transformer->transform($this->order) : null
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = "Order Status Changed";
        if ($this->order->state_id == 6){
            $subject = "Order Cancelled";
        }
        return (new MailMessage)->subject($subject)->view(
            'emails.order_state', ['order' => $this->order]
        );
    }

    public function toSms($notifiable)
    {
        $msg =
            'Dear customer, your online order #'
            . $this->order->id . ' has been '
            . strtolower($this->order->state->name) . ', ' . $this->order->url;

        return [
            'phone' => $this->order->phone,
            'msg'   => $this->order->state_id == OrderState::CANCELLED ? trans('notifications.cancelSms') : $msg
        ];
    }
}
