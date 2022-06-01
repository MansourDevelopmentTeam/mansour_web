<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\Validation\ValidationError;
use App\Models\Payment\Promo;
use App\Models\Products\Product;
use Facades\App\Models\Repositories\CartRepository;

use App\Models\Users\User;
use Carbon\Carbon;

class PromoValid implements RulesInterface
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
        $total = 0;
        $items = CartRepository::getUserCartItems();
        foreach ($items as $item) {
            $product = Product::findOrFail($item["id"]);
            if (!is_null($product->discount_price)) {
                $productTotal = $product->discount_price * $item["amount"];
            } else {
                $productTotal = $product->price * $item["amount"];
            }
            $total += $productTotal;
        }

    	if (isset($this->order_data['promo']) && $this->order_data['promo']) {
            $promo = Promo::where("name", $this->order_data['promo'])->first();
            $referer = User::where('referal', $this->order_data['promo'])->first();

            if (!$promo && !$referer) {
                return new ValidationError("Promo code does not exist", 423);
            }

            if ($promo && (string)Carbon::parse($promo->expiration_date)->addDay() < now()) {
                return new ValidationError("Promo code expired", 423);
            }

            if ($promo && !in_array(request('payment_method'), (array) $promo->paymentMethods->pluck('id')->toArray())) {
                return new ValidationError("Promo doesnt support your payment methods", 423);
            }

            if ($referer && $this->user->first_order) {
                return new ValidationError("Promo code does not exist", 423);
            }

            if ($referer && $total < config('constants.refer_minimum')) {
                return new ValidationError("Refer doesn't meet minimum order amount", 423);
            }

            if ($promo && !$promo->active ) {
                return new ValidationError(trans("mobile.errorPromoDeactivated"), 423);
            }

            if ($promo && $promo->targets->count() && !$promo->targets()->where("id", $this->user->id)->exists()) {
                return new ValidationError(trans("mobile.errorPromoNotExist"), 423);
            }

            if ($promo && $promo->recurrence == 1 && $this->user->userPromos()->where("name", $promo->name)->exists()) {
                return new ValidationError(trans("mobile.errorPromoAlreadyUsed"), 423);
            } elseif ($promo && $promo->recurrence == 2 && $this->user->userPromos()->where("name", $promo->name)->wherePivot("use_date", ">", Carbon::today())->exists()) {
                return new ValidationError(trans("mobile.errorPromoAlreadyUsedToday"), 423);
            }

            if ($promo &&  $this->order_data['items']  && $promo->brand_id) {
                $product_ids = array_map(function ($item)
                {
                    return $item["id"];
                }, $this->order_data['items'] );

                $product_exists = $promo->brand->products()->whereIn("products.id", $product_ids)->exists();
                if (!$product_exists) {
                    return new ValidationError(trans("mobile.errorPromoCartItem"), 423);
                }
            } elseif ($promo &&  !$this->order_data['items'] && $promo->brand_id) {
                return new ValidationError(trans("mobile.errorPromoUpdate"), 423);
            }
        }
    }
}
