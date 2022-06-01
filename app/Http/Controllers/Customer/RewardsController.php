<?php

namespace App\Http\Controllers\Customer;

use App\Facade\Sms;
use Illuminate\Http\Request;
use App\Models\Payment\Promo;
use App\Models\Loyality\Reward;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Resources\RewardsResource;

class RewardsController extends Controller
{
    
    public function getRewards()
    {
        return $this->jsonResponse("Success", RewardsResource::collection(Reward::where("active", 1)->get()));
    }

    /**
     * Redeem reward
     *
     * @param Request $request
     * @return void
     */
    public function redeemReward(Request $request)
    {
        $this->validate($request, [
            "reward_id" => "required|exists:rewards,id"
        ]);

        // get reward
        $reward = Reward::findOrFail($request->reward_id);
        if (!$reward->active) {
            return $this->errorResponse(trans("mobile.errorRewardInactive"), "invalid date", [], 422);
        }

        // get user total points
        $user = auth()->user();
        // validate
        if (!$user->isGold() && $reward->is_gold) {
            return $this->errorResponse(trans("mobile.errorNeedGold"), "invalid date", [], 410);
        }

        if ($user->getCurrentPoints() < $reward->point_cost) {
            return $this->errorResponse(trans("mobile.errorNotEnoughPoints"), "invalid date", [], 411);
        }

        if (!$user->phone) {
            return $this->errorResponse(trans("mobile.errorUpdateApp"), "invalid date", [], 422);
        }

        if (!$user->phone_verified) {
            $code = Sms::send($request->phone);
            $user->verification_code = $code;
            $user->phone_verified = 0;
            $user->save();

            return $this->errorResponse(trans("mobile.errorUpdateApp"), "invalid date", [], 409);
        }

        // redeem and subtract
        DB::beginTransaction();

        try {
            $points = $user->points()
                        ->where("remaining_points", ">", 0)
                        ->where('expiration_date', ">=", now())
                        ->where("activation_date", "<=", now())
                        ->orderBy("created_at", "DESC")
                        ->get();

            // check if promo
            if ($reward->type == Reward::TYPE_PROMO) {
                // generate promo
                $promo = Promo::create([
                    "name" => "GIFT-" . strtoupper(str_random(5)),
                    "type" => $reward->amount_type,
                    "target_type" => Promo::TARGET_TYPE_SELECTED_CUSTOMER,
                    "amount" => $reward->amount,
                    "max_amount" => $reward->max_amount * 100,
                    "active" => 1,
                    "recurrence" => 1,
                    "expiration_date" => now()->addMonth()
                ]);

                $promo->targets()->attach(auth()->id());
            }
            $redeem = $user->redeems()->create([
                "reward_id" => $reward->id,
                "points_used" => $reward->point_cost,
                "status" => 0,
                "promo_id" => ($reward->type == Reward::TYPE_PROMO ? $promo->id : null)
            ]);

            $point_cost = $reward->point_cost;

            foreach ($points as $point) {
                if ($point_cost == 0) {
                    continue;
                }
                if ($point->remaining_points >= $point_cost) {
                    $point->remaining_points = $point->remaining_points - $point_cost;
                    $point->used_points = $point->used_points + $point_cost;
                    $point->save();
                    $point->redeems()->attach($redeem->id, ["amount" => $point_cost]);
                    $point_cost = 0;
                    continue;
                } else {
                    $point_cost -= $point->remaining_points;
                    $point->redeems()->attach($redeem->id, ["amount" => $point->remaining_points]);
                    $point->used_points = $point->total_points;
                    $point->remaining_points = 0;
                    $point->save();
                }
            }


            DB::commit();

            if ($reward->type == Reward::TYPE_PROMO) {
                $promo->total_points = $user->getCurrentPoints();
                return $this->jsonResponse("Success", $promo, 201);
            } else {
                $reward->total_points = $user->getCurrentPoints();
                return $this->jsonResponse("Success", $reward, 202);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse("Unexpected Error: " . $e->getMessage(), "invalid data", [], 422);
        }
    }
}
