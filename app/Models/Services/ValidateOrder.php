<?php

namespace App\Models\Services;

use Carbon\Carbon;

use App\Models\Users\User;
use App\Models\Orders\Order;
use App\Models\Payment\Promo;
use App\Models\Users\Address;
use App\Models\Products\Product;
use App\Models\Orders\OrderState;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\OrderProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Facades\App\Models\Repositories\CartRepository;
use App\Services\Promotion\PromotionsServiceV2;



class ValidateOrder
{
    private $aramexService;
    public function __construct(AramexService $aramexService, PromotionsServiceV2 $promotionsService)
    {
        $this->promotionsService = $promotionsService;
        $this->aramexService = $aramexService;
    }

    public function validateOrder($orderData,$user)
    {
        $errors = [];
        $total = 0;
        $weight = 0;
        $numberOfPiece = 0;

        $validator = Validator::make($orderData, [
            "payment_method" => "required|integer|in:1,2,3,4,5",
            "items" => "sometimes|array|filled",
            "address_id" => "required|exists:addresses,id",
            "scheduled_at" => "sometimes|nullable|date",
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $cartItems = CartRepository::getUserCartItems();
        $address = Address::where('id', $orderData['address_id'])->where('user_id', $user->id)->first();
        if ($address) {
            if (!optional($address->area)->active ) {
                $errors[] = 'this area is not active place';
            }
            if (!optional($address->city)->active ) {
                $errors[] = 'this city is not active place';
            }
        } else {
            $errors[] = "address not found ";
        }
        // $aramexValidateAddress = $this->aramexService->validateAddress($address);
        // if (!$aramexValidateAddress) {
        //     $errors[] = "Invalid City data";
        // }

        if (isset($orderData['scheduled_at']) && $orderData['scheduled_at'] && strtotime($orderData['scheduled_at']) < time()) {
            $errors[] = "You can't schedule an order with a past date!";
        }
        if (!$user->phone) {
            $errors[] = Lang::get('mobile.errorUpdateApp');
        }
        // if (!$user->phone_verified) {
        //     if (isset($orderData['verification_code'])  && isset($orderData['verification_code'])  != $user->verification_code) {
        //         $errors[] = Lang::get('mobile.errorIncorrectVerification');
        //     } elseif (isset($orderData['verification_code'])  && isset($orderData['verification_code']) == $user->verification_code) {
        //         $user->update(["phone_verified" => 1, "verification_code" => null]);
        //     } else {
        //         if (!$user->verification_code) {
        //             if (app()->environment() === 'production') {
        //                 $user->verification_code = rand(1000, 9999);
        //                 $user->save();
        //             }else{
        //                 $user->verification_code = 1234;
        //                 $user->save();
        //             }
        //         }
        //TODO: Refactor this with sms service
        //         event(new PhoneVerificationEvent($user));

        //         $errors[] = Lang::get('mobile.errorUpdateApp');
        //     }
        // }

        foreach ($cartItems as $item) {
            $product = Product::find($item["id"]);
            if ($product) {
                $weight += $product->weight * $item['amount'];
                $numberOfPiece += $item['amount'];
                $order_item = OrderProduct::with("order", "product")->select("*", DB::raw("SUM(amount) as sale_count"))->whereHas("order", function ($q) use ($user) {
                    $q->whereNotIn("state_id", [OrderState::CANCELLED, OrderState::INCOMPLETED])->where("user_id", $user->id);
                })->where("product_id", $item["id"])->where("created_at", ">", now()->subDays($product->min_days))->groupby("product_id")->first();
                $total_qty = $item["amount"] + ($order_item ? $order_item->sale_count : 0);
                // validate if quantity + count user orders in last n days less than product max

                if ($total_qty > $product->max_per_order && $product->max_per_order != null) {
                    $errors[] = Lang::get("mobile.errorMaxProduct", ["product" => $product->getName(request()->header('lang')), "quantity" => $product->max_per_order]);
                }
                if ($product->stock < $item["amount"]) {
                    $errors[] = "there is no enough Stocks";
                }
                if ($product->discount_price > 0) {
                    $productTotal = $product->discount_price * $item["amount"] * 100;
                } else {
                    $productTotal = $product->price * $item["amount"] * 100;
                }
                $total += $productTotal;

            } else {
                $errors[] = 'product With Id ' . $item["id"] . ' Not Found ';
            }
        }
        if ($weight <= 0 || $numberOfPiece <= 0) {
            $errors[] = 'weight or Number of Pieces cannot be  zero';
        }

        //$products = collect([]);
        //$items = $cartItems;
        //foreach ($items as $key => $item) {
        //    $product = Product::find($item["id"]);
        //    $product->amount = $item["amount"];
        //    $products->push($product);
        //}
        //$items = $this->promotionsService->checkForDiscounts($products);


        if (isset($orderData['promo']) && $orderData['promo']) {
            $promo = Promo::where("name", $orderData['promo'])->first();
            $referer = User::where('referal', $orderData['promo'])->first();
            if (!$promo && !$referer) {
                $errors[] = "Promo code does not exist";
            }

            if ($promo && (string)Carbon::parse($promo->expiration_date)->addDay() < now()) {
                $errors[] = "Promo code expired";
            }

            if ($promo && !in_array(request('payment_method'), (array) $promo->paymentMethods->pluck('id')->toArray())) {
                $errors[] = "Promo doesnt support your payment methods";
            }

            if ($referer && \Auth::user()->first_order) {
                $errors[] = "Promo code does not exist";
            }
            if ($referer && $total < config('constants.refer_minimum')) {
                $errors[] = "Refer doesn't meet minimum order amount";
            }
            if ($promo && !$promo->active ) {
                $errors[] = trans("mobile.errorPromoDeactivated");
            }

            if ($promo && $promo->targets->count() && !$promo->targets()->where("user_id", $user->id)->exists()) {
                $errors[] = trans("mobile.errorPromoNotExist");
            }

            if ($promo && $promo->recurrence == 1 && $user->userPromos()->where("name", $promo->name)->exists()) {
                $errors[] = trans("mobile.errorPromoAlreadyUsed");
            } elseif ($promo && $promo->recurrence == 2 && $user->userPromos()->where("name", $promo->name)->wherePivot("use_date", ">", Carbon::today())->exists()) {
                $errors[] = trans("mobile.errorPromoAlreadyUsedToday");
            }
            if ($promo &&  $cartItems  && $promo->list_id) {
                $product_ids = array_map(function ($item)
                {
                    return $item["id"];
                }, $cartItems );

                $product_exists = $promo->list->products()->whereIn("products.id", $product_ids)->exists();
                if (!$product_exists) {
                    $errors[] = trans("mobile.errorPromoCartItem");
                }
            } elseif ($promo &&  !$cartItems && $promo->brand_id) {
                $errors[] = trans("mobile.errorPromoUpdate");
            }
        }
        if (!empty($errors)) {
            return $errors;
        }
        return true;
    }
}
