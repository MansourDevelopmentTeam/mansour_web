<?php

namespace App\Rules\Admin;

use App\Models\Products\Product;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Repositories\CartRepository;

class StockAvailable implements Rule
{
    public $message;
    public $items;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $repo = app()->make('App\Models\Repositories\CartRepository');
        $this->items = $repo->getUserCartItems();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->items as $item) {
            $product = Product::findOrFail($item["id"]);
            if ($product) {
                if ($product->stock == 0) {
                    $this->message = "Product {$product->name} is out of stock";
                    return false;
                }
                if ($product->stock < $item["amount"] || ($item["amount"] > $product->max_per_order && isset($product->max_per_order))) {
                    $this->message = "Product {$product->name} is only {$product->stock} available";
                    return false;
                }
            } else {
                $this->message = "Product Not Found";
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
