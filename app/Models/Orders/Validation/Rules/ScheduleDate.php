<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\Validation\ValidationError;

class ScheduleDate implements RulesInterface
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
    	if (isset($this->order_data['scheduled_at']) && $this->order_data['scheduled_at'] && strtotime($this->order_data['scheduled_at']) < time()) {
    		return new ValidationError("You can't schedule an order with a past date!", 423);
    	}
    }
}
