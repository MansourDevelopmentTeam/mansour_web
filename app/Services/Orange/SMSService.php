<?php

namespace App\Services\Orange;

use Illuminate\Support\Facades\Http;

class SMSService
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function sendSMS(string $mobileNumber, string $message)
    {
        $uri = $this->config['send_sms_api_uri'];
        $requestBody = [
            "BankCode" => $this->config['username'],
            "BankPWD" => $this->config['password'],
            "SenderID" => $this->config['sender_id'],
            "MsgText" => $message,
            "MobileNo" => '+2' . $mobileNumber
        ];
        return Http::post($this->config['api_domain'] . $uri, $requestBody);
    }
}