<?php

namespace App\Http\Controllers\Customer;

use App\Classes\Shipping\ShippingFactory;
use App\Models\Orders\Cart;
use Facades\App\Models\Services\QnbSimplifyPayment;
use App\Models\Shipping\ShippingMethods;
use Exception;
use Carbon\Carbon;
use App\Facade\Sms;
use App\Mail\OrderCreated;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Payment\Promo;
use App\Models\Users\Address;
use App\Services\SmsServices;
use App\Models\Products\Product;
use App\Models\Orders\OrderState;
use App\Models\Orders\Transaction;
use App\Models\Payment\Qnb\Parser;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Orders\OrderManager;
use App\Models\Payment\Qnb\api_lib;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Payment\Qnb\Merchant;
use App\Models\Services\PushService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment\PaymentMethod;
use App\Exceptions\CartEmptyException;
use App\Models\Payment\PromoValidator;
use App\Models\Products\ProductReview;
use App\Models\Services\AramexService;
use App\Models\Services\OrdersService;
use App\Models\Payment\PromoCalculator;
use Illuminate\Support\Facades\Session;
use App\Models\Services\LocationService;
use App\Models\Services\WeAcceptPayment;
use Illuminate\Support\Facades\Validator;
use App\Models\Services\PromotionsService;
use App\Services\Promotion\PromotionsServiceV2;
use App\Models\Services\ValUPaymentService;
use Facades\App\Models\Services\UpgPayment;
use App\Http\Requests\Customer\OrderRequest;
use App\Models\Repositories\OrderRepository;
use Facades\App\Models\Services\BankPayment;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Models\Transformers\ProductTransformer;

use Facades\App\Models\Repositories\CartRepository;
use App\Models\Transformers\CustomerOrderTransformer;
use App\Http\Resources\Customer\PaymentMethodsResource;
use App\Http\Resources\Customer\TotalCategorySpent;

/**
 * Orders Controller class
 * @package App\Http\Controllers\Customer\OrdersController
 */
class OrdersController extends Controller
{
    private $orderTrans;
    private $pushService;
    private $productTrans;
    private $locationService;
    private $promotionsService;
    private $aramexService;
    private $ordersService;
    private $acceptPayment;
    private $shippingFactory;

    /**
     * Constructor
     *
     * @param AramexService $aramexService
     * @param LocationService $locationService
     * @param CustomerOrderTransformer $orderTrans
     * @param PushService $pushService
     * @param ProductTransformer $productTrans
     * @param PromotionsService $promotionsService
     * @param OrdersService $ordersService
     * @param WeAcceptPayment $acceptPayment
     * @param ShippingFactory $shippingFactory
     */
    public function __construct(AramexService $aramexService, LocationService $locationService, CustomerOrderTransformer $orderTrans, PushService $pushService, ProductTransformer $productTrans, PromotionsServiceV2 $promotionsService, OrdersService $ordersService, WeAcceptPayment $acceptPayment, ShippingFactory $shippingFactory)
    {
        $this->orderTrans = $orderTrans;
        $this->pushService = $pushService;
        $this->productTrans = $productTrans;
        $this->locationService = $locationService;
        $this->promotionsService = $promotionsService;
        $this->ordersService = $ordersService;
        $this->acceptPayment = $acceptPayment;
        $this->aramexService = $aramexService;
        $this->shippingFactory = $shippingFactory;
    }

    public function index()
    {
        $orders = Auth::user()->orders()->orderBy("created_at", "DESC");
        if (auth()->user()->type == 4) {
            $orders = $orders->orWhere("affiliate_id", auth()->id());
        }
        $orders = $orders->get();

        return $this->jsonResponse("Success", ["order" => $this->orderTrans->transformCollection($orders), "total" => $orders->count()]);
    }

