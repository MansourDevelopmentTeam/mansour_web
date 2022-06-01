<?php
namespace App\Contracts;

interface SmsGateway
{
    /**
     * send verification
     *
     * @param  User $user
     * @return void
     */
    public function send($user);

    /**
     * Verify customer phone number
     *
     * @param [type] $phone
     * @param [type] $address_id
     * @param [type] $otp
     * @return void
     */
    public function verify($phone, $otp);

    /**
     * Get balance
     *
     * @return void
     */
    public function getBalance();

    /**
     * Send with sms services
     *
     * @param  string $phone
     * @param  string $message
     * @return  void
     */
    public function sendSms($phone, $message);

}