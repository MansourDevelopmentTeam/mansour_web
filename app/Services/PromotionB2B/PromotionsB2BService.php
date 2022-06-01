<?php

namespace App\Services\PromotionB2B;

use App\Models\Payment\Promotion\Promotion;
use App\Services\Promotion\PromotionHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PromotionsB2BService
{
    use PromotionHelper;

    private $cart;

    private $discount;

    private $conditionsChecker;

    private $appliedItems;

    private $targetItems;

    /**
     * Initialize properties
     */
    public function __construct()
    {
        $this->cart = collect([]);
        $this->appliedItems = collect([]);
        $this->targetItems = collect([]);

        $this->conditionsChecker = new ConditionsChecker();

    }

    /**
     * @return Collection
     */
    public function getCart(): Collection
    {
        return $this->cart;
    }

    public function getAppliedItems()
    {
        return $this->appliedItems;
    }

    public function getTargetItems()
    {
        return $this->targetItems;
    }

    /**
     * Check if certain promotion is applicable
     * @param $promotion
     * @param $cart
     * @return int
     */
    public function runAlgorithm($promotion, $cart): int
    {
        Log::info('promotion # ' . $promotion->id . ' start...');
        $this->cart = $cart;

        $discount = 0;

        if ($this->promotionApplicable($promotion)) {
            $this->cart         = $this->conditionsChecker->getCart();
            $this->cart         = $this->merge($this->conditionsChecker->getMatchedItems(), $this->cart);
            $this->targetItems  = $this->conditionsChecker->getTargetItems();
            $discount           = $this->conditionsChecker->getDiscount();

            Log::info('promotion # ' . $promotion->id . ' is applicable ');
        }

        Log::info('promotion # ' . $promotion->id . ' end.');
        Log::info("=======================================");

        Log::info('Applied :'. $this->appliedItems->pluck('id'));
        Log::info('cart :'. $this->cart->pluck('id'));

        return $discount;
    }

    /**
     * check conditions & targets of certain promotion
     * @param $promotion
     * @return bool
     */
    private function promotionApplicable($promotion): bool
    {
        return $this->conditionsChecker->setPromotion($promotion)->check($this->cart);
    }
}
