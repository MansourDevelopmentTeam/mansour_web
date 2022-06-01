<?php 

namespace App\Models\Repositories;

use App\Models\ACL\Role;
use App\Models\Users\DelivererProfile;
use App\Models\Users\User;

/**
* 
*/
class DelivererRepository
{
	
	public function getAllDeliverers()
	{
		return User::with("delivererProfile")->where("active", 1)->where("type", 3)->get();
	}

	public function getAllDeliverersPaginated($data)
	{
		$users = User::where("type", 3);

		if (isset($data["q"])) {
			$users->where("name", "LIKE", "%{$data['q']}%");
		}

		$users->orderBy("created_at", "DESC");

		return $users->paginate(20);
	}

	public function getDelivererById($id)
	{
		return User::where("type", 3)->where("id", $id)->firstOrFail();
	}

	public function getAvailableDeliverersByArea($area_id)
	{
		return User::with("delivererProfile")->where("active", 1)->where("type", 3)->whereHas("delivererProfile", function ($q) use ($area_id)
		{
			$q->where("status", DelivererProfile::AVAILABLE)->where("area_id", $area_id);
		})->get();
	}
}