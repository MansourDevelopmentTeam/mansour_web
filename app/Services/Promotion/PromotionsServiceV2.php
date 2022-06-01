<?php

namespace App\Services\Promotion;

use App\Models\Payment\Promo;
use App\Models\Payment\Promotion\PromotionConditions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Payment\Promotion\Promotion;
use App\Services\PromotionB2B\PromotionsB2BService;

class PromotionsServiceV2
{
    use PromotionHelper;

    private $cart;

    /**
     * Collection of items that matched the conditions
     * @var Collection
     */
    private $appliedItems;

    /**
     * Collection of items that matched the targets (items get discount)
     * @var Collection
     */
    private $targetItems;

    private $conditionsChecker;

    private $gifts;

    /**
     * Items that we recommend to user to complete the promotion targets
     * @var Collection
     */
    private $suggestions;

    /**
     * Which promotion is applied
     * @var array
     */
    private $isApplied = array();

    /**
     * Matched Items that has suggestions
     * @var
     */
    private $matchedWithSuggestion;

    /**
     * Applied promotions and its respective discount value
     * @var Collection
     */
    private $promotionDiscounts;

    /**
     * Initialize properties
     */
    public function __construct()
    {
        $this->appliedItems = collect([]);
        $this->targetItems = collect([]);
        $this->cart = collect([]);
        $this->gifts = collect([]);
        $this->suggestions = collect([]);
        $this->promotionDiscounts = collect([]);
    }

    public function getCart(): Collection
    {
        return $this->cart;
    }

    /**
     * Check for promotion discounts on cart
     * @param $cart
     * @return array
     */
    public function checkForDiscounts($cart): array
    {
        $this->appliedItems = collect([]);
        $this->targetItems = collect([]);
        $this->cart = collect([]);
        $this->gifts = collect([]);
        $this->suggestions = collect([]);
        $this->promotionDiscounts = collect([]);

        // 1. format cart
        $this->cart = $this->spread($cart);
        
        Log::info("items in cart before processing: " . $this->cart->pluck('id'));

        // 2. get promotions
        $listOfPromotions = Promotion::prioritize();
        
        // 3. apply promotions on cart
        $promotedCart = $this->applyPromotions($listOfPromotions);

        // 4. response
        return array(
            'items' => $promotedCart,
//            'suggestions' => count($this->suggestions) > 0 ? [$this->suggestions[0]] : [],
            'suggestions' => $this->suggestions,
            'promotionDiscounts' => $this->promotionDiscounts,
            'gifts' => $this->formatGifts($this->gifts),
            'isApplied' => in_array(true, $this->isApplied)
        );
    }

    private function applyPromotions($listOfPromotions)
    {
        Log::info(count($listOfPromotions) > 0 ?: 'No promotions found!');

        $service = '';
        $serviceB2B = new PromotionsB2BService();

        $promotionGroups = $this->getGroupsList();

        foreach ($listOfPromotions as $promotion) {

            // Check promotion uses..
            if ($promotion->isPeriodic()){
                continue;
            }

            switch ($promotion->category) {
                case Promotion::B2C_CATEGORY:
                    $service = $this;
                    break;
                case Promotion::B2B_CATEGORY:
                    $service = $serviceB2B;
                    break;
            }

            $discount   = $service->runAlgorithm($promotion, $this->cart, $promotionGroups);
            
            $this->cart = $service->getCart();
            $serviceB2B = get_class($service) == "App\Services\PromotionB2B\PromotionsB2BService" ? $service : $serviceB2B;

            if ($discount) {
                $this->promotionDiscounts[] = [
                    'promotionId' => $promotion->id,
                    'promotion' => $promotion,
                    'discount' => $discount,
                ];
            }
        }

        // finally, check suggestion
        $this->validateSuggestions();
        // recollect cart and apply discounts

        $newCart = $this->merge(
            $this->cart,
            $this->appliedItems->flatten(),
            $this->targetItems->flatten(),
//            $serviceB2B->getAppliedItems()->flatten(),
            $serviceB2B->getTargetItems()->flatten(),
        );

        return $this->applyDiscount($newCart);
    }

