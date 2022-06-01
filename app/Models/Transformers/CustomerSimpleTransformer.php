<?php
namespace App\Models\Transformers;

use Facades\App\Models\Transformers\ProductTransformer;

class CustomerSimpleTransformer extends Transformer
{
	function transform($user)
	{
		$address = $user->addresses->first();
		$area = "";

		if($address) {
			$area = $address->area->name ?? "";
		}
        $cartItems = optional($user->cart()->with('cartItems.product')->first())->cartItems;
		return [
			"id" => $user->id,
			"name" => $user->name,
			"last_name" => $user->last_name,
			"phone" => $user->phone,
			"email" => $user->email,
            "cart_items" => optional($cartItems)->map(function ($item) {
                return ProductTransformer::transform($item->product) + ['cart_amount' => $item->amount];
            }),
			"address" => $area,
			"addresses" => $user->addresses,
			"language" => $user->settings->language ?? null,
			"orders" => $user->orders->count(),
			"active" => $user->active,
			"closed_payment_methods" => $user->closedPaymentMethods,
			"code" => $user->code
		];
	}
}
