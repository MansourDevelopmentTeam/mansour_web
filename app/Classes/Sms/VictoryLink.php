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

class VictoryLink implements SmsGateway
{
    const SMSEG_GATEWAY = 'victory';
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
        $this->base_url = "https://smsvas.vlserv.com/KannelSending/service.asmx/";
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
        if ($this->gateway == "") {
            return true;
        }

        if(app()->environment('production')){
            $code = rand(1000, 9999);
        } else {
            $code = 1234;
        }

        $message = trans('message.verification_otp_message', ['store' => config('app.name'), 'code' => $code]);
        $this->sendSms($phone, $message);
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
            $res = $this->client->post($this->base_url . '/CheckCredit',  [
                'form_params' => [
                    'username' => $this->username,
                    'password' => $this->password
                ]
            ]);
    
            $response = simplexml_load_string((string)$res->getBody());
    
            return (int)$response;
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
            $res = $this->client->post($this->base_url . "/SendSMSWithDLR",  [
                'form_params' => [
                    'UserName' => $this->username,
                    'Password' => $this->password,
                    'SMSSender' => $this->sender_id,
                    "SMSLang" => "e",
                    'SMSReceiver' => $phone,
                    'SMSText' => $message
                ]
            ]);

            $response = simplexml_load_string((string)$res->getBody());

            if((int) $response != 0){
                throw new Exception(json_encode($response));
            }

        } catch (\Exception $e) {
            Log::error("SMS Services failed - check otp " . $e->getMessage());
        }

    }
}