    public function show($id)
    {
        $order = Order::where("id", $id);

        if (auth()->user()->type == 4) {
            $order->where(function ($q) {
                $q->where("user_id", auth()->id())->orWhere("affiliate_id", auth()->id());
            });
        } else {
            $order->where("user_id", auth()->id());
        }

        $order = $order->firstOrFail();

        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    public function guestShow($id)
    {
        $order = Order::whereNull('user_id')->where('id', $id)->firstOrFail();
        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    /**
     * check promo
     *
     * @param Request $request
     * @return void
     * @deprecated v1.0
     */
    public function checkPromo(Request $request)
    {
        // DEPRECATED
        // validate request
        $validator = Validator::make($request->all(), [
            "promo" => "required",
            "amount" => "required"
        ], ["promo.exists" => "Promo code does not exist"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }


        $promo = Promo::where("name", $request->promo)->first();

        $referer = User::where('referal', $request->promo)->first();

        if (!$promo && !$referer) {
            return $this->errorResponse("Promo code does not exist", "Invalid data", $validator->errors(), 422);
        }

        if ($referer && Auth::user()->first_order) {
            return $this->errorResponse("You already ordered before", "Invalid data", $validator->errors(), 422);
        }


        $amount = $request->amount;
        if ($referer && $amount < config('constants.refer_minimum')) {
            return $this->errorResponse("Refer doesn't meet minimum order amount", "Invalid data", $validator->errors(), 422);
        }

        if ($promo) {
            try {
                PromoValidator::validate($promo, Auth::user(), $request->amount, $request->items);
            } catch (\Exception $e) {
                return $this->errorResponse($e->getMessage(), "error", [], 409);
            }

            $discount = PromoCalculator::calculate($promo, $amount);

            $amount = $request->amount - $discount;
        }

        return $this->jsonResponse("Success", (int)$amount);
    }

    public function checkPromoV2(Request $request)
    {
        // validate request
        $this->validate($request, [
            "promo" => "required",
            "address_id" => "sometimes|nullable",
            // "amount" => "required",
            // "items" => "sometimes|array|filled"
        ], ["promo.exists" => "Promo code does not exist"]);

        $smsServices = new SmsServices();

        $phoneVerifiedError = $smsServices->checkPhoneVerified();

        if ($phoneVerifiedError) {
            return $this->errorResponse($phoneVerifiedError, "error", [], 409);
        }

        $promo = Promo::where("name", $request->promo)->with(['paymentMethods' => function ($q) {
            return $q->notClosedMethods();
        }])->first();

        Auth::user() ? $referer = User::where('referal', $request->promo)->first() : $referer = null;

        if (!$promo && !$referer) {
            return $this->errorResponse(trans("mobile.errorPromoNotExist"), "Invalid data", [], 415);
        }

        if ($referer && Auth::user()->first_order) {
            return $this->errorResponse(trans("mobile.errorPromoFirstOrderOnly"), "Invalid data", [], 415);
        }


        if ($promo) {
            $preOrder = false;
            $free_delivery = false;
            $products = collect([]);
            try {
                $items = CartRepository::getUserCartItems();
                foreach ($items as $item) {
                    $product = Product::find($item["id"]);
                    $product->amount = $item["amount"];
                    // if (!is_null($product->discount_price)) {
                    // }
                    $products->push($product);
                    if ($product->preorder === 1) {
                        $preOrder = true;
                    }
                }
            } catch (CartEmptyException $e) {
                return $this->errorResponse('CartEmptyException', "Invalid data", $e->getMessage(), 422);
            }

            $amount = $products->reduce(function ($total, $product) {
                $price = $product->active_discount ? $product->discount_price : $product->price;
                return $total + ($price * $product->amount);
            });

            if ($referer && $amount < config('constants.refer_minimum')) {
                return $this->errorResponse(trans("mobile.errorPromoMinimumAmount"), "Invalid data", [], 415);
            }

            $items = $this->promotionsService->checkForDiscounts($products);


            $amountNotAppliedPromo = 0;
            if ($promo->list_id) {
                $amount = 0;
                foreach ($items['items'] as $item) {
                    if ($promo->list->products()->where("products.id", $item->id)->orWhere("products.id", $item->parent_id)->exists()) {
                        $price = $item->active_discount ? $item->discount_price : $item->price;
                        $amount += $price;
                    } else {
                        $price = $item->active_discount ? $item->discount_price : $item->price;
                        $amountNotAppliedPromo += $price;
                    }
                }
            }

            try {
                PromoValidator::validate($promo, Auth::user(), $amount, $items['items']);
            } catch (\Exception $e) {
                return $this->errorResponse($e->getMessage(), "error", [], 415);
            }

            if ($promo->type == Promo::FREE_DELIVERY) {
                $free_delivery = true;
            } else {
                $discount = PromoCalculator::calculate($promo, $amount);
                $amount = $amount - $discount;
                $amount += $amountNotAppliedPromo;
            }

            $promoPaymentMethods = $promo->paymentMethods()->notClosedMethods()->get();
            $paymentMethods = $promoPaymentMethods->count() ? $promoPaymentMethods : PaymentMethod::notClosedMethods()->get();

            if (!is_null(config('constants.except_cod_amount')) && $amount > config('constants.except_cod_amount')) {
                $paymentMethods = $paymentMethods->where('is_online', 1);
            }
            // if($preOrder){
            //     $paymentMethods->whereIn('id', [2,1]);
            // }
            return $this->jsonResponse("Success", [
                "amount" => $amount,
                "free_delivery" => $free_delivery,
                "referal" => false,
                "payment_methods" => PaymentMethodsResource::collection($paymentMethods)
            ]);
        } else {
            return $this->jsonResponse("Success", [
                "points" => config('constants.refer_points'),
                "free_delivery" => false,
                "referal" => true
            ]);
        }
    }

    public function getDeliveryFees(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "address_id" => "sometimes|nullable|integer|exists:addresses,id",
            // "items" => "sometimes|array|filled",
            // "items.*id" => "required|integer|exists:products,id",
            // "items.*.amount" => "required|integer",
        ]);

        $weight = 0;
        $numberOfPiece = 0;
        // $preOrder = false;
        $freeDelivery = false;

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        try {
            $cartItems = CartRepository::getUserCartItems();

            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['id']);
                $freeDelivery = $freeDelivery || $product->free_delivery;
                $weight += $product->weight * $item['amount'];
                $numberOfPiece += $item['amount'];

                // if ($product->preorder === 1) {
                //     $preOrder = true;
                // }
            }
        } catch (CartEmptyException $e) {
            return $this->errorResponse('CartEmptyException', "Invalid data", $e->getMessage(), 422);
        }

