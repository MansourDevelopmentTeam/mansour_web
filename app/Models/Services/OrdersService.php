<?php

namespace App\Models\Services;


use App\Models\Orders\Validation\Rules\MustDeliveredHisOrders;
use App\Models\Orders\Validation\Rules\PhoneValid;

use App\Models\Configuration;

use App\Models\Payment\Promotion\PromotionUser;
use Carbon\Carbon;
use App\Mail\OrderCreated;
use App\Models\Users\User;

use App\Models\Orders\Cart;
use Illuminate\Support\Arr;
use Jenssegers\Agent\Agent;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Payment\Promo;
use App\Models\Users\Address;
use App\Models\Products\Product;
use App\Models\Orders\OrderState;
use App\Models\Payment\UserPromo;
use App\Exceptions\OrderException;
use App\Notifications\OrderPlaced;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\OrderManager;
use App\Models\Orders\OrderProduct;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ProductException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment\PaymentMethod;
use App\Models\Payment\PaymentMethods;
use App\Models\Payment\PromoValidator;
use App\Models\Services\AramexService;
use App\Models\Payment\PromoCalculator;
use App\Models\Services\LocationService;
use App\Models\Shipping\ShippingMethods;
use App\Classes\Shipping\ShippingFactory;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\AramexLocationException;
use Illuminate\Support\Facades\Notification;
use App\Models\Users\Affiliates\WalletHistory;
use App\Models\Users\Affiliates\AffiliateLinks;
use App\Models\Orders\Validation\OrderValidator;
use App\Models\Orders\Validation\Rules\PromoValid;
use App\Models\Orders\Validation\Rules\ItemsExists;
use App\Models\Orders\Validation\Rules\MaxPerOrder;
use App\Models\Orders\Validation\Rules\PaymentType;
use App\Models\Orders\Validation\Rules\PhoneExists;
use Facades\App\Models\Repositories\CartRepository;
use App\Models\Orders\Validation\Rules\AddressValid;
use App\Models\Orders\Validation\Rules\ScheduleDate;
use App\Models\Orders\Validation\Rules\PhoneVerified;
use App\Models\Orders\Validation\Rules\RequiredFields;
use App\Models\Orders\Validation\Rules\StockAvailable;
use App\Models\Orders\Validation\Rules\ExceptCodAmount;
use App\Models\Orders\Validation\Rules\PaymentDiscount;
use App\Models\Orders\Validation\Rules\ProductAvailable;
use App\Services\Promotion\PromotionsServiceV2;

class OrdersService
{
    private $locationService;
    private $promotionsService;
    private $aramexService;
    private $shippingFactory;
    private $mansourService;

    public function __construct(AramexService $aramexService, LocationService $locationService, PushService $pushService, PromotionsServiceV2 $promotionsService, ShippingFactory $shippingFactory, MansourService $mansourService)
    {
        $this->locationService = $locationService;
        $this->promotionsService = $promotionsService;
        $this->pushService = $pushService;
        $this->aramexService = $aramexService;
        $this->shippingFactory = $shippingFactory;
        $this->mansourService = $mansourService;
    }

    public function validateOrder($order_data, $user, $lang = 1)
    {
        $validator = new OrderValidator();
        $validator->addRules([
//            new AddressValid($order_data, $user),
            new ScheduleDate($order_data, $user),
            new PhoneExists($order_data, $user),
            new PhoneVerified($user),
            new PhoneValid($order_data, $user),
            new MaxPerOrder($order_data, $user, $lang),
            new MustDeliveredHisOrders($order_data, $user, $lang),
            new RequiredFields($order_data),
            new ItemsExists(),
            new ProductAvailable(),
            new PaymentDiscount(),
            new PaymentType(),
            new StockAvailable($order_data, $user),
            // new PromoValid($order_data, $user),
            // new ExceptCodAmount($order_data, $user)
        ]);

        return $validator;
    }

