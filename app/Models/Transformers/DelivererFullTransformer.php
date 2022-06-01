<?php 

namespace App\Models\Transformers;

/**
* 
*/
class DelivererFullTransformer extends Transformer
{
	
	function transform($user)
	{
		return [
			"id" => $user->id,
			"name" => $user->name,
			"email" => $user->email,
			"phone" => $user->phone,
			"delivererProfile" => $this->getProfile($user->delivererProfile),
			"rating" => $user->rating,
			"numberOfRates" => $user->getNumberOfRates(),
			"active" => $user->active,
			"role_id" => $user->roles->first()->id ?? null,
			"numberOfOrders" => $user->deliveries->count(),
			"deactivation_notes" => $user->deactivation_notes,
			"birthdate" => $user->birthdate,
			"address" => $user->addresses()->first() ? $user->addresses()->first()->address : null,
			"orders" => $user->deliveries,
			"created_at" => (string)$user->created_at
		];
	}

	public function getProfile($profile)
	{
		return [
			"image" => $profile->image,
			"status" => $profile->status,
			"city" => $profile->city,
			"area" => $profile->area,
			"districts" => $profile->districts,
			"unique_id" => $profile->unique_id
		];
	}
}