    private function exclusiveTimes($conditions)
    {
        $items = collect([]);
        $times = [];

        if (count($conditions) >= 1) {

            foreach ($conditions->sortByDesc('operator') as $key => $condition) {

                // check if condition is product
                if ($condition->isProduct()) {

                    $customList = $condition->customLists->pluck('item_id')->toArray();

                    $items = $this->cart->filter(function ($item) use ($customList) {
                        if (in_array($item->id, $customList, true)) {
                            return true;
                        }
                        return false;
                    });
                }

                // check if condition is list
                if ($condition->isList()) {

                    // 1. get condition list
                    $list = $condition->item_id;

                    // 2. get all items in this list
                    $items = $this->cart->filter(function ($item) use ($list) {

                        $itemLists = collect([]);
                        $itemLists->push($item->lists->pluck('id')->toArray());
                        $itemLists->push(!$item->parent ?: $item->parent->lists->pluck('id')->toArray());

                        if (in_array($list, $itemLists->filter()->flatten()->unique()->toArray(), true)) {
                            return $item;
                        }
                    });
                }

                $res = $this->checkCondition($condition, $items);

                if (!is_bool($res))
                    $times[] = $res;
            }

            if (count($times) > 0) {
                return min($times);
            }
        }

        return 0;
    }

    private function checkCondition($condition, $items)
    {
        $itemsQty    = count($items);
        $itemsAmount = $this->total($items);

        // calculate qty & amount
        if (!is_null($condition->quantity) && $itemsQty < $condition->quantity * 2) {
            return false;
        }

        if (!is_null($condition->amount) && $itemsAmount < $condition->amount) {
            return false;
        }

        return floor(($itemsQty / 2) / $condition->quantity);
    }

    private function runAlgorithm($promotion, $cart, &$promotionGroups)
    {
        Log::info("cart: " . $this->cart->pluck('id'));

        Log::info('promotion # ' . $promotion->id . ' start... and type is '. array_search($promotion->type, Promotion::TYPES));

        $promotion->isApplied = false;
        $promotionDiscount = 0;


        // three rules (conditions) if true, we can loop over promotion
        // 1. #no of times
        // 2. cart still have items.
        // 3. promotion meet conditions and targets (applicable)

        // set times of exclusive promotion as it has the same count of its conditions.
        if ($promotion->isExclusive()) {
            if (!is_null($promotion->times) && $this->exclusiveTimes($promotion->conditions)) {
                $promotion->times = min($promotion->times, $this->exclusiveTimes($promotion->conditions));
            }
        }

        while (
            (is_null($promotion->times) || ($promotion->times--))
            && (count($cart) > 0)
            && $this->promotionApplicable($promotion)) {

            // Update cart when applying promotion multiple times
            // separate items that achieve the conditions and targets.
            // we save items that achieve promotion to complete process on remaining ones.
            // check promotion groups..
            if (isset($promotion->group_id)){
                Log::info('Group ID: '. $promotion->group_id);

                if ($promotionGroups[$promotion->group_id]){
                    continue; // if true, continue with other promotions from another groups
                }

                // if false, set group as marked
                $promotionGroups[$promotion->group_id] = true;
            }

            $this->updateInputs($promotion->isExclusive());

            $promotionDiscount += $this->discountOnTargets($this->conditionsChecker->getTargetItems());

            if ($promotion->boost) {
                $promotionDiscount += $promotion->boost;
            }

            $promotion->isApplied = true;

            Log::info('promotion # ' . $promotion->id . ' is applicable ');
        }

        // record which promotions are applicable to detect the last result
        $this->isApplied[] = $promotion->isApplied;

        // record suggestion status
        $this->updateSuggestions($promotion->isApplied);

        Log::info('promotion # ' . $promotion->id . ' end.');
        Log::info("=======================================");

        return $promotionDiscount;
    }

    private function formatGifts($gifts)
    {
        if (!$gifts->filter()->isEmpty()) {
            return $gifts->groupBy('promotion_id')->map(function ($group) {
                return [
                    'promotion_id' => $group->first()[0]['promotion_id'],
                    'name' => $group->first()[0]['name'],
                    'count' => $group->count()
                ];
            })->values();
        }

        return null;
    }

