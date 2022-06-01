<?php

namespace App\Services\Promotion;

use App\Models\Payment\Promo;
use App\Models\Payment\Promotion\Promotion;
use App\Models\Payment\Promotion\PromotionConditions;
use App\Models\Payment\Promotion\PromotionTargets;
use App\Models\Products\Lists;
use App\Models\Products\Product;
use App\Models\Repositories\CartRepository;
use App\Models\Transformers\ProductTransformer;
use Illuminate\Support\Facades\Log;

class ConditionsChecker
{
    use PromotionHelper;

    private $promotion;
    private $matchedItems;
    private $targetItems;
    private $cart;
    private $gifts;
    private $suggestions;
    private $targets;
    private $extraTargets;
    /**
     * @var array
     */
    private $times;

    public function __construct(Promotion $promotion)
    {
        $this->promotion = $promotion;
        $this->targetItems = collect([]);
        $this->matchedItems = collect([]);
        $this->suggestions = collect([]);
        $this->times       = [];
        $this->extraTargets = [];
    }

    /**
     * Getters
     */
    public function getMatchedItems()
    {
        return $this->matchedItems;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function getTargetItems()
    {
        return $this->targetItems;
    }

    /**
     * @param \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection $matchedItems
     */
    public function setMatchedItems($matchedItems): void
    {
        $this->matchedItems = $matchedItems;
    }

    public function getGifts()
    {
        return $this->gifts;
    }

    public function getSuggestions()
    {
        return $this->suggestions;
    }

    public function resetSuggestions(): void
    {
        $this->suggestions = null;
    }

    /**
     * check all conditions & targets on cart
     * @param $cart
     * @return bool
     */
    public function check($cart): bool
    {
        $this->cart = $cart;
//        $this->targetItems = collect([]);
//        $this->matchedItems = collect([]);

        switch ($this->promotion->type) {
            case Promotion::TYPES['both']:
            case Promotion::TYPES['discount']:
                return $this->checkDiscounts();

            case Promotion::TYPES['gift']:
                return $this->checkGifts();

            case Promotion::TYPES['direct_discount']:
                return $this->checkDirectDiscounts();
        }
    }

    private function checkDiscounts(): bool
    {
        if ($this->checkForConditions()) {

            // if there are no targets present in cart, suggest items
            if (!$this->checkForTargets()) {
                $this->suggestTargets();

                return false;
            }

            // if any of those rules is true, break the process
//            if (
//                !$this->checkProductsCase()
//                || !$this->itemsMustBeInDifferentBrands()
//                || !$this->itemsMustBeInDifferentCategories()) {
//
//                return false;
//            }

            // if promotion is both discount & gift
//            if ($this->promotion->type === Promotion::TYPES['both']) {
//                $this->addGifts();
//            }

            // if all conditions & targets for one promotions are passed, then apply targets
            $this->applyTargets();

            return true;
        }

        return false;
    }

    private function checkGifts(): bool
    {
        if ($this->checkForConditions()
            && $this->checkProductsCase()
            && $this->itemsMustBeInDifferentBrands()
            && $this->itemsMustBeInDifferentCategories()) {

            $this->addGifts();

            return true;

        }

        return false;
    }

    private function checkDirectDiscounts(): bool
    {
        if ($this->checkForTargets()) {

            $this->applyTargets();

            return true;
        }

        return false;
    }

    /**
     * List of Rules
     */
    private function itemsMustBeInDifferentBrands(): bool
    {
        if ($this->promotion->getAttribute('different_brands')) {

            $items = $this->merge($this->matchedItems->flatten(), $this->targetItems->flatten());

            Log::info('brands: ' . $items->pluck('brand_id')->unique());
            return $items->pluck('brand_id')->unique()->count() > 1;
        }

        // means property is disabled
        return true;
    }

    private function itemsMustBeInDifferentCategories(): bool
    {
        if ($this->promotion->getAttribute('different_categories')) {

            $items = $this->merge($this->matchedItems->flatten(), $this->targetItems->flatten());
            Log::info('cats: ' . $items->pluck('category_id')->unique());

            return $items->pluck('category_id')->unique()->count() > 1;
        }

        return true;
    }

    private function checkProductsCase(): bool
    {
        $diff = $this->promotion->getAttribute('different_products');

        $items = $this->merge($this->matchedItems->flatten(), $this->targetItems->flatten());

        // 1 => different, 0 => same, null => any
        if ($diff == 1) { // different

            Log::info('products: ' . $items->pluck('id')->unique());

            return $items->pluck('id')->unique()->count() > 1;

        } elseif (!is_null($diff) && $diff == 0) { // same

            return $items->pluck('id')->unique()->count() == 1;

        } else { //any
            return true;
        }
    }

    private function checkForConditions(): bool
    {
        $conditions = $this->promotion->conditions;

        $this->cart = $this->sort($this->cart);

        $and = true;
        $or  = false;

        $items = collect([]);

        if (count($conditions) >= 1) {

            foreach ($conditions->sortByDesc('operator') as $key => $condition) {

                // check if condition is product
                if ($condition->isProduct()) {

                    Log::info('condition #' . $condition->id . ': is product, and product ID: ' . $condition->customLists->pluck('item_id'));

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

                    Log::info('condition #' . $condition->id . ': is list, with list ID: ' . $condition->item_id);

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

                $check = $this->checkCondition($condition, $items);

                if ($condition->operator == PromotionConditions::OPERATOR['AND'] && !$check) {       // OPERATOR => AND && NOT DONE
                    $and = false;
                    break;
                } elseif ($condition->operator == PromotionConditions::OPERATOR['OR']  && $check) { // Operator => OR && DONE
                    $or = true;
                    break;
                }
            }

            if (!$conditions->where('operator', 0)->count()){
                if ($and) {
                    $or = true;
                }
            }

            return ($and && $or);
        }

        // there is no conditions
        return false;
    }

    private function checkForTargets(): bool
    {
        $targets = $this->promotion->targets;

        if (is_null($targets) || count($targets->toArray()) == 0 || empty($targets)) {
            return true;
        }

        $items = collect([]);
        $and = true;
        $or  = false;

        if (count($targets) >= 1) {

            foreach ($targets->sortByDesc('operator') as $target) {

                Log::info('target #' . $target->id . ': is product, and product ID: ' . $target->item_id);

                $items = $this->cart->filter(function ($item) use ($target) {
                    return $item->id == $target->item_id;
                });

                $check = $this->checkTarget($target, $items);

                if ($target->operator == PromotionTargets::OPERATOR['AND'] && !$check) {       // OPERATOR => AND && NOT DONE
                    $and = false;
                    break;
                } elseif ($target->operator == PromotionTargets::OPERATOR['OR']  && $check) { // Operator => OR && DONE
                    $or = true;
                    break;
                }
            }

            if (!$targets->where('operator', 0)->count()){
                if ($and) {
                    $or = true;
                }
            }

            return ($and && $or);
        }

        // there is no conditions
        return false;
    }

    // note: for targets (many targets), Target will be either one list or multiple items not both together.
    private function checkForTargets_1(): bool
    {
        // get all targets
        $targets = $this->promotion->targets;

        $items = collect([]);

        // there are no targets, may be promotion is just a gift and no need for targets
        if (is_null($targets) && $this->promotion->type === Promotion::TYPES['gift']) {
            return true;
        }

        $discountQty = $this->promotion->discount_qty * 2;

        // if list get list ID (only one)
        $targetsItemIDs = $targets->pluck('item_id');

        // check their type (must be only product or list)
        $targetsType = $targets->pluck('item_type')->unique()->first();

        if ($targetsType === PromotionTargets::ITEM_TYPES['products']) {

            Log::info('targets #' . $targets->pluck('id') . ': type is product, and product IDs: ' . $targets->first()->customLists->pluck('item_id'));

            // get those items from cart sorting by price asc
            $customList = $targets->first()->customLists->pluck('item_id')->toArray();

            $items = $this->cart->filter(function ($item) use ($customList) {
                if (in_array($item->id, $customList, true)) {
                    return true;
                }
                return false;
            })->values();

        }

        if ($targetsType === PromotionTargets::ITEM_TYPES['lists']) {

            Log::info('targets #' . $targets->pluck('id') . ': type is list, and list ID: ' . $targetsItemIDs . ' with discount qty:' . $discountQty);

            $targetList = $targetsItemIDs->first();

            $items = $this->cart->sortBy('price')->filter(function ($item) use ($targetList) {
                $itemLists = collect([]);
                $itemLists->push($item->lists->pluck('id')->toArray());
                $itemLists->push(!$item->parent ?: $item->parent->lists->pluck('id')->toArray());

                $diff = $this->promotion->getAttribute('different_products');

                // in case "same product": take similar matched products in targets
                if ($diff == 0 && !is_null($diff)){
                    if (in_array($item->id, $this->matchedItems->pluck('id')->toArray())) {
                        return $item;
                    }
                }
                elseif (in_array($targetList, $itemLists->filter()->flatten()->unique()->toArray())) {
                    return $item;
                }

            })->values();
        }

        // check if number of items achieve the qty targets || if null means take all items.
        if ($items->count() > 0 && (is_null($discountQty) || $items->count() >= $discountQty)) {

            $discountQty = $discountQty ?? $items->count();

            $this->filterTargetItems($items, $discountQty);

            Log::info('targets # ' . $targets->pluck('id') . ' is matched!, and remaining items in cart is: ' . $this->cart->pluck('id'));

            return true;
        }

        Log::warning('targets #' . $targets->pluck('id') . ' is not matched!, and process is break! ' . $this->cart->pluck('id'));

        return false;

    }

    /**
     * Check condition on some items
     * @param $condition
     * @param $items
     * @return bool
     */
    private function checkCondition($condition, $items): bool
    {
        $itemsQty = count($items); //24
        $itemsAmount = $this->total($items);

        // calculate qty & amount
        if (!is_null($condition->quantity) && $itemsQty < $condition->quantity * 2) {
            Log::warning('condition #' . $condition->id . ' is not matched in quantity!, and process is break! ' . $this->cart->pluck('id'));

            return false;
        }
        if (!is_null($condition->amount) && $itemsAmount < $condition->amount) {
            Log::warning('condition #' . $condition->id . ' is not matched in amount!, and process is break! ' . $this->cart->pluck('id'));

            return false;
        }

        $this->filterMatchedItems($items, $condition->amount, $condition->quantity * 2);

        Log::info('condition #' . $condition->id . ' is matched!, and remaining items in cart is: ' . $this->cart->pluck('id'));

        return true;
    }

    private function checkTarget($target, $items): bool
    {
//        $total   = count($items) / 2
        $itemQty = count($items) / 2;

        if ( $itemQty < $target->quantity) {
            Log::warning('target #' . $target->id . ' is not matched in quantity!, and process is break! ' . $this->cart->pluck('id'));

            return false;
        }

        $this->filterTargetItems($items, $target->quantity * 2);

        Log::info('target #' . $target->id . ' is matched!, and remaining items in cart is: ' . $this->cart->pluck('id'));

        return true;
    }

    /**
     * Apply targets and gifts
     */
    private function applyTargets()
    {
        $this->targetItems = $this->sort($this->targetItems);

        $discount = $this->promotion->discount / 100;

        // apply discount to target items
        $this->targetItems->map(function ($item) use ($discount) {
//            if ($this->isOverrideDiscount()) {
                $item->discount_price = ($item->price / 2) - (($item->price / 2) * $discount);
//            }
//            else {
//                $item->discount_price = !is_null($item->discount_price) ?
//                    ($item->discount_price - ($item->discount_price * $discount)) :
//                    ($item->price / 2 - ($item->price / 2 * $discount));
//            }
        });

        // and if promotion_overrode_discount is enabled, set discount to 0
        if ($this->isOverrideDiscount()) {
            $this->matchedItems->map(function ($item) {
                $item->discount_price = null;
            });
        }
    }

    private function suggestTargets()
    {
        // get all targets
        $targets = $this->promotion->targets;

        // check their type (must be only product or list)
        $targetsIds = $targets->pluck('item_id')->toArray();

        $products = Product::whereIn('id', $targetsIds)->get();

        $this->suggestions[$this->promotion->id] = [
            'promotion_id'       => $this->promotion->id,
            'promotion_discount' => $this->promotion->discount,
            'promotion_name'     => $this->promotion->getName(request()->header('lang')),
            'promotion_targets'  => $this->promotion->targets,
            'products'           => (new ProductTransformer(request(), new CartRepository()))->transformCollection($products),
        ];

    }

    private function addGifts()
    {
        $this->gifts[] = [
            'promotion_id' => $this->promotion->id,
            'name' => $this->promotion->getGift(request()->header('lang')),
        ];
    }

    /**
     * Helpers
     */
    private function isOverrideDiscount(): bool
    {
        if ($this->promotion->override_discount) {
            return true;
        }

        return false;
    }

    private function isCheckAllConditions(): bool
    {
        if ($this->promotion->check_all_conditions) {
            return true;
        }

        return false;
    }

    /**
     * filter matched items from cart depend on amount
     * @param $list
     * @param int|null $amount
     * @param int|null $quantity
     */
    private function filterMatchedItems($list, ?int $amount, ?int $quantity)
    {
        $numOfItems = 0;

        if (!is_null($amount)) {
            $numOfItems = $this->getNumberOfItemsAchieveAmount($list, $amount);
        }

        if (is_null($quantity)) {
            $quantity = 0;
        }

        $count = max($numOfItems, $quantity);

        $this->cart = $this->cart->filter(function ($product) use ($list, &$count) {
            if (in_array($product->id, $list->pluck('id')->toArray(), true) && $count-- >= 1) {
                $this->matchedItems->push($product);
                return false;
            } else {
                return true;
            }
        });
    }

    /**
     * Filter target items from cart
     * @param $list
     * @param int $discountQty
     */
    private function filterTargetItems($list, int $discountQty)
    {
        $this->cart = $this->cart->sortBy('price')->filter(function ($product) use ($list, &$discountQty) {
            if (in_array($product->id, $list->pluck('id')->toArray(), true) && $discountQty-- >= 1) {
                $this->targetItems->push($product);
                return false;
            } else {
                return true;
            }
        });
    }

}
