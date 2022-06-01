<?php

namespace App\Services\Promotion;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait PromotionHelper
{
    /**
     * split items in cart
     * @param $cart
     * @return Collection
     */
    private function spread($cart): Collection
    {
        $newCart = collect([]);

        $cart->each(function ($item) use (& $newCart) {
            try {
                $range = range(0.5, $item->amount, 0.5);
                foreach ($range as $value) {
                    $newCart->push(clone $item);
                }
            } catch (\Exception $exception) {
                Log::error('File : ' . __FILE__ . ' Exception : ' . $exception->getTraceAsString());
            }
        });

        return $newCart;
    }

    /**
     * Get total amount (price) of items based on isOverrideDiscount property
     * @param $collection
     * @return int|mixed
     */
    public function total($collection)
    {
        $amount = 0;

        $collection->each(function ($item) use (&$amount) {
//            if ($this->isOverrideDiscount()) {
                $amount += $item->price;
//            } else {
//                $amount += $item->discount_price ?? $item->price;
//            }
        });

        return $amount;
    }

    /**
     * Merge multiple collections
     * @param Collection ...$collections
     * @return Collection
     */
    public function merge(Collection ...$collections): Collection
    {
        $merged = collect([]);

        foreach ($collections as $collection) {
            $merged = $merged->merge($collection);
        }

        return $merged;
    }

    /**
     * Sort collection based on isOverrideDiscount Property.
     * if $isOverrideDiscount is enabled, sort by price and vise versa
     * @param $collection
     * @return Collection
     */
    private function sort($collection): Collection
    {
        if ($this->isOverrideDiscount()) {
            $sorted = $collection->sortByDesc('price');
        } else {
            $sorted = $collection->sortBy([
                function ($a, $b) {
                    $priceA = !is_null($a['discount_price']) ? $a['discount_price'] : $a['price'];
                    $priceB = !is_null($b['discount_price']) ? $b['discount_price'] : $b['price'];

                    return $priceA < $priceB;
                }
            ]);
        }

        return $sorted->values();
    }

    /**
     * The min number of products that achieve the amount
     * @param $list
     * @param $amount
     * @return int|string
     */
    private function getNumberOfItemsAchieveAmount($list, $amount)
    {
        /*
            hint: this equation used if all items has the same amount
            $count1 = ceil(($condition->amount / $itemsAmount) * $itemsQty);
        */

        // hint : this process in case each item has different price
        $count = 0;

        foreach ($list as $key => $item) {

            $totalAmount = $this->total($list->take($key + 1));

            if ($totalAmount >= $amount) {
                $count = $key + 1;
                break;
            }
        }

        return $count;
    }
}
