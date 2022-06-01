<?php 

namespace App\Models\Orders;

use App\Models\Orders\Order;
use App\Models\Orders\OrderState;

/**
* 
*/
class OrderAssignmentPolicy
{
	
	public static function canAssign(Order $order)
	{
		// check if order is not cancelled or returned or delivered
		if(in_array($order->state_id, [OrderState::CANCELLED, OrderState::RETURNED, OrderState::DELIVERED])) {
			return false;
		}

		return true;
	}
}