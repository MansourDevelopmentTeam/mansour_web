<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\Validation\ValidationError;
use App\Models\Products\Product;
use Facades\App\Models\Repositories\CartRepository;

class StockAvailable implements RulesInterface
{
	public $name = "schedule_date";
	private $order_data;
	private $user;

	public function __construct($order_data, $user)
	{
		$this->order_data = $order_data;
		$this->user = $user;
	}

    public function validate()
    {
        try {
            $items = CartRepository::getUserCartItems();
        } catch (\Exception $e) {
    		return new ValidationError(trans('mobile.errorItemsNotExists'), 422);
        }
        foreach ($items as $item) {
            $product = Product::findOrFail($item["id"]);
            if ($product) {
                if ($product->stock < $item["amount"] || ($item["amount"] > $product->max_per_order && isset($product->max_per_order))) {
                    return new ValidationError("Product {$product->name} is out of stock", 423);
                }
            } else {
                return new ValidationError("Product Not Found", 423);
            }
        }
    }
}
