<?php

namespace App\Notifications;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Mail\StockNotifications;
use App\Notifications\Channels\FcmChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Channels\CustomDbChannel;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Notifications\Notification AS NotificationModel;

class ProductAvailable extends Notification
{
    private $product;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return [CustomDbChannel::class, FcmChannel::class, 'mail'];
        return [CustomDbChannel::class, FcmChannel::class];
    }

    public function toDatabase($notifiable)
    {
        return [
            "user_id" => $notifiable->id,
            "type" => NotificationModel::TYPE_PRODUCT,
            "item_id" => $this->product->id,
            "item_link" => config('app.website_url') . "/products/" . Str::slug($this->product->name) . "/" . $this->product->parent_id ."?variant=" . $this->product->id,
            "read" => 0,
            "title" => trans('notifications.productAvailableTitle', ['product_name' => $this->product->name], "en"),
            "title_Ar" => trans('notifications.productAvailableTitle', ['product_name' => $this->product->name], 'ar'),
            "body" => trans('notifications.productAvailableBody', ['product_name' => $this->product->name], "en"),
            "body_ar" => trans('notifications.productAvailableBody', ['product_name' => $this->product->name], 'ar'),
        ];
    }

    public function toFcm($notifiable)
    {
        return [
            "user_id" => $notifiable->id,
            "type" => NotificationModel::TYPE_PRODUCT,
            "item_id" => $this->product->id,
            "title" => trans('notifications.productAvailableTitle', ['product_name' => $this->product->name], $notifiable->getLang()),
            "body" => trans('notifications.productAvailableBody', ['product_name' => $this->product->name], $notifiable->getLang()),
            "data" => null
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
        return (new MailMessage)->subject("{$this->product->name} " . trans('email.isAvailable'))->view(
            'emails.stock_notifier', ["product" => $this->product, "user" =>$notifiable]
        );

    }
}
