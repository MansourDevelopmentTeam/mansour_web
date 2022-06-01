<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\Validation\ValidationError;

class PhoneVerified implements RulesInterface
{
    /**
     * Rule name
     *
     * @var string
     */
    public $name = "phone_exists";

    /**
     * Sms Services
     *
     * @var \App\Services\SmsServices
     */
    protected $smsServices;

    /**
     * User
     *
     * @var \App\Models\Users\User
     */
    protected $user;

    /**
     * Constructor
     *
     * @param \App\Models\Users\User $user
     */
    public function __construct($user)
    {
        $this->smsServices = app()->make('App\Services\SmsServices');
        $this->user = $user;
    }

    /**
     * Validate request if phone is verified
     *
     * @throw \App\Models\Orders\Validation\ValidationError
     * @return void
     */
    public function validate()
    {
        $error = $this->smsServices->checkPhoneVerified($this->user);

        if ($error) {
            return new ValidationError($error, 409);
        }
    }
}
