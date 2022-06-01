<?php 

namespace App\Models\Transformers;

/**
* 
*/
class DelivererTransformer extends Transformer
{
	
	function transform($user)
	{
		return [
			"id" => $user->id,
			"name" => $user->name,
			"email" => $user->email,
			"phone" => $user->phone,
			"token" => $user->token,
			"image" => $user->delivererProfile->image,
			"status" => $user->delivererProfile->status
		];
	}
}