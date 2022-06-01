<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\Validation\ValidationError;
use App\Models\Users\Address;
use Illuminate\Support\Facades\Lang;

class AddressValid implements RulesInterface
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
        if (auth()->check()) {
            $address = Address::where('id', $this->order_data['address_id'])->where('user_id', $this->user->id)->first();
        } else {
            $address = Address::where('user_id', null)->where('id', $this->order_data['address_id'])->first();
        }
        if ($address) {
            if (!optional($address->area)->active) {
                return new ValidationError(trans('mobile.areaNotActive'), 423);
            }
        } else {
            return new ValidationError("Address not found", 423);
        }
    }
}
