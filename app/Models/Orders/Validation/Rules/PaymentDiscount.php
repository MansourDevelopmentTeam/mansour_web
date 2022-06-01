<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Products\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\Validation\ValidationError;
use Facades\App\Models\Repositories\CartRepository;


/**
 * Payment discount Rule Class 
 * @package App\Models\Orders\Validation\Rules\PaymentDiscount
 */
class PaymentDiscount implements RulesInterface
{
    /** @var string $RuleName */
	public $name = "payment_discount";

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

            if(!$product->active_discount){
                continue;
            }
            $paymentMethods = DB::table('payment_method_product')->where('product_id', $item['id'])->pluck('payment_method_id')->toArray();

            
            if(!request()->get('accept_payment_discount_dialog', false) && $paymentMethods != null && !in_array(request()->get('payment_method'), $paymentMethods)){
                return new ValidationError(trans('mobile.payment_discount_not_applied'), 405);
            }
        }
    }
}
