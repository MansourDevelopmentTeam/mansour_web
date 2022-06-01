<?php

namespace App\Models\Services;

use App\Events\NotifyAdmin;
use App\Models\Notifications\Notification;
use App\Models\Users\DeviceToken;
use App\Models\Users\User;
use Illuminate\Support\Facades\Log;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class PushService
{

    public function send($tokens, $device_type, $title, $body, $image = null, $payload_data = null, $product_id = null)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notification = null;
        $data = new PayloadDataBuilder();
        Log::info('PushService Class payload data');
        Log::info($payload_data);

        if ($device_type == DeviceToken::ADNROID) {
            $data->addData(["data" => [
                "title" => $title,
                "body" => $body,
                "image" => $image,
                "data" => $payload_data,
                "product_id" => $product_id
            ]]);
        } elseif ($device_type == DeviceToken::IOS) {
            $notification = $this->buildNotification($title, $body);
            $data_array = [];
            if ($image) {
                $optionBuilder->setMutableContent(true);
                $data_array["url"] = $image;
            }
            if ($payload_data) {
                $data_array["order"] = $payload_data;
            }

            $data_array["product_id"] = $product_id;

            $data->addData(["data" => $data_array]);
        } else {
            $notification = $this->buildNotification($title, $body);
            // $data_array = [];
            // if ($image) {
            //     // $optionBuilder->setMutableContent(true);
            //     $data_array["url"] = $image;
            // }
            // if ($payload_data) {
            //     $data_array["order"] = $payload_data;
            // }

            // $data_array["product_id"] = $product_id;

            $data->addData(["data" => $payload_data]);
        }

        $option = $optionBuilder->build();
        $data = $data->build();
        try {
            $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
            Log::info($downstreamResponse->tokensToDelete());
            $this->deleteTokens($downstreamResponse->tokensToDelete());
        } catch (\Exception $e) {
            Log::error('Pushservice error exception : ' . $e->getTraceAsString());
        }

    }

    private function buildPayloadData($data)
    {
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(["data" => $data]);
        // $dataBuilder->addData(["data" => [
        //     "title" => "title",
        //     "body" => "body",
        //     "image" => "http://dev.soleekhub.com/kareemadmin-staging/assets/img/logo2.png"
        // ]]);

        return $dataBuilder->build();
    }

    private function buildNotification($title, $body, $sound = "default", $icon = "appicon")
    {
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound($sound);
                            // ->setClickAction("rate");

        return $notificationBuilder->build();
    }

    public function deleteTokens($tokens)
    {
        return DeviceToken::whereIn("token", $tokens)->delete();
    }

    public function notify(User $user, $title, $body, $image = null, $data = null, $product_id = null)
    {
        $android_tokens = $user->tokens()->where("device", DeviceToken::ADNROID)->get()->pluck('token')->toArray();

        if (count($android_tokens))
            $this->send($android_tokens, DeviceToken::ADNROID, $title, $body, $image, $data, $product_id);

        $ios_tokens = $user->tokens()->where("device", DeviceToken::IOS)->get()->pluck('token')->toArray();

        if (count($ios_tokens))
            $this->send($ios_tokens, DeviceToken::IOS, $title, $body, $image, $data, $product_id);
    }

    public function notifyUsers($users, $title, $body, $image = null, $data = null, $product_id = null)
    {
        $android_tokens = [];
        $ios_tokens = [];

        foreach ($users as $user) {
            $android_tokens = array_merge($android_tokens, $user->tokens()->where("device", DeviceToken::ADNROID)->get()->pluck('token')->toArray());
            $ios_tokens = array_merge($ios_tokens, $user->tokens()->where(function ($q) {
                $q->where("device", DeviceToken::IOS)->orWhereNull("device");
            })->get()->pluck('token')->toArray());
        }

        if (count($android_tokens))
            $this->send($android_tokens, DeviceToken::ADNROID, $title, $body, $image, $data, $product_id);

        if (count($ios_tokens))
            $this->send($ios_tokens, DeviceToken::IOS, $title, $body, $image, $data, $product_id);
    }

    public function notifyAdmins($title, $body, $item_id = null, $item_type = null,$details = null,$user_id = null)
    {
        // $admins = $this->userRepo->getAdmins();

        $notification = Notification::create([
            "title" => $title,
            "body" => $body,
            "details" => $details,
            "type" => $item_type,
            "item_id" => $item_id,
            "user_id" => $user_id
        ]);
        
        event(new NotifyAdmin($notification));

        // foreach ($admins as $key => $admin) {
        //  $this->notify($admin, $message, $item_id, $item_type);
        // }
    }
}
