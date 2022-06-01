<?php

namespace App\Models\Payment;

/**
*
*/
class PromoCalculator
{
	
	public static function calculate(Promo $promo, $amount)
	{
		$discount = 0;
        
        // calculate promo
        if ($promo->type == Promo::AMOUNT) {
            if ($amount > $promo->amount) {
                $discount = $promo->amount;
            } else {
                $discount = $amount;
            }
        } elseif ($promo->type == Promo::PERCENT) {
            $discount = $amount * ($promo->amount / 100);

            if ($promo->max_amount) {
                if ($discount > $promo->max_amount) {
                    $discount = $promo->max_amount;
                }
            }
        }

        return $discount;
	}
}
