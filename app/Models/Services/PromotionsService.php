<?php

namespace App\Models\Services;

use App\Models\Products\Product;
use App\Models\Payment\Promotion;
use Illuminate\Support\Facades\Log;

class PromotionsService
{

    public function checkForDiscounts1($cart)
    {

        // get all active PromotionsService
        $activePromotions = Promotion::active()->orderBy("qty")->get();

        // dd($activePromotions, $cart);
        // group products by brand
        // Log::info($activePromotions->toArray());
        if ($activePromotions->count()) {
            $promotionApplied = false;
            foreach ($activePromotions as $promotion) {

                // check if promotion applicable on cart
                Log::info($this->promotionApplicable($promotion, $cart));
                if ($this->promotionApplicable($promotion, $cart)) {
                    // if yes apply

                    $regular_items = $cart->filter(function($item, $key) use ($promotion) {
                        Log::info("promotion name" . $promotion->name);
                        Log::info("item id" . $item->id);
                        return !$promotion->hasProduct($item->id);
                    });
                    Log::info($regular_items->toArray());
                    foreach ($regular_items as $item) {
                        $item->price = $item->amount * $item->price;

                        if (!is_null($item->discount_price)) {
                            $item->discount_price = $item->amount * $item->discount_price;
                        }
                    }

                    $promotion_items = $cart->filter(function($item, $key) use ($promotion) {
                        return $promotion->hasProduct($item->id);
                    });
                    Log::info("promotion_items" . json_encode($promotion_items->toArray()));

                    $item_count = $promotion_items->reduce(function ($carry, $item) {
                        return $carry + $item->amount;
                    });

                    $remove_discount = $item_count - ($item_count % $promotion->qty);

                    $promotion_items = $promotion_items->sortBy("price");

                    foreach ($promotion_items as $key => $item) {
                        if ($remove_discount > 0) {
                            if ($remove_discount >= $item->amount) {
                                $item->discount_price = null;
                                $item->price = $item->amount * $item->price;

                                $remove_discount = $remove_discount - $item->amount;
                            } else {

                                if ($item->active_discount) {
                                    $full_priced = $remove_discount;
                                    $full_price = $full_priced * $item->price;

                                    $discounted_amount = $item->amount - $remove_discount;
                                    $discount_price = $discounted_amount * $item->discount_price;

                                    $item->discount_price = $full_price + $discount_price;
                                }

                                $item->price = $item->amount * $item->price;

                                $remove_discount = 0;
                            }
                        } else {
                            $item->price = $item->amount * $item->price;
                            if (!is_null($item->discount_price)) {
                                $item->discount_price = $item->amount * $item->discount_price;
                            }
                        }
                    }

                    $count = floor(($item_count / $promotion->qty) * $promotion->discount_qty);

                    foreach ($promotion_items as $item) {
                        if ($count > 0) {
                            if ($count >= $item->amount) {

                                $discount = $item->price * ($promotion->discount / 100);

                                if (is_null($item->discount_price)) {
                                    $item->discount_price = $item->price - $discount;
                                } else {
                                    $item->discount_price = $item->discount_price - $discount;
                                }

                                $count = $count - $item->amount;
                            } else {

                                $discount = ($item->getOriginal("price") / 100) * $count * ($promotion->discount / 100);

                                if (is_null($item->discount_price)) {
                                    $item->discount_price = $item->price - $discount;
                                } else {
                                    $item->discount_price = $item->discount_price - $discount;
                                }

                                $count = 0;
                            }
                        }
                    }

                    // foreach ($promotion_items as $key => $item) {
                    //     if ($count > 0) {
                    //         if ($count >= $item->amount) {
                    //             // case 1 count >= item qty put discount on all items
                    //             $price = $item->amount * $item->price;
                    //             $discount = $price * ($promotion->discount / 100);

                    //             $item->discount_price = $price - $discount;
                    //             $item->price = $item->amount * $item->price;

                    //             $count = $count - $item->amount;
                    //         } else {
                    //             // case 2 count < item qty: put discount on count items
                    //             $full_priced = $item->amount - $count;
                    //             $full_price = $full_priced * $item->price;

                    //             $price = $count * $item->price;
                    //             $discount = $price * ($promotion->discount / 100);
                    //             $discounted_price = $price - $discount;

                    //             $item->discount_price = $full_price + $discounted_price;
                    //             $item->price = $item->amount * $item->price;

                    //             $count = 0;
                    //         }
                    //     } else {
                    //         $item->price = $item->amount * $item->price;
                    //         if (!is_null($item->discount_price)) {
                    //             $item->discount_price = $item->amount * $item->discount_price;
                    //         }
                    //     }
                    // }

                    $promotionApplied = true;
                    break;
                }
            }

            if (!$promotionApplied) {
                foreach ($cart as $item) {
                    $item->price = $item->amount * $item->price;
                    if ($item->active_discount) {
                        $item->discount_price = $item->amount * $item->discount_price;
                    } else {
                        $item->discount_price = null;
                    }
                }
            }
        } else {
            foreach ($cart as $item) {
                $item->price = $item->amount * $item->price;
                if ($item->active_discount) {
                    $item->discount_price = $item->amount * $item->discount_price;
                } else {
                    $item->discount_price = null;
                }
            }
        }

        return $cart;
    }

    public function filterApplicableBrandGroups($brandGroups, $activePromotions)
    {
        $filtered_groups = [];

        foreach ($brandGroups as $group) {
            // dd($group);
            $promotions = $activePromotions->filter(function($v, $k) use ($group) {
                return $v->brand_id == $group[0]->brand_id;
            });

            if ($promotions->count()) {
                $group->promotion = $promotions->first();

                $filtered_groups[] = $group;
            }
        }

        return $filtered_groups;
    }

    public function promotionApplicable($promotion, $cart)
    {
        $promotable_qty = 0;

        foreach ($cart as $item) {
            if ($promotion->hasProduct($item["id"])) {
                $promotable_qty += $item["amount"];
            }
        }

        return $promotable_qty >= $promotion->qty;
    }
}
