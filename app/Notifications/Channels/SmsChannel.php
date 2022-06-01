<?php

namespace App\Notifications\Channels;

use App\Facade\Sms;
use App\Models\Orders\OrderState;
use Illuminate\Notifications\Notification;

class SmsChannel 
{
     public function send($notifiable, Notification $notification)
    {
        $sms = $notification->toSms($notifiable);

        Sms::sendSms($sms['phone'], $sms['msg']);
    }
}
