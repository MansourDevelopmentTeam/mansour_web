<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreationListener
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        // notify admin
        Notification::create([
            "title" => "New Order",
            "body" => "{$event->order->customer->name} has created a new order.",
            "type" => Notification::ORDERTYPE,
            "item_id" => $event->order->id
        ]);
    }
}
