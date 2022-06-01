<?php

namespace App\Classes\Sms;

use Exception;
use App\Models\Users\Address;
use App\Models\Users\User;
use GuzzleHttp\Psr7\Message;
use App\Contracts\SmsGateway;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


class SmsEg implements SmsGateway
{
    const SMSEG_GATEWAY = 'smseg';
    const SMS_DRIVER_DATABASE = 'database';
    const SMS_DRIVER_GATEWAY = 'gateway';

    protected $gateway;
    protected $driver;
    protected $base_url;
    protected $username;
    protected $password;
    protected $sender_id;

    protected $config;

    public function __construct(array $config)
    {
        $this->client = new \GuzzleHttp\Client(["cookies" => true, 'defaults' => ['verify' => false]]);
        $this->gateway = $config['default'];
        $this->driver = $config['driver'];
        $this->base_url = "https://smssmartegypt.com/sms/api";
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->sender_id = $config['sender_id'];
        $this->config = $config;
    }
    /**
     * send verification
     *
     * @param string $phone
     * @return int|null
     */
    public function send($phone)
    {
        // If we disable sms services fron env
        if ($this->gateway == "" || $this->gateway != self::SMSEG_GATEWAY) {
            return true;
        }

        $code = null;
        if ($this->driver == self::SMS_DRIVER_DATABASE) {

            if(app()->environment('production')){
                $code = rand(1000, 9999);
            } else {
                $code = 1234;
            }

            $message = trans('message.verification_otp_message', ['store' => config('app.name'), 'code' => $code]);
            $this->sendSms($phone, $message);
        } elseif ($this->driver == self::SMS_DRIVER_GATEWAY) {
            $this->sendOtp($phone);
        }

        return $code;
    }

    /**
     * Verify customer phone number
     *
     * @param [type] $phone
     * @param [type] $address_id
     * @param [type] $otp
     * @return boolean
     */
    public function verify($phone, $otp)
    {
        // If we disable sms services from env
        if ($this->gateway == "" || $this->gateway != self::SMSEG_GATEWAY) {
            return true;
        }

        if ($this->driver == self::SMS_DRIVER_DATABASE) {
            return $otp == request()->get('verification_code', null);

        } elseif ($this->driver == self::SMS_DRIVER_GATEWAY) {
            return $this->verifyOtp($phone, request()->get('verification_code'));
        }
    }


    /**
     * Get balance
     *
     * @return void
     */


    public function getBalance()
    {
        // If we disable sms services fron env
        if ($this->gateway == "" || $this->gateway != self::SMSEG_GATEWAY) {
            return true;
        }

        try {
            $res = $this->client->get($this->base_url . '/getBalance',  [
                'form_params' => [
                    'username' => $this->username,
                    'password' => $this->password
                ]
            ]);

            $content = $res->getBody()->getContents();
            $response = json_decode($content, true);

            if (isset($response['type']) && $response['type'] == 'error') {
                throw new Exception(json_encode($response));
            }
            return $response['data']['points'];

        } catch (Exception $e) {
            Log::error("SMS get balance api failed " . json_encode($e->getMessage()));
            return 0;
        }

    }

    /**
     * Send with sms services
     *
     * @param  string $phone
     * @param  string $message
     * @return  void
     */
    public function sendSms($phone, $message)
    {
        try {
            $res = $this->client->post($this->base_url,  [
                'form_params' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'sendername' => $this->sender_id,
                    'mobiles' => $phone,
                    'message' => $message
                ]
            ]);

            $content = $res->getBody()->getContents();
            $response = json_decode($content, true);

            Log::error("SMS Services Response - send sms " . json_encode($response));
        } catch (\Exception $e) {
            Log::error("SMS Services failed - check otp " . $e->getMessage());
        }

    }

    /**
     * Send with otp services
     *
     * @param  string $phone
     * @return  void
     */
    private function sendOtp($phone)
    {
        try {
            $res = $this->client->post($this->base_url . '/otp-send',  [
                'form_params' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'sender' => $this->sender_id,
                    'mobile' => $phone,
                    "lang" => "ar"
                ]
            ]);

            $content = $res->getBody()->getContents();
            $response = json_decode($content, true);

            Log::error("SMS Services Response - send otp " . json_encode($response));
        } catch (\Exception $e) {
            Log::error("SMS Services failed - send otp " . $e->getMessage());
        }

    }

    /**
     * Verify otp for user
     *
     * @param User $user
     * @param string $otp
     * @return void
     */
    public function verifyOtp($phone, $otp)
    {
        try {
            $res = $this->client->post($this->base_url . '/otp-check', [
                'form_params' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'mobile' => $phone,
                    'otp' => $otp,
                    'verify' => true
                ]
            ]);

            $content = $res->getBody()->getContents();
            $response = json_decode($content, true);

            Log::error("SMS Services Response - check otp " . json_encode($response));

            if (isset($response['type']) && $response['type'] == 'error') {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error("SMS Services failed - check otp " . $e->getMessage());
        }
        return false;
    }
}
