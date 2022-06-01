<?php 

namespace App\Models\Users;

use App\Models\ACL\Role;
use App\Models\Orders\Order;
use App\Models\Users\User;

/**
* 
*/
class AssignPolicy
{
	
	public static function canAssign(User $user, Order $order): bool
	{
		// check if user is delivery
		if($user->type != 3) {
			return false;
		}

		// check if user is available
		if(!$user->delivererProfile->isAvailable()) {
			return false;
		}

		// check if deliverer service area is same as order address area
		if($user->delivererProfile->area_id != $order->address->area_id) {
			return false;
		}

		return true;
	}
}