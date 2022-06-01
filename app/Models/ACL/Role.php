<?php

namespace App\Models\ACL;

use App\Models\Orders\OrderState;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
	protected $fillable = ["name", "active", "guard_name"];

	public function states()
	{
		return $this->belongsToMany(OrderState::class, "role_state", "role_id", "order_state_id");
	}
}