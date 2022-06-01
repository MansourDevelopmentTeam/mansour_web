<?php

namespace App\Classes\Sms;

use Exception;
use App\Models\Users\User;
use GuzzleHttp\Psr7\Message;
use App\Contracts\SmsGateway;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SmsMisr implements SmsGateway
{
    const SMSEG_GATEWAY = 'smsmisr';
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
        $this->base_url = "https://smsmisr.com/api";
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->sender_id = $config['sender_id'];
        $this->token = $config['token'];
        $this->msignature = $config['msignature'];
        $this->sms_id = $config['sms_id'];
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
        if ($this->gateway == "") {
            return true;
        }

        if(app()->environment('production')){
            $code = rand(1000, 9999);
        } else {
            $code = 1234;
        }

        // if ($this->driver == self::SMS_DRIVER_DATABASE) {

        //     $message = trans('message.verification_otp_message', ['store' => config('app.name'), 'code' => $code]);
        //     $this->sendSms($phone, $message);

        // } elseif ($this->driver == self::SMS_DRIVER_GATEWAY) {
        $this->sendOtp($phone, $code);
        // }
        return $code;
    }

    /**
     * Verify customer phone number
     *
     * @param  User $user
     * @param  string $otp
     * @return void
     */
    public function verify($user, $otp)
    {
        // If we disable sms services from env
        if ($this->gateway == "") {
            return true;
        }

        return $otp == request()->get('verification_code', null);
    }

    /**
     * Get balance
     *
     * @return void
     */
    public function getBalance()
    {
        // If we disable sms services fron env
        if ($this->gateway == "") {
            return true;
        }

        try {
            $parms = [
                'username' => $this->username,
                'password' => $this->password,
                'SMSID' => $this->sms_id,
                'request' => 'status',
            ];

            $res = $this->client->post($this->base_url . '/Request?' . http_build_query($parms));
    
            $content = $res->getBody()->getContents();

            $response = json_decode($content, true);

            if (isset($response['code']) && $response['code'] == "Error") {
                throw new Exception(json_encode($response));
            }
            return $response['balance'];
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
            $res = $this->client->post($this->base_url . '/v2',  [
                'form_params' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'sender' => $this->sender_id,
                    'language' => 1,
                    'mobile' => $phone,
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
    private function sendOtp($phone, $code)
    {
        try {
            $res = $this->client->post($this->base_url . '/vSMS',  [
                'query' => [
                    'Username' => $this->username,
                    'password' => $this->password,
                    'SMSID' => $this->sms_id,
                    'Msignature' => $this->msignature,
                    'Token' => $this->token,
                    'Mobile' => $phone,
                    'Code' => $code
                ]
            ]);

            $content = $res->getBody()->getContents();
            $response = json_decode($content, true);

            Log::error("SMS Services Response - send otp " . json_encode($response));
        } catch (\Exception $e) {
            Log::error("SMS Services failed - send otp " . $e->getMessage());
        }

    }
}