        $totalAmount = $this->ordersService->getTotalAmount($request->all());
//        $delivery_fees = $this->ordersService->getDeliveryFeesAmount($request->address_id, $totalAmount / 100, $weight, $numberOfPiece, $freeDelivery);
        $delivery_fees = 0;


        $paymentMethods = PaymentMethod::notClosedMethods();
        if (!is_null(config('constants.except_cod_amount')) && ($totalAmount / 100) > config('constants.except_cod_amount')) {
            $paymentMethods->where('is_online', 1);
        }
        // if($preOrder){
        //     $paymentMethods->whereIn('id', [2,1]);
        // }
        $paymentMethods = $paymentMethods->orderBy('order')->get();
        $user = Auth::user();
        // $promos = $user->targetPromos()->whereDoesntHave('uses', function ($q) use ($user) {
        //     $q->where('id', $user->id);
        // })->where('expiration_date', '>', now())->where("active", 1)->orderBy('recurrence')->get();

        $promos = [];
        if (auth()->check()) {
            $promos = Promo::where(function ($qu) use ($user) {
                $qu->whereHas("target_lists", function ($q) use ($user) {
                    $q->where("phone", $user->phone)->orWhere("user_id", $user->id);
                });
            })->whereDoesntHave("uses", function ($q) use ($user) {
                $q->where("id", $user->id);
            })->whereDate('expiration_date', '>=', Carbon::today()->toDateString())->where("active", 1)->orderBy('recurrence')->get();
        }

