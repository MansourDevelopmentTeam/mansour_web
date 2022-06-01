<?php

namespace App\Models\Services;

use App\Models\Users\User;

class LoyalityService
{
	public function addUserPoints(User $user, $amount, $order)
	{
		$points = $this->calculatePoints($order, $user->isGold());

		if ($points) {
			return $user->points()->create([
				"total_points" => $points,
				"remaining_points" => $points,
				"amount_spent" => $amount,
				"expiration_date" => $this->nextExpirationDate(),
				"activation_date" => now()->addDays(config('constants.pending_days')),
				"order_id" => $order->id
	 		]);
		}
	}

	public function calculatePoints($order, $gold = false)
	{
		$points = 0;
        
		foreach($order->items as $item)
        {
            $category = $item->product->category;
			$categoryRatePts = $category->ex_rate_pts ?? null;
            $categoryRateEgp = $category->ex_rate_egp ?? null;
            if ($categoryRatePts && $categoryRateEgp) {
				$rate = floatval($categoryRatePts / $categoryRateEgp);
                $points += floatval(($item->product->price * $item->amount) * $rate);
            }
        }
		if ($gold) {
			$points += $points * (config('constants.ex_rate_gold') / 100);
		}
		return $points;
	}

	public function updateUserSpending(User $user, $amount)
	{
		$user->spent = $user->spent + $amount;
		$user->save();
	}

	public static function nextExpirationDate()
	{
        if (now() < now()->setDate(date("Y"), 6, 30)) {
            $next_expiry_date = now()->setDate(date("Y"), 12, 31);
        } else {
            $next_expiry_date = now()->setDate(date("Y"), 6, 30)->addYear();
        }

        return $next_expiry_date;
	}
}
