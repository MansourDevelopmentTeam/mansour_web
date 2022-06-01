<?php

namespace App\Models\Transformers;


use App\Models\Services\LoyalityService;

/**
*
*/
class CustomerTransformer extends Transformer
{

	function transform($user)
	{
		return [
			"id" => $user->id,
			"name" => $user->name,
			"last_name" => $user->last_name,
			"email" => $user->email,
			"image" => $user->image,
			"phone" => $user->phone,
			"phone_verified" => $user->phone_verified,
			"birthdate" => $user->birthdate != "0000-00-00" ? $user->birthdate : null,
			"token" => $user->token,
			"rate" => $user->rating,
			"addresses" => $user->addresses->load("area", "city", "district"),
			"total_points" => $user->getCurrentPoints(),
			"is_gold" => $user->isGold(),
			"spent" => $user->spent,
			"gold_amount" => floatval(config('constants.egp_gold')),
			"points_to_gold" => $user->pointsToGold(),
			"points_to_expire" => $user->pointsToExpire(),
			"referal" => $user->referal,
			"primary_address" => $user->primaryAddress ? $user->primaryAddress->load("area", "city", "district") : $user->addresses()->with("area", "city", "district")->first(),
			"next_expiration_date" => (string)LoyalityService::nextExpirationDate()->format('Y-m-d'),
			"ex_rate_pts" => floatval(config('constants.ex_rate_pts')),
            "ex_rate_egp" => floatval(config('constants.ex_rate_egp')),
            "ex_rate_gold" => floatval(config('constants.ex_rate_gold')),
            "refer_points" => floatval(config('constants.refer_points')),
			"pending_days" => floatval(config('constants.pending_days')),
			"user_settings" => $user->settings,
            "is_affiliate" => $user->type == 4,
            'wallet_credit' => $user->wallet->sum('amount')
		];
	}
}
