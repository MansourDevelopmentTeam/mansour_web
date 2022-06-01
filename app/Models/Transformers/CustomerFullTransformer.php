<?php

namespace App\Models\Transformers;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\Client\UsedPointsResource;
use App\Http\Resources\Client\EarnedPointsResource;
use App\Http\Resources\Client\ExpiredPointsResource;
use Facades\App\Models\Transformers\ProductTransformer;

/**
*
*/
class CustomerFullTransformer extends Transformer
{

	public function transform($user)
	{
        $cartItems = optional($user->cart()->with('cartItems.product')->first())->cartItems;

		$earned = $user->points;

        $used = $user->redeems;

        // group by expiration date and sum expired points
        $expired = $user->points()
            ->select("*", DB::raw("SUM(expired_points) as expirations"))
            ->groupBy(DB::raw("DATE(expiration_date)"))
            ->where("expiration_date", "<=", now())->get();
			
		return [
			"id" => $user->id,
			"name" => $user->name,
			"email" => $user->email,
			"phone" => $user->phone,
			"birthdate" => $user->birthdate,
            "cart_items" => optional($cartItems)->map(function ($item) {
                return ProductTransformer::transform($item->product) + ['cart_amount' => $item->amount];
            }),
            "orders" => $user->orders->load("products"),
			"active" => $user->active,
            "language" => $user->settings->language ?? null,
			"deactivation_notes" => $user->deactivation_notes,
			"addresses" => $user->addresses->load("area", "city"),
			"phone_verified" => $user->phone_verified,
			"closed_payment_methods" => $user->closedPaymentMethods,
            "is_affiliate" => $user->type == 4,
			"earned" => EarnedPointsResource::collection($earned),
            "used" => UsedPointsResource::collection($used),
            "expired" => ExpiredPointsResource::collection($expired)
		];
	}
}