    /**
     * check conditions & targets of certain promotion
     * @param $promotion
     * @return bool
     */
    private function promotionApplicable($promotion): bool
    {
        $this->conditionsChecker = new ConditionsChecker($promotion);

        return $this->conditionsChecker->check($this->cart);
    }

    /**
     * Apply promotion discount on target items
     * @param $collection
     * @return mixed
     */
    private function applyDiscount($collection)
    {
        $collection->groupBy('id')->each(function ($group) {
            $price        = $group->pluck('price')->sum() / 2;
            $extra_amount = $group->pluck('id')->count() / 2;

            $discount = $group->sum(function ($item) {
                return is_null($item->discount_price) ? $item->price / 2 : $item->discount_price;
            });

            $group->map(function ($item) use ($price, $discount, $extra_amount) {
                $item->price = $price;
                $item->extra_amount   = $extra_amount > $item->amount ? ($extra_amount - $item->amount) : 0;
                $item->discount_price = ($price == $discount) ? null : $discount;
            });
        });

        return $collection->unique('id')->values();
    }

    private function updateInputs($isExclusive)
    {
        $this->targetItems[]  = $this->conditionsChecker->getTargetItems();
        $this->cart           = $this->conditionsChecker->getCart();

        // Exclusive not reserve items for cart, it's working in parallel with others
        if ($isExclusive) {
            $this->cart   = $this->merge($this->cart, $this->conditionsChecker->getMatchedItems());
            return;
        }

        $this->gifts[]        = $this->conditionsChecker->getGifts();
        $this->appliedItems[] = $this->conditionsChecker->getMatchedItems();

    }

    public function discountOnTargets($targetItems)
    {
        return $targetItems->reduce(function ($carry, $item) {
            if (!is_null($item->discount_price)) {
                $discount = $item->price / 2 - $item->discount_price;
                $carry += $discount;
            }
            return $carry;
        });
    }

    private function updateSuggestions($isApplied): void
    {
        if (isset($this->conditionsChecker)
            && !is_null($this->conditionsChecker->getSuggestions())
            && count($this->conditionsChecker->getSuggestions()) > 0
            //&& !$isApplied // if applicable once, don't suggest targets
        ) {

            $suggestion = $this->conditionsChecker->getSuggestions()->first();

            if (isset($suggestion)) {

                $this->suggestions[$suggestion['promotion_id']] = $suggestion;

                //if there is suggestion, record it's matched items
                $this->matchedWithSuggestion[$suggestion['promotion_id']] = $this->conditionsChecker->getMatchedItems();

                $this->conditionsChecker->resetSuggestions();
            }
        }
    }

    /**
     * Revalidate suggestion
     * filter suggestion that has items in cart
     * @return void
     */
    private function validateSuggestions(): void
    {
        $found_all = false;

        // 1. if cart is not empty ,  count($this->cart) > 0 &&
        // 2. and already we have suggestion, check suggestion
        if (count($this->suggestions) > 0) {
            foreach ($this->matchedWithSuggestion as $promotionId => $items) {

                foreach ($items as $product) {

                    // Exclusive not reserve items for cart, it's working in parallel with others
                    if (Promotion::find($promotionId)->isExclusive()){
                        $found_all = true;
                        break;
                    }

                    $found_all = in_array($product->id, $this->cart->pluck('id')->toArray());

                    if (!$found_all) { // must found all to match conditions
                        break;
                    }
                }

                // if all matched items not present in cart |OR| promotion discount is not 100% (free), so forget promotion
                // || $this->suggestions->get($promotionId)['promotion_discount'] < 100
                if (!$found_all) {
                    $this->suggestions->forget($promotionId);
                }
            }
        } else { //else empty suggestions
            $this->suggestions = collect([]);
        }

        $this->suggestions = $this->suggestions->values();
    }

    private function getGroupsList(): array
    {
        $groupList = \DB::table('promotion_groups')->pluck('id');

        $mapped = [];

        foreach ($groupList as $group){
            $mapped[$group] = false;
        }

        return $mapped;
    }

}
