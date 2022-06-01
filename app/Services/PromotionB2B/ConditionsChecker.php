<?php

namespace App\Services\PromotionB2B;

use App\Models\Payment\Promotion\Promotion;
use App\Models\Payment\Promotion\PromotionB2B_Segments;
use App\Services\Promotion\PromotionHelper;
use Illuminate\Support\Facades\Log;


class ConditionsChecker
{
    use PromotionHelper;

    private $promotion;
    private $cart;
    private $discount;
    private $matchedItems;
    private $targetItems;

    public function __construct()
    {
        $this->matchedItems = collect([]);
        $this->targetItems = collect([]);
        $this->discount = 0;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function getMatchedItems()
    {
        return $this->matchedItems;
    }

    public function getTargetItems()
    {
        return $this->targetItems;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    /**
     * @param Promotion $promotion
     * @return ConditionsChecker
     */
    public function setPromotion(Promotion $promotion): ConditionsChecker
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * check all conditions & targets on cart
     * @param $cart
     * @return bool
     */
    public function check($cart): bool
    {
        $this->cart = $cart;
        $this->matchedItems = collect([]);
//        $this->targetItems = collect([]);
        $this->discount = 0;

        Log::info("Cart items:" . $this->cart->pluck('id'));

        $this->filterMatchedItems();

        Log::info("matched items:" . $this->matchedItems->pluck('id'));
        Log::info("Total item count: " . $this->matchedItems->count() / 2 );

        // 3. check ranges
        $targetsCount = $this->checkRanges($this->matchedItems->count() / 2, $this->promotion->segments);

        // check override range
        if ($targetsCount > 0)
        $this->removeItems($targetsCount);

        return (bool)$this->discount;
    }

    public function checkRanges($matchingCount, $ranges)
    {
        $targetsCount = 0;

        foreach ($ranges as $range) {
            $count = 0;

            // n = 55;
            // min = 25, max = 50 => override => 50

            // min = 51, max = 60 => 55 - 51 + 1 => 5
            if ($matchingCount >= $range->min && is_null($range->max)) {
                $count = ($matchingCount - $range->min) + $range->iterator;

                if ($range->override_range){
                    $count = $matchingCount;
                    $targetsCount = 0;
                }

            } elseif ($matchingCount >= $range->min && $matchingCount <= $range->max) {
                $count = $targetsCount > 0 ? ($matchingCount - $targetsCount) : ($matchingCount - $range->min) + $range->iterator;

                if ($range->override_range){
                    $count        = $matchingCount;
                    $targetsCount = 0;
                }

            } elseif ($matchingCount > $range->max) {
                $count = ($range->max - $range->min) + $range->iterator;

                if ($range->override_range){
                    $count        = $range->max; // 50
                    $targetsCount = 0;
                }
            }

            $targetsCount += $count; // 50 + 55

            if ($count > 0) {
                $this->calculateDiscount($count, $range);
            }

            if (($matchingCount - $targetsCount) <= 0){
                break;
            }


            Log::info("count: " . $count);

        }
        Log::info("target: " . $targetsCount);

        return $targetsCount * 2;
    }

    /**
     * Get all items in condition-lists
     * @return void
     */
    private function filterMatchedItems()
    {
        $conditionsListIDs = $this->promotion->conditions->pluck('item_id')->toArray();

        $this->cart = $this->cart->filter(function ($item) use ($conditionsListIDs) {
            $itemLists = collect([]);
            $itemLists->push($item->lists->pluck('id')->toArray());
            $itemLists->push(!$item->parent ?: $item->parent->lists->pluck('id')->toArray());
            $itemListsArray = $itemLists->filter()->flatten()->unique()->toArray();

            $intersect = array_intersect($conditionsListIDs, $itemListsArray);

            if (count($intersect)) {
                $this->matchedItems->push($item);
                return false;
            } else {
                return true;
            }
        });
    }

    private function removeItems(int $count)
    {
        $targets = $this->matchedItems->take($count);

        foreach ($targets as $target) {
            $this->targetItems->push($target);
        }

        $this->matchedItems = $this->matchedItems->skip($count);
    }

    private function calculateDiscount(float $itemCount, $range)
    {
        if ($range->discount_type == PromotionB2B_Segments::DISCOUNT_TYPES['Fixed'] && $itemCount > 0.5) {
            $this->discount += $range->discount;

            if ($range->override_range) {
                $this->discount = $range->discount;
            }

        } else { // discount per item
            Log::info("No of items  :" . $itemCount);

            $count = $this->getIteratorItems($range->iterator, $itemCount);

            Log::info("No of items in range  :" . $count);

            if ($count > 0)
                $this->discount += $range->discount * ($count);

            if ($range->override_range) {
                $this->discount = $range->discount * ($count);
            }
        }

        Log::info("Range discount  :" . $range->discount . ' and Type: ' . $range->discount_type);
        Log::info("Total Discount  :" . $this->discount);
    }

    private function getIteratorItems($iterator, $itemCount)
    {
        return ($itemCount - fmod($itemCount, $iterator)) / $iterator;
    }
}
