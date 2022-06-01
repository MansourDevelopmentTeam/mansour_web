<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\OrderState;
use App\Models\Orders\Validation\ValidationError;

class MustDeliveredHisOrders implements RulesInterface
{
    private $order_data;
    private $user;
    private $lang;

    public function __construct($order_data, $user, $lang = 1)
    {
        $this->order_data = $order_data;
        $this->user = $user;
        $this->lang = $lang;
    }

    public function validate()
    {
        if (auth()->check()) {
            $hasUnCompletedOrders = $this->user->orders()
                ->whereNotIn("state_id", [OrderState::DELIVERED, OrderState::RETURNED, OrderState::CANCELLED])
                ->exists();

            if ($hasUnCompletedOrders) {
                return new ValidationError(trans('mobile.errorUserHasUnCompletedOrders'), 423);
            }
        }
    }
}