        return $this->jsonResponse("Success", [
            "payment_methods" => PaymentMethodsResource::collection($paymentMethods),
            "total_amount" => (double)$totalAmount / 100,
            "delivery_fees" => (double)$delivery_fees,
            "free_delivery" => $freeDelivery,
            "promos" => $promos,
            "checkout_notes" => trans("mobile.checkoutNotes")
        ]);
    }

    public function validateCart(Request $request)
    {
        $products = collect([]);
        $items = $request->items;
        foreach ($items as $item) {
            $product = Product::find($item["id"]);
            if ($product) {
                $product->amount = $item["amount"];
                $products->push($product);
            }
        }

        $newCart = $this->promotionsService->checkForDiscounts($products);

        $this->ordersService->customerCanBuyItems($newCart['items']);

        $response['items'] = $this->productTrans->transformCollection($newCart['items']);
        $response['gifts'] = $newCart['gifts'] ?? [];
        $response['suggestions'] = $newCart['suggestions'];
        $response['promotionDiscounts'] = $newCart['promotionDiscounts'];
        $response['isApplied'] = $newCart['isApplied'];

        return $this->jsonResponse("Success", $response);
    }

    /**
     * Create order v1
     *
     * @param Request $request
     * @return void
     * @deprecated v1.0
     */
    public function createOrder(Request $request)
    {
        // DEPRECATED
        $validator = $this->ordersService->validateOrder($request->all(), auth()->user(), $request->header("lang"));
        // validate request
        if (!$validator->valid()) {
            $error = $validator->errors()->first();
            return $this->errorResponse($error->getMessage(), "Invalid data", $validator->errors(), $error->getCode());
        }

        try {
            $totalAmount = $this->ordersService->getTotalAmount($request->all(), true);
            $grandTotal = $totalAmount['grand_total'];
        } catch (CartEmptyException $e) {
            return $this->errorResponse('CartEmptyException', "Invalid data", $e->getMessage(), 422);
        }

        /**
         * Payment online
         */
        $payment_method_id = $request->get('payment_method');

        $payment = config("payment.stores." . $payment_method_id);
        if ($payment['isOnline']) {
            Log::info("CREATING ONLINE PAYMENT ORDER", ["cart" => CartRepository::getUserCartItems(), "total" => $totalAmount]);
            $userToken = (string)JWTAuth::getToken();

            if (in_array($payment_method_id, [
                PaymentMethod::METHOD_VALU,
                PaymentMethod::METHOD_PREMIUM,
                PaymentMethod::METHOD_SHAHRY,
                PaymentMethod::METHOD_SOUHOOLA,
                PaymentMethod::METHOD_GET_GO])) {
                //Calculate grand total without delivery fees
                $grandTotal = $totalAmount['total'];
            }

            // attach user-ip to request data for creating transaction data later
            $request->merge(['user_ip' => getRealIp()]);

            switch ($payment_method_id) {
                case PaymentMethod::METHOD_QNB:
                case PaymentMethod::METHOD_QNB_INSTALLMENT:
                    $transaction = BankPayment::CreateTransaction($grandTotal, $request->all());
                    $url = url('/api/customer/orders/payment-view/' . $transaction->id . '?token=' . $userToken);
                    return $this->jsonResponse("Success", ['pay_url' => $url], 203);
                    break;
                case PaymentMethod::METHOD_MEZA:
                    $transaction = UpgPayment::CreateTransaction($grandTotal, $request->all());
                    $url = url('/api/customer/orders/payment-view/' . $transaction->id . '?token=' . $userToken);
                    return $this->jsonResponse("Success", ['pay_url' => $url], 203);
                    break;
                case PaymentMethod::METHOD_VISA:
                case PaymentMethod::METHOD_VALU:
                case PaymentMethod::METHOD_FAWRY:
                case PaymentMethod::METHOD_PREMIUM:
                case PaymentMethod::METHOD_VISA_INSTALLMENT:
                case PaymentMethod::METHOD_SOUHOOLA:
                case PaymentMethod::METHOD_GET_GO:
                case PaymentMethod::METHOD_SHAHRY:
                case PaymentMethod::METHOD_VODAFONE_CASH:
                    $pay = $this->acceptPayment->Pay($grandTotal, $request->all(), $totalAmount['items_price']);
                    if (!$pay && PaymentMethod::METHOD_VODAFONE_CASH) {
                        return $this->errorResponse(__('mobile.thisPhoneDoesNotHaveAWallet'), __('mobile.thisPhoneDoesNotHaveAWallet'));
                    }
                    return $this->jsonResponse("Success", ['pay_url' => $pay], 202);
                    break;
                case PaymentMethod::METHOD_QNB_SIMPLIFY:
                    $url = QnbSimplifyPayment::Pay($grandTotal, $request->all(), $totalAmount['items_price'], auth()->User());
                    return $this->jsonResponse("Success", ['pay_url' => $url], 202);
                    break;
                default:
                    return $this->errorResponse('Payment method Not Found', "Invalid data", null, 404);
                    break;
            }
        }

        $order = $this->ordersService->createOrder($request->all(), null, auth()->User());
        $code = 200;
        $msg = "Success";

        $open_time = date("Y-m-d") . " " . config('constants.open_time');
        $off_time = date("Y-m-d") . " " . config('constants.off_time');
        if (strtotime(date("H:i")) < strtotime($open_time) || strtotime(date("H:i")) > strtotime($off_time)) {
            $msg = trans("mobile.errorStoreClosed");
            $code = 201;
        }
        return $this->jsonResponse($msg, $this->orderTrans->transform($order), $code);
    }

    /**
     * Payment view
     *
     * @param [type] $transactionID
     * @return void
     * @deprecated v1.0
     */
    public function paymentView($transactionID)
    {
        // DEPRECATED
        try {
            $transaction = Transaction::where('id', $transactionID)->where('transaction_status', 0)->firstOrFail();
            switch ($transaction->order_details['payment_method']) {
                case PaymentMethod::METHOD_QNB:
                case PaymentMethod::METHOD_QNB_INSTALLMENT:
                case PaymentMethod::METHOD_NBE:
                case PaymentMethod::METHOD_NBE_INSTALLMENT:
                    $payView = BankPayment::payOrder($transaction);
                    break;
                case PaymentMethod::METHOD_MEZA:
                    $payView = UpgPayment::pay($transaction);
                    break;
                case PaymentMethod::METHOD_QNB_SIMPLIFY:
                    $payView = QnbSimplifyPayment::PayView($transaction);
                    break;
            }
            return $payView;
        } catch (Exception $e) {
            $message = $e->getMessage();
            Log::info("message " . $message);
            return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=false&message=Payment not completed!');
        }
    }

    public function cancelOrder(Request $request, $id)
    {
        $order = Auth::user()->orders()->findOrFail($id);
        $om = new OrderManager($order);
        try {
            $om->changeStates(OrderState::CANCELLED, $request->sub_state_id, Auth::user(), $request->status_notes, true);
        } catch (\Exception $e) {
            return $this->errorResponse("Can't cancel order because it is " . $order->state->name, "Invalid data", [], 422);
        }

        Auth::user()->settings ? app()->setLocale(Auth::user()->settings->language) : app()->setLocale('en');
        $this->pushService->notifyAdmins("Order Cancelled", "Customer {$order->user_id} Has just cancelled order {$order->id}");
        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    public function editSchedule(Request $request, $order_id)
    {
        $order = Auth::user()->orders()->findOrFail($order_id);
        if ($order->scheduled_at) {
            $order->update(["scheduled_at" => $request->schedule_date]);
        } else {
            $order->schedule()->delete();
            $order->createSchdule($request);
        }

        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    public function cancelSchedule($order_id)
    {
        $order = Auth::user()->orders()->findOrFail($order_id);
        if ($order->scheduled_at) {
            $order->delete();
        } else {
            $order->schedule()->delete();
        }

        return $this->jsonResponse("Success");
    }

    public function editLateSchedule(Request $request, $order_id)
    {
        $order = Auth::user()->orders()->findOrFail($order_id);
        $order->update(["scheduled_at" => $request->schedule_date]);

        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    public function cancelLateSchedule($order_id)
    {
        $order = Auth::user()->orders()->findOrFail($order_id);
        $order->delete();

        return $this->jsonResponse("Success");
    }

    public function rateOrder(Request $request, $id)
    {
        $order = Auth::user()->orders()->findOrFail($id);

        // validate request
        $validator = Validator::make($request->all(), [
            "rate" => "required|integer|in:1,2,3,4,5",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $order->rate = $request->rate;
        $order->feedback = $request->feedback;
        $order->save();

        if ($request->rate <= 2) {
            $this->pushService->notifyAdmins("Order Rating", "Order ID {$order->id} is rated {$request->rate}");
        }

        try {
            $order->deliverer->calculateRate();
        } catch (\Throwable $e) {
            // No deliverer found for this order
            Log::warning("Order has no Deliverer");
        }

        if ($request->items) {
            foreach ($request->items as $item) {
                $orderItem = $order->items()->where('product_id', $item["id"])->first();
                if ($orderItem) {
                    $data['type'] = 2;
                    $data['user_id'] = $order->user_id;
                    $data['product_id'] = $item['id'];
                    $data['order_id'] = $order->id;
                    $data['rate'] = $item['rate'];
                    $data['comment'] = isset($item['comment']) ? $item['comment'] : '';
                    $productReview = ProductReview::where('order_id', $order->id)->where('product_id', $item['id'])->where('user_id', $data['user_id'])->first();
                    if ($productReview) {
                        $productReview->update($data);
                    } else {
                        ProductReview::create($data);
                    }
                }
            }
        }

        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    /**
     * bank callback
     *
     * @param Request $request
     * @param [type] $transactionID
     * @return void
     * @deprecated v0.1
     */
    public function orderReceipt(Request $request)
    {
        // DEPRECATED
        $resultIndicator = $request->resultIndicator;
        // dd(Session::get("orderID"), Session::all());
        $order = Order::find(Session::get("orderID"));

        $om = new OrderManager($order);
        // dd($request->all(), Session::all(), $order);
        if ($resultIndicator == Session::get("successIndicator")) {
            $invoice = $order->invoice;
            if (!is_null($invoice->discount)) {
                $invoice->update(["paid_amount" => $invoice->discount + $invoice->delivery_fees]);
            } else {
                $invoice->update(["paid_amount" => $invoice->total_amount + $invoice->delivery_fees]);
            }
            $this->pushService->notify($order->customer, __('notifications.placingOrderTitle', ['orderId' => $order->id]), __('notifications.placingOrderBody'));
            $om->changeState(OrderState::CREATED, Auth::user());
            Auth::user()->settings ? app()->setLocale(Auth::user()->settings->language) : app()->setLocale('en');
            Mail::to(Auth::user())->send(new OrderCreated($order));
            return redirect(config('app.website_url') . "/checkout/redirect?order_id={$order->id}&success=1");
        } else {
            $om->cancelOrder(Auth::user(), true);
            return redirect(config('app.website_url') . "/account/orders/{$order->id}?failed=1");
        }
    }

    /**
     * bank callback
     *
     * @param Request $request
     * @param [type] $transactionID
     * @return void
     * @deprecated v1.0
     */
    public function orderQnbReceipt(Request $request, $transactionID)
    {
        // DEPRECATED
        $user = auth()->user();
        $transaction = Transaction::where('id', $transactionID)->whereNull('transaction_status')->firstOrFail();

        switch ($transaction->order_details['payment_method']) {
            case PaymentMethod::METHOD_QNB:
            case PaymentMethod::METHOD_QNB_INSTALLMENT:
                $redirectUrl = BankPayment::payCallBack($transaction, $request);
                break;
            case PaymentMethod::METHOD_MEZA:
                $redirectUrl = UpgPayment::payCallBack($transaction, $request);
                break;
        }
        return redirect($redirectUrl);
    }

    public function orderQnbSimplifyReceipt(Request $request, $transactionID)
    {
        $transaction = Transaction::where('id', $transactionID)->whereNull('transaction_status')->firstOrFail();

        switch ($transaction->order_details['payment_method']) {
            case PaymentMethod::METHOD_QNB_SIMPLIFY:
                $transaction = QnbSimplifyPayment::responseCallBack($transaction, $request->all());
                break;
        }
        if ($transaction) {
            $order = $this->ordersService->createOrder($transaction->order_details, $transaction->id, $transaction->customer);
            $url = config('app.website_url') . '/checkout/final-receipt?is_success=true&order_status=' . $order->state->name . '&order_id=' . $order->id;
        } else {
            $url = config('app.website_url') . '/checkout/final-receipt?is_success=false&message=';
        }
        return redirect($url);
    }

    /**
     * We accept callback
     *
     * @param Request $request
     * @param [type] $provider
     * @return void
     * @deprecated v1.0
     */
    public function responseCallBack(Request $request, $provider)
    {
        // DEPRECATED
        $orderData = $this->acceptPayment->getOrderData($request->id);
        Log::debug('responseCallBack - #OrderData: ' . json_encode($orderData));
        Log::debug('responseCallBack - #Request: ' . json_encode($request->all()));

        switch ($provider) {
            case 'weAccept':
                try {
                    $transaction = $this->acceptPayment->responseCallBack($request);
                    if ($transaction->transaction_status === Transaction::TRANSACTION_STATUS_SUCCESS) {
                        $downPaymentInfo = $this->ordersService->calculateInstallmentFees($orderData, $transaction->order_details['payment_method']);
                        $user = User::findOrFail($transaction->customer_id);

                        $items = CartRepository::getUserCartItems($user);

                        $request->merge($downPaymentInfo);
                        $request->request->add([
                            'transaction_user_agent' => $transaction->user_agent,
                            "items" => isset($transaction->order_details['items']) && count($transaction->order_details['items']) ? $transaction->order_details['items'] : $items
                        ]);

                        $order = $this->ordersService->createOrder($transaction->order_details, $transaction->id, $user);
                        $transaction->update([
                            'order_id' => $order->id
                        ]);

                        Log::info(config('app.url') . '/checkout/final-receipt?is_success=true&order_status=' . $order->state->name . '&order_id=' . $order->id);

                        return redirect(config('app.url') . '/checkout/final-receipt?is_success=true&order_status=' . $order->state->name . '&order_id=' . $order->id);
                    }
                    $message = isset($transaction->transaction_response['data_message']) ? $transaction->transaction_response['data_message'] : "Transaction did not completed";
                } catch (Exception $e) {
                    $message = $e->getMessage();
                }
                Log::info("message " . $message);
                return redirect(config('app.url') . '/checkout/final-receipt?is_success=false&message=' . $message . '');
        }
        return false;
    }

    /**
     * We accept callback
     *
     * @param Request $request
     * @param [type] $provider
     * @return void
     * @deprecated v1.0
     */
    public function processesCallBack(Request $request, $provider)
    {
        // DEPRECATED
        Log::debug('processesCallBack - #Request: ' . json_encode($request->all()));

        switch ($provider) {
            case 'weAccept':
                $callback = $this->acceptPayment->processesCallback($request);
                return $callback;
        }

        return false;
    }

    public function purcahseTargets(Request $request)
    {
        $user = Auth::user();
        if ($request->user_id) {
            $user = User::find($request->user_id);
        }
        if (!$user) {
            return $this->errorResponse('Invalid user', 'Invalid user');
        }
        $mssqlConnection = DB::connection('sqlsrv');
        $currentYear = date('Y');
        $currentMonth = date('m');

         $userCode = explode('_', $user->code);
         $terId = $userCode[0];
         $posId = $userCode[1];
         $targets = $mssqlConnection->table('dbo.test_Target_Types')
             ->join('dbo.Target_POS', 'dbo.Target_POS.target_type_id', '=', 'dbo.Target_Types.target_type_id')
             ->where('dbo.Target_POS.year', '=', $currentYear)
             ->where('dbo.Target_POS.month', '=', $currentMonth)
             ->where('dbo.Target_POS.ter_id', '=', $terId)
             ->where('dbo.Target_POS.pos_id', '=', $posId)
             ->get();

         $targetsResponse = [];
         foreach($targets as $target) {
             $targetsResponse[] = [
                 'name' => $target->target_type_name,
                 'name_ar' => $target->target_type_name,
                 'achieved' => $target->achieved,
                 'target' => $target->target_sales
             ];
         }

//        return $this->jsonResponse('Success', TotalCategorySpent::collection($totalSpentPerCategory));
        return $this->jsonResponse('Success', $targetsResponse);
    }
}
