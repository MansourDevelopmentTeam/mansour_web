<?php

namespace App\Notifications\Channels;

use App\Models\Services\PushService;
use Illuminate\Notifications\Notification;

class FcmChannel 
{
    private $pushService;

    public function __construct(PushService $pushService)
    {
        $this->pushService = $pushService;
    }


    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toFcm($notifiable);
  
        if ($data["type"] == 1 && $data["item_id"]) {
            $item_id = $data["item_id"];
        } else {
            $item_id = null;
        }

        $this->pushService->notify($notifiable, $data["title"], $data["body"], $data["image"] ?? null, $data["data"] ?? null, $item_id);
    }
}
