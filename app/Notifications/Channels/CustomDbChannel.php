<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class CustomDbChannel
{

  public function __construct()
  {
  }

  public function send($notifiable, Notification $notification)
  {
    $data = $notification->toDatabase($notifiable);
    // dd($data);
    return $notifiable->routeNotificationFor('database')->create([
        'id' => $notification->id,
        'type' => $data['type'],
        'body' => $data['body'],
        'body_ar' => $data['body_ar'] ?? null,
        'title' => $data['title'],
        'title_ar' => $data['title_ar'] ?? null,
        'item_id' => $data['item_id'],
        'item_link' => $data['item_link'] ?? null,
        'image' => $data['image'] ?? null,
        'user_id'=> $notifiable->id,
        "read" => 0
    ]);
  }
}
