<?php

namespace App\Models\Payment;

use App\Models\Payment\Promo;
use App\Models\Users\User;
use Carbon\Carbon;

/**
* Promo validation class
*/
class PromoValidator
{

    public static function validate(Promo $promo, $user, $amount, $cart)
    {
        // check if promo not expired
        if (!$promo->active) {
            throw new \Exception(trans("mobile.errorPromoDeactivated"));
        }

        // check if promo not expired
        if (Carbon::parse($promo->expiration_date) <= now()) {
            throw new \Exception(trans("mobile.errorPromoExpired"));
        }

        /**
         * check if promo has payment methods with not same payment method create order
         * Should add eager loading payment methods relation
         * Should add eager loading for count payment methods related to promo
         */
        if ($promo->paymentMethods && $promo->paymentMethods->isEmpty() && $promo->payment_methods_count > 0) {
            throw new \Exception(trans('mobile.promo_not_valid_for_payment'));
        }

        if($user){
            if ($promo->targets->count() || $promo->phone_targets->count()) {
                if (!$promo->targets()->where("users.id", $user->id)->exists() && !$promo->phone_targets()->where("users.id", $user->id)->exists()) {
                    throw new \Exception(trans("mobile.errorPromoNotExist"));
                }
            }
    
            // check if user used this promo
            if ($promo->recurrence == 1 && $user->userPromos()->where("name", $promo->name)->exists()) {
                throw new \Exception(trans("mobile.errorPromoAlreadyUsed"));
            } elseif ($promo->recurrence == 2 && $user->userPromos()->where("name", $promo->name)->wherePivot("use_date", ">", Carbon::today())->exists()) {
                throw new \Exception(trans("mobile.errorPromoAlreadyUsed"));
            }
    
            if ($promo->first_order && $user->first_order) {
                throw new \Exception(trans("mobile.errorPromoFirstOrderOnly"));
            }
        }

        if (isset($promo->minimum_amount) && $promo->minimum_amount > $amount) {
            if ($promo->list_id) {
                throw new \Exception(trans("mobile.errorPromoMinimumAmountWithList"));
            } else {
                throw new \Exception(trans("mobile.errorPromoMinimumAmount"));
            }
        }

        $product_ids = $cart->pluck('parent_id')->toArray();
        // array_map(function ($item)
        // {
        //     return $item["id"];
        // }, $cart);

        if ($promo->list_id) {
            $product_exists = $promo->list->products()->whereIn("products.id", $product_ids)->exists();
            if (!$product_exists) {
                throw new \Exception(trans("mobile.errorPromoCartItem"));
            }
        }

        return true;
    }
}
