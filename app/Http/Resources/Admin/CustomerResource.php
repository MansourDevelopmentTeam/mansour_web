<?php

namespace App\Http\Resources\Admin;


use App\Models\Services\LoyalityService;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        

        return [
            "id" => $this->id,
            "name" => $this->name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "phone" => $this->phone,
            "birthdate" => $this->birthdate,
            "token" => $this->token,
            "rate" => $this->rating,
            "addresses" => $this->addresses->load("area", "city", "district"),
            "total_points" => $this->getCurrentPoints(),
            "is_gold" => $this->isGold(),
            "spent" => $this->spent,
            "gold_amount" => config('constants.egp_gold'),
            "points_to_gold" => $this->pointsToGold(),
            "points_to_expire" => $this->pointsToExpire(),
            "referal" => $this->referal,
            "primary_address" => $this->primaryAddress ?? $this->addresses->first(),
            "next_expiration_date" => (string)LoyalityService::nextExpirationDate()->format('Y-m-d'),
            "ex_rate_pts" => config('constants.ex_rate_pts'),
            "ex_rate_egp" => config('constants.ex_rate_egp'),
            "ex_rate_gold" => config('constants.ex_rate_gold'),
            "refer_points" => config('constants.refer_points'),
            "pending_days" => config('constants.pending_days')
        ];
    }
}