    public function getTotalAmount($orderData, $separateResults = false)
    {
        $user = \Auth::user();

        $total = 0;
        $weight = 0;
        $numberOfPiece = 0;
        $products = collect([]);

        $items = CartRepository::getUserCartItems();
        foreach ($items as $item) {
            $product = Product::find($item["id"]);
            $product->amount = $item["amount"];
            $products->push($product);
        }
        $items = $this->promotionsService->checkForDiscounts($products);
        $itemsPrice = [];
        $freeDelivery = false;

        Log::info("Cart items getTotalAmount ", ["items" => $items['items']]);
        foreach ($items['items'] as $item) {
            $product = Product::find($item["id"]);
            $freeDelivery = $freeDelivery || $product->free_delivery;
            // $order_item = OrderProduct::with("order", "product")->select("*", DB::raw("SUM(amount) as sale_count"))->whereHas("order", function ($q) use ($user) {
            //     $q->whereNotIn("state_id", [OrderState::CANCELLED, OrderState::INCOMPLETED])->where("user_id", $user->id);
            // })->where("product_id", $item["id"])->where("created_at", ">", now()->subDays($product->min_days))->groupby("product_id")->first();
            // $total_qty = $item["amount"] + ($order_item ? $order_item->sale_count : 0);
            // validate if quantity + count user orders in last n days less than product max
            // if ($product->preorder) {
            //     $productTotal = $product->price * $item["amount"];
            // } else if ($product->active_discount) {
            //     $productTotal = $product->discount_price * $item["amount"];
            // } else {
            //     $productTotal = $product->price * $item["amount"];
            // }

            if ($product->active_discount) {
                $itemsPrice[$product->id] = $product->discount_price;
            } else {
                $itemsPrice[$product->id] = $product->price;
            }
            $weight += $product->weight * $item['amount'];
            $numberOfPiece += $item['amount'];
            $total += !is_null($item->discount_price) ? $item->discount_price : $item->price;
        }

//        $delivery_fees = $this->getDeliveryFeesAmount($orderData['address_id'], $total, $weight, $numberOfPiece, $freeDelivery);
        $delivery_fees = 0;

        if (isset($orderData['promo']) && $orderData['promo'] != null) {
            $promo = Promo::with(['paymentMethods' => function ($query) use ($orderData) {
                $query->where('payment_method_id', $orderData['payment_method']);
            }])
            ->withCount('paymentMethods')
            ->where("name", $orderData['promo'])
            ->first();

            if ($promo) {
                $amount = $total;
                PromoValidator::validate($promo, auth()->user(), $total, $items['items']);
                if ($promo->list_id) {
                    $amount = 0;
                    foreach ($items['items'] as $item) {
                        if ($promo->list->products()->where("products.id", $item["id"])->orWhere("products.id", $item["parent_id"])->exists()) {
                            $product = Product::find($item["id"]);
                            $price = $product->active_discount ? $product->discount_price : $product->price;
                            $amount += $price;
                        }
                    }
                }
                if ($promo->type == Promo::FREE_DELIVERY) {
                    $delivery_fees = 0;
                } else {
                    $discount = PromoCalculator::calculate($promo, $amount);
                    $total = $total - $discount;
                }
            }
        }
        $grand_total = $total + $delivery_fees;

        if ($separateResults) {
            return [
                'total' => ($total * 100),
                'delivery_fees' => $delivery_fees,
                'items_price' => $itemsPrice,
                'grand_total' => ($grand_total * 100)
            ];
        }

        return ($grand_total * 100);
    }
    /**
     * Create a new order.
     *
     * @param array $orderData
     * @param int $transaction_id
     * @param [type] $userData
     * @param [type] $admin_id
     * @return void|object
     */
    public function createOrder($orderData, $transaction_id = null, $userData, $admin_id = null, $useWallet = false)
    {
        $request = request();
        $promoDiscount = [];
        $promoProducts = collect([]);
        DB::beginTransaction();

        $weight = 0;
        $numberOfPiece = 0;
        $affiliate_id = null;
        if (config('constants.enable_affiliate')) {
            if ($userData) {
                if ($userData->type == 4) {
                    $affiliate_id = $userData->id;
                } elseif ($userData->link()->whereDate('expiration_date', '>=', now())->first()) {
                    $affiliate_id = $userData->link->affiliate_id;
                }
            } else {
                if (isset($orderData['referral']) && !empty($orderData['referral'])) {
                    $link = AffiliateLinks::where('referral', $orderData['referral'])->whereDate('expiration_date', '>=', now())->first();
                    if ($link)
                        $affiliate_id = $link->affiliate_id;
                }
            }
        }
//        if ($userData) {
//            $address = Address::withTrashed()->where('user_id', $userData->id)->findOrFail($orderData['address_id']);
//        } else {
//            $address = Address::withTrashed()->whereNull('user_id')->findOrFail($orderData['address_id']);
//        }

        // create order
        try {
            $orderArrayData = [
                "user_id" => $userData->id ?? null,
                "admin_id" => $admin_id,
                "state_id" => OrderState::CREATED,
                "transaction_id" => $transaction_id,
                "payment_method" => isset($orderData['payment_method']) ? $orderData['payment_method'] : null,
                "payment_installment_id" => $orderData['plan_id'] ?? null,
//                "address_id" => $orderData['address_id'],
                "address_id" => null,
                "notes" => isset($orderData['notes']) ? $orderData['notes'] : null,
                "scheduled_at" => isset($orderData['schedule_date']) ? $orderData['schedule_date'] : null,
                "user_agent" => $orderData['device_type'] ?? null,
                "user_ip" => getRealIp() ?? isset($orderData['user_ip']) ? $orderData['user_ip'] : null,
                "promotion_discount" => $orderData['promotion_discount'] ?? null,
            ];

            if (config('constants.enable_affiliate')) {
                $orderArrayData['affiliate_id'] = $affiliate_id;
            }
            $orderArrayData += ["phone" => $userData->phone];

//            if ($userData) {
//                if ($userData->type == 4) {
//                    $orderArrayData += ["phone" => $address->phone];
//                } else {
//                    $orderArrayData += ["phone" => $userData->phone];
//                }
//            } else {
//                $orderArrayData += ["phone" => $address->phone];
//            }

            $order = Order::create($orderArrayData);

            $order->history()->create(["state_id" => OrderState::CREATED]);

            $products = collect([]);
            if ($order->transaction) {
                $items = optional($order->transaction)->order_details['items'] ?? [];
            } else {
                $items = CartRepository::getUserCartItems($userData);
            }
            foreach ($items as $key => $item) {
                $product = Product::find($item["id"]);
                if ($product->stock < $item["amount"]) {
                    throw new ProductException("Product {$product->name} is out of stock");
                }
                $product->amount = $item["amount"];
                $products->push($product);
            }
            $items = $this->promotionsService->checkForDiscounts($products);

            // TODO:: check promotion-per_month
            if (isset($items['promotionDiscounts']) && count($items['promotionDiscounts']) > 0){
                $this->checkPromotionUses($items['promotionDiscounts'], $userData->id, $order->id);
            }
            $freeDelivery = false;
            // add items
            foreach ($items['items'] as $item) {
                $product = Product::with("paymentMethods")->findOrFail($item->id);
                $freeDelivery = $freeDelivery || $product->free_delivery;
                !isset($item->promotion_id) ?: $dataArr['promotion_id'] = $item->promotion_id;
                $affiliate_amount = null;
                //TODO: Product bundle
                if ($product->parent->type == 2) {
                    if (!$product->parent->bundle_checkout) {
                        $highPriceBundle = $product->bundleProduct()->orderBy('price', 'DESC')->firstOrFail();
                        $lowPriceBundles = $product->bundleProduct()->where('product_id', '!=', $highPriceBundle->id)->get();
                        $dataArr = [
                            "product_id" => $highPriceBundle->id,
                            "amount" => $item->amount,
                            "price_id" => $product->getCurrentPriceId(),
                            "price" => $item->price,
                            "discount_price" => !is_null($item->discount_price) ? $item->discount_price : null,
                            // preorder
                            "preorder" => $product->preorder,
                            "bundle_id" => $item->id
                            // "preorder_price" => $product->preorder_price,
                            // "remaining" => $product->price - $product->preorder_price
                        ];
                        if (config('constants.enable_affiliate')) {
                            $dataArr['affiliate_commission'] = $affiliate_amount;
                        }
                        $order->items()->create($dataArr);
                        foreach ($lowPriceBundles as $bundleProduct) {
                            $dataArr = [
                                "product_id" => $bundleProduct->id,
                                "amount" => $item->amount,
                                "price_id" => null,
                                "price" => 0,
                                "discount_price" => null,
                                // preorder
                                "preorder" => null,
                                "preorder_price" => null,
                                "remaining" => null,
                                "bundle_id" => $item->id
                            ];
                            $order->items()->create($dataArr);
                        }
                    } else {
                        if ($item->affiliate_commission) {
                            $price = $item->discount_price ?? $item->price;
                            $affiliate_amount = $price * ($item->affiliate_commission / 100);
                        }
                        $dataArr = [
                            "product_id" => $item->id,
                            "amount" => $item->amount,
                            "price_id" => $product->getCurrentPriceId(),
                            "price" => $item->price,
                            "discount_price" => !is_null($item->discount_price) ? $item->discount_price : null,
                            // preorder
                            "preorder" => $item->preorder,
                            // "preorder_price" => $item->preorder_price,
                            // "remaining" => $product->price - $item->preorder_price
                        ];
                        if (config('constants.enable_affiliate')) {
                            $dataArr['affiliate_commission'] = $affiliate_amount;
                        }
                        $order->items()->create($dataArr);
                    }
                } else {
                    if ($item->affiliate_commission) {
                        $price = $item->discount_price ?? $item->price;
                        $affiliate_amount = $price * ($item->affiliate_commission / 100);
                    }
                    $dataArr = [
                        "product_id" => $item->id,
                        "amount" => $item->amount,
                        "price_id" => $product->getCurrentPriceId(),
                        "price" => $item->price,
                        "discount_price" => !is_null($item->discount_price) && (empty($product->paymentMethods->pluck('id')->toArray()) || in_array($order->payment_method, $product->paymentMethods->pluck('id')->toArray())) ? $item->discount_price : null,
                        // preorder
                        "preorder" => $item->preorder,
                        // "preorder_price" => $item->preorder_price,
                        // "remaining" => $product->price - $item->preorder_price
                    ];

                    if (config('constants.enable_affiliate')) {
                        $dataArr['affiliate_commission'] = $affiliate_amount;
                    }
                    $order->items()->create($dataArr);
                }

                $product->increment("orders_count");

                if ($product->parent->type == Product::TYPE_BUNDLE) {
                    if ($product->parent->has_stock) {
                        $product->decrement("stock", $item->amount);
                    } else {
                        foreach ($product->bundleProduct as $bundleProduct) {
                            $bundleProduct->decrement("stock", $item->amount);
                        }
                    }
                } else {
                    $product->decrement("stock", $item->amount);
                }
                $weight += $product->weight * $item->amount;
                $numberOfPiece += $item->amount;
            }

            $total = $order->getTotal();

//            $delivery_fees = $this->getDeliveryFeesAmount($orderData['address_id'], $total, $weight, $numberOfPiece, $freeDelivery);
            $delivery_fees = 0;

            // generate invoice
            $invoiceTotal = $orderData['payment_method'] == 5 ? 0 : $total;
            if (in_array($orderData['payment_method'], [
                PaymentMethod::METHOD_VALU,
                PaymentMethod::METHOD_SHAHRY,
                PaymentMethod::METHOD_SOUHOOLA,
                PaymentMethod::METHOD_GET_GO
            ])) {
                $invoiceTotal = $orderData['down_payment'] + $orderData['admin_fees'];
            }
            $invoice = $order->invoice()->create(["total_amount" => $invoiceTotal, "delivery_fees" => $delivery_fees, "total_delivery_fees" => $delivery_fees, "free_delivery" => 0]);

            if (isset($orderData['promo']) && $orderData['promo'] != null) {
                $promo = Promo::with(['paymentMethods' => function ($query) use ($orderData) {
                    $query->where('payment_method_id', $orderData['payment_method']);
                }])
                ->withCount('paymentMethods')
                ->where("name", $orderData['promo'])
                ->first();

                $referer = User::where('referal', $orderData['promo'])->first();

                if ($promo) {
                    $amount = $total;

                    PromoValidator::validate($promo, $userData, $total, $items['items']);
                    if ($promo->list_id) {
                        $amount = 0;
                        foreach ($items['items'] as $item) {
                            if ($promo->list->products()->where("products.id", $item["id"])->orWhere("products.id", $item["parent_id"])->exists()) {
                                $product = Product::find($item["id"]);
                                $promoProducts->push($product);
                                $price = $product->active_discount ? $product->discount_price : $product->price;
                                $amount += $price;
                            }
                        }
                    }
                    if ($promo->type == Promo::FREE_DELIVERY) {
                        $invoice->update(["delivery_fees" => 0, 'free_delivery' => 1, "promo_id" => $promo->id]);
                    } else {
                        $promoDiscount['discount'] = $discount = PromoCalculator::calculate($promo, $amount);
                        $promoDiscount['products'] = $promoProducts;
                        $promoDiscount['promo'] = $promo;
                        $invoice->discount = $invoice->total_amount - $discount;
                        $invoice->promo_id = $promo->id;
                        $invoice->save();
                    }
                    if ($userData) {
                        $userData->userPromos()->attach($promo->id, ["use_date" => Carbon::now(), 'phone' => $userData->phone]);
                    } else {
//                        UserPromo::create(['promo_id' => $promo->id, 'phone' => $address->phone, "use_date" => Carbon::now()]);
                        UserPromo::create(['promo_id' => $promo->id, 'phone' => $userData->phone, "use_date" => Carbon::now()]);
                    }
                } elseif ($referer) {
                    if ($userData) {
                        $order->referal = $referer->referal;
                        $order->save();
                    }
                }
            }

            $grandTotal = (!is_null($invoice->discount) ? $invoice->discount : $total) + $delivery_fees;
            $invoice->update(["grand_total" => $grandTotal]);

            if (isset($orderData['schedule']) && $orderData['schedule'] != null) {
                $order->createSchdule($orderData['schedule']);
            }

            if (!isset($orderData['scheduled_at'])) {
                $this->pushService->notifyAdmins("New Order", "You have received a new order {$order->id}");
            }
            // if (isset($orderData['payment_method']) && $orderData['payment_method'] == PaymentMethods::VISA) {
            if ($userData && $order->customer->id != 999999) {
                Notification::send($order->customer, new OrderPlaced($order));
            }

            // }


            try {
                if ($userData) {
//                    $userData->settings ? app()->setLocale($userData->settings->language) : app()->setLocale('en');
//                    Mail::to($userData)->send(new OrderCreated($order));
                } else {
//                    Mail::to($address->email)->send(new OrderCreated($order));
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }

            // notify ORDER_NOTIFIER_EMAILS, list of emails assigned from admin
            try {
                if (Configuration::getValueByKey('ORDER_NOTIFIER_EMAILS')) {
                    $listOfEmails = explode(',', Configuration::getValueByKey('ORDER_NOTIFIER_EMAILS'));

                    $valid = [];

                    Log::info('List of all emails: '. collect($listOfEmails));
                    if (count($listOfEmails) > 0) {
                        foreach ($listOfEmails as $email) {
                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                               $valid[] = $email; // delete if not valid
                            }
                        }

                        if (count($valid) > 0) {
                            Log::info('List of valid emails: ' . collect($valid));
                            Mail::to($valid)->send(new OrderCreated($order));
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }

            if ($affiliate_id && config('constants.enable_affiliate')) {
                if ($order->affiliateTotalAmount() > 0) {
                    $affiliatePendingDays = config('constants.affiliate_pending_days');
                    $walletData = [
                        "affiliate_id" => $affiliate_id,
                        "order_id" => $order->id,
                        "amount" => $order->affiliateTotalAmount(),
                        "type" => 1,
                        "status" => 1,
                        "due_date" => Carbon::now()->addDays((integer)$affiliatePendingDays)->format('Y-m-d H:i:s'),
                    ];
                    WalletHistory::create($walletData);
                }
            }
            if ($userData) {
                $userData->update(["first_order" => 1]);
            }

            Cart::where('user_id', $order->user_id)->delete();

            DB::commit();
            try {
                $this->mansourService->createOrder($userData, $order, $items['promotionDiscounts'], $promoDiscount, $useWallet);
            } catch (\Exception $exception) {
                Log::error("Mansour Service Create Order File: " . __FILE__ . "\nLine: " . __LINE__ . "\nException: " . $exception->getTraceAsString());
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            // Log::channel("orders")->info("ERROR CREATING ORDER: ", ["request" => request()->all(), "items" => CartRepository::getUserCartItems(), "user" => $userData]);
            Log::channel('orders')->error($e->getMessage());

            $order = null;
            throw $e;
        }

        return $order;
    }

    private function checkPromotionUses($promotionsDiscounts, $userId, $orderId)
    {
        foreach ($promotionsDiscounts as $promotionDiscount){
            if (isset($promotionDiscount['promotion']->periodic)){
                PromotionUser::create([
                    'promotion_id' => $promotionDiscount['promotion']->id,
                    'user_id' => $userId,
                    'order_id' => $orderId,
                    'use_date' => Carbon::now(),
                    "valid_date" => Carbon::now()->addDays($promotionDiscount['promotion']->periodic),
                ]);
            }
        }
    }

    /**
     * Calculate the order grand total to aramex.
     *
     * @param Order $order
     * @return void
     * @deprecated v1.0
     */
    public function getAramexOrderTotal($order)
    {
        // DEPRECATED
        $totalAmount = !is_null($order->invoice->discount) ? $order->invoice->discount : $order->invoice->total_amount;
        $deliveryFees = $order->invoice->delivery_fees;

        switch ($order->payment_method) {
            case PaymentMethod::METHOD_CASH:
            case PaymentMethod::METHOD_VALU:
            case PaymentMethod::METHOD_SHAHRY:
            case PaymentMethod::METHOD_GET_GO:
            case PaymentMethod::METHOD_SOUHOOLA:
                $grandTotal = $totalAmount + $deliveryFees;
                break;
            case PaymentMethod::METHOD_VISA:
            case PaymentMethod::METHOD_VISA_INSTALLMENT:
            case PaymentMethod::METHOD_QNB_INSTALLMENT:
                $grandTotal = 0;
                break;
            case PaymentMethod::METHOD_PREMIUM:
                $grandTotal = $deliveryFees;
                break;
        }
        return $grandTotal;
    }

    /**
     * Calculate the installment fees.
     *
     * @param [type] $orderDetials
     * @param [type] $paymentMethod
     * @return array
     * @deprecated v1.0
     */
    public function calculateInstallmentFees($orderDetials, $paymentMethod)
    {
        // DEPRECATED
        $result = [];

        switch ($paymentMethod) {
            case PaymentMethod::METHOD_VALU:
                $result['down_payment'] = $orderDetials->data->down_payment ?? 0;
                $result['admin_fees'] = 0; //$orderDetials->data->purchase_fees ?? 0; ##Change happened in valu response
                break;
            case PaymentMethod::METHOD_SHAHRY:
                $result['down_payment'] = $orderDetials->data->shahry_order->down_payment ?? 0;
                $result['admin_fees'] = $orderDetials->data->shahry_order->administrative_fees ?? 0;
                break;
            case PaymentMethod::METHOD_SOUHOOLA:
                $result['down_payment'] = $orderDetials->data->installment_info->downpaymentValue ?? 0;
                $result['admin_fees'] = $orderDetials->data->installment_info->adminFees ?? 0;
                break;
            case PaymentMethod::METHOD_GET_GO:
                $result['down_payment'] = $orderDetials->data->down_payment ?? 0;
                $result['admin_fees'] = 0;
                break;
            default:
                $result['down_payment'] = 0;
                $result['admin_fees'] = 0;
                break;
        }
        return $result;
    }

    public function customerCanBuyItems($products)
    {
        $user = auth()->user();

        foreach ($products as $product) {
            $product = $this->customerCanBuyProduct($product, $user);
        }

        return $products;
    }

    public function updateOrder($id, $order_data)
    {
        $order = Order::findOrFail($id);
        $weight = 0;
        $numberOfPiece = 0;
        $order->update([
            "address_id" => $order_data["address_id"],
            "payment_method" => $order_data["payment_method"],
            "admin_notes" => $order_data["admin_notes"] ?? null,
            "notes" => $order_data["notes"] ?? null
        ]);

        if (isset($order_data["deleted_items"])) {
            foreach ($order_data["deleted_items"] as $deletedItem) {
                $order_item = OrderProduct::where('order_id', $order->id)->where("product_id", $deletedItem)->first();
                if ($order_item) {
                    $product = Product::where('id', $deletedItem)->increment("stock", $order_item->amount);
                    $order_item->delete();
                }
            }
        }

        $products = collect([]);
        $items = $order_data["items"];
        foreach ($items as $key => $item) {
            $product = Product::find($item["id"]);
            if ($product) {
                $product->amount = $item["amount"];
                $products->push($product);
                $numberOfPiece += $item['amount'];
                $weight += $product->weight * $item['amount'];
            }
        }
        $items = $this->promotionsService->checkForDiscounts($products);

        foreach ($items['items'] as $item) {
            $order_item = $order->items()->where("product_id", $item->id)->first();
            if (isset($order_item)) {
                $product = Product::findOrFail($item->id);
                if ($order_item->amount > $item->amount) {
                    $product->increment("stock", $order_item->amount - $item->amount);
                } else if ($order_item->amount < $item->amount) {
                    $product->decrement("stock", $item->amount - $order_item->amount);
                }
                $order_item->update(["amount" => $item->amount, "price" => $item->price, "discount_price" => $item->discount_price]);
            } else {
                $product = Product::findOrFail($item->id);
                $product->update(["stock" => $product->stock - $item->amount]);
                $order->items()->create(["product_id" => $item->id, "amount" => $item->amount, "price_id" => $product->getCurrentPriceId(), "price" => $item->price, "discount_price" => $item->discount_price]);
            }
        }

        $total = $order->getTotal();
        $invoice = $order->invoice;

        if (isset($order_data["overwrite_fees"]) && $order_data["overwrite_fees"]) {
            $fees = $order_data["delivery_fees"] ?? null;
        } else {
            if (config('constants.delivery_method') == 'aramex') {
                // $cart = Cart::where('user_id', $order->address->user_id)->first();
                // $fees = $this->shippingFactory::make(ShippingMethods::ARAMEX)->getDeliveryFees($order->address, $cart);
                $fees = $this->shippingFactory::make(ShippingMethods::ARAMEX)->calculateFeesJson($order->address, $weight, $numberOfPiece);
            } else {
                $weight = $items['items']->reduce(function ($carry, $product) {
                    return $carry + ($product->amount * $product->weight);
                });
                $fees = $this->locationService->getAddressDeliveryFees($order->address, $weight);
            }
        }

        $orderData = [
            "delivery_fees" => $fees,
            "admin_discount" => $order_data["admin_discount"] ?? null,
            "total_amount" => $total
        ];
        $invoice->update($orderData);
        if (isset($order_data["remove_promo"])) {
            $invoice->update(["promo_id" => null, "discount" => null]);
        }

        $discount = 0;
        if (isset($invoice->promo)) {
            $promo = $invoice->promo;

            if ($promo->list_id) {
                $total = 0;
                foreach ($items['items'] as $item) {
                    if ($promo->list->products()->where("products.id", $item->id)->exists()) {
                        $product = Product::find($item->id);
                        $price = $item->active_discount ? $item->discount_price : $item->price;
                        $total += $price;
                    }
                }
            }

            $discount = PromoCalculator::calculate($promo, $total);

            $invoice->discount = $invoice->total_amount - $discount;
            $invoice->save();
        }

        return $order;
    }

    public function activeDiscount($product)
    {
        return (bool)($product->discount_start_date >= Carbon::now() && $product->discount_end_date <= Carbon::now());
    }

    public function customerCanBuyProduct($product, $user = null)
    {
        $user = $user ?? auth()->user();
        $max_per_order = $product->parent_id && $product->parent ? $product->parent->max_per_order : $product->max_per_order;
        $min_days = $product->parent_id && $product->parent ? $product->parent->min_days : $product->min_days;

        if (is_null($max_per_order) || $user->id == 999999) {
            // $product->can_buy = $max_per_order;
            $product->can_buy = $product->stock;
            $product->max_per_order = $max_per_order;
            return $product;
        }

        $orders = Order::with(['items' => function ($query) use ($product) {
            $query->where('product_id', $product->id);
        }]);
        if ($min_days) {
            $orders->where('created_at', '>', Carbon::now()->subDays($min_days));
        }
        $orders = $orders->whereHas('items', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })
            ->whereNotIn("state_id", [OrderState::CANCELLED, OrderState::INCOMPLETED])
            ->where('user_id', $user->id)
            ->get();

        $amount = $orders->pluck('items')->sum(function ($product) {
            return $product->first()->amount;
        });

        $amountPerOrder = max($max_per_order - $amount, 0);

        if ($product->stock > $amountPerOrder) {
            $product->can_buy = $amountPerOrder;
        } else {
            $product->can_buy = $product->stock;
        }

        return $product;
    }

    /**
     * Get delivery fees amount
     *
     * @param int $address_id
     * @param int $total
     * @param int $weight
     * @param int $numberOfPiece
     * @param boolean $freeDelivery
     * @return int
     */
    public function getDeliveryFeesAmount($address_id, $total, $weight, $numberOfPiece, $freeDelivery)
    {
        if ((!is_null(config('constants.min_order_amount')) && (integer)config('constants.min_order_amount') <= $total) || $freeDelivery) {
            $fees = 0;
        } else {
            $address = Address::withTrashed()->with('area')->findOrFail($address_id);
            if (config('constants.delivery_method') == 'aramex') {
                if ($weight <= 0 || $numberOfPiece <= 0) {
                    throw new AramexLocationException("weight or Number of Pieces cannot be zero");
                }
                if (!isset($address->area->aramex_area_name) || $address->area->aramex_area_name == null) {
                    throw new AramexLocationException(trans("mobile.errorAramexLocation"));
                }
                // TODO: When refactor shipping method
                // $cart = Cart::where('user_id', $address->user_id)->first();
                // $fess = $this->shippingFactory::make(ShippingMethods::ARAMEX)->getDeliveryFees($address, $cart);
                $fees = $this->aramexService->calculateFeesJson($address, $weight, $numberOfPiece);
            } else {
                $fees = $this->locationService->getAddressDeliveryFees($address);
                // $fees = $this->locationService->getAddressDeliveryFeesv2($address, $weight);
            }
        }
        return $fees;
    }
}
