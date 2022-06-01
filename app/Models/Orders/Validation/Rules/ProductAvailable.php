<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\Validation\ValidationError;
use App\Models\Products\Product;
use Facades\App\Models\Repositories\CartRepository;


/**
 * Product Available Rule Class 
 * @package App\Models\Orders\Validation\Rules\ProductAvailable
 */
class ProductAvailable implements RulesInterface
{
    /** @var string $RuleName */
	public $name = "product_available";

	public function __construct($lang = 1)
	{
        $this->lang = $lang;
	}
    /**
     * Validate order
     *
     * @return void
     * @throws ValidationError
     */
    public function validate()
    {
        try {
            $items = CartRepository::getUserCartItems();
        } catch (\Exception $e) {
    		return new ValidationError(trans('mobile.errorItemsNotExists'), 422);
        }
        foreach ($items as $item) {
            $product = Product::findOrFail($item["id"]);

            // Should the product is active and parent is active and product not available soon
            if($product->active && $product->parent->active){
                continue;
            }

            return new ValidationError(trans("mobile.errorProductNotAvailable"), 423);
        }
    }
}
