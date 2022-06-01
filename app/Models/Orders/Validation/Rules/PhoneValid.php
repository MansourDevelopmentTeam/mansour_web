<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Localization\Country;
use App\Models\Orders\Validation\ValidationError;
use App\Models\Users\Address;
use Illuminate\Support\Facades\Lang;

class PhoneValid implements RulesInterface
{
    public $name = "schedule_date";
    private $order_data;
    private $user;

    public function __construct($order_data, $user)
    {
        $this->order_data = $order_data;
        $this->user = $user;
    }

    public function validate()
    {
        $localization = Country::where('country_code', config('app.country_code'))->first();
        if (!$localization) {
            $localization = Country::where('fallback', true)->first();
        }
        $pattern = $localization->phone_pattern;
        $phoneLength = $localization->phone_length;
        $phone = null;
        if (auth()->check()) {
            if ($this->user->phone) {
                $phone = $this->user->phone;
            }
        } else {
            $address = Address::whereNull('user_id')
                ->whereNotNull('phone')
                ->where('id', $this->order_data['address_id'])
                ->exists();
            if (!$address) {
                $phone = $address->phone;
            }
        }
        $patternValidation = (bool)preg_match("/{$pattern}/", $phone);
        if (!$patternValidation) {
            return new ValidationError(trans('mobile.phone_invalid'), 423);
        }
        if ($phoneLength !== strlen($phone)) {
            return new ValidationError(trans('mobile.invalid_phone_length', ['length' => $phoneLength]), 423);
        }
    }
}
