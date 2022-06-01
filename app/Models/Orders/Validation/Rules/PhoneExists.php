<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\Validation\ValidationError;
use App\Models\Users\Address;

class PhoneExists implements RulesInterface
{
	public $name = "phone_exists";
	private $order_data;
	private $user;

	public function __construct($order_data, $user)
	{
		$this->order_data = $order_data;
		$this->user = $user;
	}

    public function validate()
    {
        if (auth()->check()) {
            if (!$this->user->phone) {
                return new ValidationError(trans('mobile.errorUpdateApp'), 422);
            }
        } else {
            $address = Address::whereNull('user_id')
                ->whereNotNull('phone')
                ->where('id', $this->order_data['address_id'])
                ->exists();
            if (!$address) {
                return new ValidationError(trans('mobile.errorUpdateApp'), 422);
            }
        }

    }
}
