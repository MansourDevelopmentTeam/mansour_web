<?php

namespace App\Http\Controllers\Admin;

use App\Models\Services\MansourService;
use App\Models\Users\Wallet;
use App\Notifications\CashbackNotification;
use Carbon\Carbon;
use App\Facade\Sms;
use Octw\Aramex\Aramex;
use App\Mail\OrderCreated;
use App\Models\Users\User;
use App\Models\Orders\Cart;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Shipping\Pickup;
use App\Models\Products\Product;
use App\Models\Orders\OrderState;
use App\Models\Loyality\UserPoint;
use App\Notifications\OrderEdited;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\OrderManager;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Services\PushService;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Payment\PaymentMethod;
use App\Exceptions\CartEmptyException;
use App\Models\Payment\PaymentMethods;
use App\Models\Services\AramexService;
use App\Models\Services\OrdersService;
use App\Models\Services\ValidateOrder;
use App\Models\Payment\PromoCalculator;
use App\Models\Services\LocationService;
use App\Models\Services\LoyalityService;
use App\Models\Shipping\ShippingMethods;
use App\Notifications\OrderStateChanged;
use App\Classes\Shipping\ShippingFactory;
use Illuminate\Support\Facades\Validator;
use App\Sheets\Export\Orders\OrdersExport;
use App\Http\Resources\Admin\OrderResource;
use App\Models\Repositories\OrderRepository;
use Illuminate\Support\Facades\Notification;
use App\Models\Transformers\OrderTransformer;
use Illuminate\Validation\ValidationException;
use App\Models\Repositories\DelivererRepository;
use App\Models\Services\InternalShippingService;
use App\Models\Transformers\OrderDetailsTransformer;
use App\Http\Requests\Admin\Order\CreateOrderRequest;
use App\Models\Transformers\CustomerOrderTransformer;
use App\Models\Products\Category;

class OrdersController extends Controller
{
    private $ordersRepo;
    private $delivererRepo;
    private $detailsTransformer;
    private $orderTrans;
    private $pushService;
    private $customerOrderTrans;
    private $loyality;
    private $ordersService;
    private $validateOrder;
    private $aramexService;
    private $locationService;
    private $shippingFactory;
    private $mansourService;

    /**
     * Constructor
     *
     * @param AramexService $aramexService
     * @param LocationService $locationService
     * @param OrderRepository $ordersRepo
     * @param DelivererRepository $delivererRepo
     * @param ValidateOrder $validateOrder
     * @param OrderDetailsTransformer $detailsTransformer
     * @param OrderTransformer $orderTrans
     * @param PushService $pushService
     * @param CustomerOrderTransformer $customerOrderTrans
     * @param LoyalityService $loyality
     * @param OrdersService $ordersService
     * @param ShippingFactory $shippingFactory
     */
    public function __construct(AramexService $aramexService, LocationService $locationService, OrderRepository $ordersRepo, DelivererRepository $delivererRepo, ValidateOrder $validateOrder, OrderDetailsTransformer $detailsTransformer, OrderTransformer $orderTrans, PushService $pushService, CustomerOrderTransformer $customerOrderTrans, LoyalityService $loyality, OrdersService $ordersService, ShippingFactory $shippingFactory, MansourService $mansourService)
    {
        $this->ordersRepo = $ordersRepo;
        $this->delivererRepo = $delivererRepo;
        $this->detailsTransformer = $detailsTransformer;
        $this->orderTrans = $orderTrans;
        $this->validateOrder = $validateOrder;
        $this->pushService = $pushService;
        $this->customerOrderTrans = $customerOrderTrans;
        $this->loyality = $loyality;
        $this->ordersService = $ordersService;
        $this->aramexService = $aramexService;
        $this->locationService = $locationService;
        $this->shippingFactory = $shippingFactory;
        $this->mansourService = $mansourService;
    }

    public function index()
    {
        $orders = $this->ordersRepo->getAllOrdersPaginated();

        $total = $this->ordersRepo->getTotalOrders();

        return $this->jsonResponse("Success", ["orders" => $this->orderTrans->transformCollection($orders), "total" => $total]);
    }

    public function getUnassignedOrders()
    {
        $orders = $this->ordersRepo->getUnassignedOrders();

        return $this->jsonResponse("Success", $this->orderTrans->transformCollection($orders));
    }

    public function filter(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "page" => "required|min:1"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $query = Order::with("customer.addresses", "transaction");
        $orders = $this->ordersRepo->filterOrders($request->all(), $query);
        $ordersPaginate = $orders->paginate(20);
        $total = $ordersPaginate->total();
        return $this->jsonResponse("Success", ["orders" => OrderResource::collection($ordersPaginate), "total" => $total]);
    }

    public function createOrder(CreateOrderRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     "user_id" => "required|exists:users,id",
        //     "address_id" => "required|exists:addresses,id",
        //     "overwrite_fees" => "sometimes|nullable|boolean",
        //     "delivery_fees" => "sometimes|nullable|integer|min:0",
        //     "admin_notes" => "sometimes|nullable",
        // ]);
        // if ($validator->fails()) {
        //     return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        // }
        $user = User::where('id', $request->user_id)->where('type', 1)->firstOrFail();

        $validate = $this->validateOrder->validateOrder($request->all(), $user);
        if ($validate !== true) {
            return $this->errorResponse('Invalid data', "Invalid data", $validate, 422);
        }

        try {
            $totalAmount = $this->ordersService->getTotalAmount($request->all());
        }catch(CartEmptyException $e){
            return $this->errorResponse('CartEmptyException', "Invalid data", $e->getMessage(), 422);
        }

        if (
            !is_null(config('constants.except_cod_amount'))
            && ($totalAmount / 100) >= config('constants.except_cod_amount')
            && $request->payment_method == 1
        ) {
            // return $this->errorResponse('Invalid data', "Invalid data", "Cash method allowed for orders with total lower than {config('constants.except_cod_amount')}", 422);
            return $this->errorResponse("Select another payment method because you have exceeded the max {config('constants.except_cod_amount')}. use of cash on delivery", "Invalid data", "Select another payment method because you have exceeded the max {config('constants.except_cod_amount')}. use of cash on delivery", 422);
        }

        $request->merge(['user_ip' => getRealIp()]);

        $order = $this->ordersService->createOrder($request->all(), null, $user, auth()->user()->id);
        $order->update(['admin_notes' => $request->admin_notes]);
        $invoice = $order->invoice;

        if ($request->overwrite_fees) {
            $fees = $request->delivery_fees;
        } else {
            $fees = $invoice->delivery_fees;
        }
        $invoice->update(["delivery_fees" => $fees]);
        return $this->jsonResponse("Success", $this->detailsTransformer->transform($order));
    }

    public function updateOrder(Request $request, $id)
    {
        $this->validate($request, [
            "items" => "required|array|filled",
            "items.*.id" => "required",
            "items.*.amount" => "required",
            "delivery_fees" => "required|min:0",
            "address_id" => "sometimes|exists:addresses,id",
            // "admin_notes" => "required",
            // "notes" => "required",
        ]);

        Order::findOrFail($id);
        $order = $this->ordersService->updateOrder($id, $request->all());

        if ($request->notify_customer) {
            $order->customer->settings ? app()->setLocale($order->customer->settings->language) : app()->setLocale('en');
            Mail::to($order->customer)->send(new OrderCreated($order));
            Notification::send($order->customer, new OrderEdited($order));
        }

        return $this->jsonResponse("Success", $this->detailsTransformer->transform($order));
    }

    public function changeState(Request $request, $id)
    {

        $order = Order::findOrFail($id);

        $this->validate($request, ["state_id" => "required"]);

        $om = new OrderManager($order);
        $om->changeState($request->state_id, \Auth::user());

        if ($request->notify_customer) {
            $order->customer->settings ? app()->setLocale($order->customer->settings->language) : app()->setLocale('en');
            Mail::to($order->customer)->send(new OrderCreated($order));
            Notification::send($order->customer, new OrderStateChanged($om->getOrder()));
            if($order->state_id != OrderState::CANCELLED) {
                Sms::sendSms($order->phone, 'Dear customer, your online order #' . $order->id . ' has been ' . strtolower($order->state->name) . ', ' . $order->url);
            }
        }

        return $this->jsonResponse("Success", $this->orderTrans->transform($om->getOrder()));
    }

    public function changeSubState(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $this->validate($request, ["sub_state_id" => "required"]);

        $om = new OrderManager($order);
        $om->changeSubState($request->sub_state_id, \Auth::user());

        return $this->jsonResponse("Success", $this->orderTrans->transform($om->getOrder()));
    }

    public function cancelPickup(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "cancelled_reason" => "required|min:1"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $pickup = Pickup::where('id', $id)->where('status', 1)->firstOrFail();
        if ($pickup->pickup_time < Carbon::parse()->format('Y-m-d H:i:s')) {
            return $this->errorResponse("You cannot Cancel pic up that is in the past", "Invalid token", [], 400);
        }
        $pickupGuid = $pickup->shipping_guid;
        try {
            Aramex::cancelPickup($pickupGuid, $request->cancelled_reason);
            $pickup->update(['status' => 3]);
            return $this->jsonResponse("Success");
        } catch (\Exception $e) {
            return $this->errorResponse("invalid pickup", "Invalid token", $e->getMessage(), 400);
        }
    }

    public function bulkChangeState(Request $request)
    {
        $request->merge([
            'notify_customer' => true,
            'subtract_stock' => $request->subtract_stock ?? true,
        ]);

        $this->validate($request, [
            "status_notes" => "sometimes|nullable|string",
            "order_ids" => "required|array",
            "state_id" => "required|integer|exists:order_states,id",
            "sub_state_id" => "sometimes|nullable|integer|exists:order_states,id",
            // "pickup_date" => "nullable|required_if:state_id,8|date",
            "aramex_account_number" => "nullable|required_if:shipping_method,3|in:1,2",
            "shipping_notes" => "sometimes|nullable",
            "shipping_method" => "nullable|required_if:state_id,8|integer|in:1,2,3",
            "branch_id" => "nullable|required_if:state_id,8|integer|exists:users,id",
            "subtract_stock" => "sometimes|nullable|boolean",
            "pickup_guid" => "sometimes|nullable",
        ]);
        foreach ($request->order_ids as $order_id) {
            $order = Order::find($order_id);
            $orderState = OrderState::find($order->state_id);
            $orderStateName = $orderState->getName($request->header('lang', 1));
            $newOrderState = OrderState::find($request->state_id);
            $newOrderStateName = $newOrderState->getName($request->header('lang', 1));
            $notReturnedDeliveredOrder = ($order->state_id == OrderState::DELIVERED && $request->state_id != OrderState::RETURNED);
            $returnNotDeliveredOrder = ($order->state_id != OrderState::DELIVERED && $request->state_id == OrderState::RETURNED);
            $changeReturnOrder = ($order->state_id == OrderState::RETURNED);
            if ($notReturnedDeliveredOrder || $returnNotDeliveredOrder || $changeReturnOrder) {
                return $this->errorResponse(__('web.can_not_order_status', ['from_status' => $orderStateName, 'to_status' => $newOrderStateName]), 'Can not change order status from ' . $orderStateName . ' to ' . $newOrderStateName);
            }
            $order_manager = new OrderManager($order);
            $order_manager->changeStates($request->state_id, $request->sub_state_id, \Auth::user(), $request->status_notes, $request->subtract_stock);
            $this->mansourService->changeOrderState($order_id, $request->state_id);
            if ($request->state_id == MansourService::DELIVERED) {
                $walletOrderAmount = Wallet::where('order_id', '=', $order_id)->get()->sum('amount');
                Wallet::where('order_id', '=', $order_id)->update([
                    'delivered' => true
                ]);
                if ($walletOrderAmount) {
                    Log::info('Wallet Cashback : ' . $walletOrderAmount . ' notification');
                    Notification::send($order->customer, new CashbackNotification($walletOrderAmount));
                }
            } elseif ($request->state_id == MansourService::RETURNED) {
                Wallet::where('order_id', '=', $order_id)->update([
                    'delivered' => false
                ]);
            }
            // if ($o["sub_state_id"]) {
            //     $order_manager->changeSubState($o["sub_state_id"], \Auth::user());
            // }
            // TODO send notification
            if ($order->customer && $request->notify_customer) {
                $order->customer->settings ? app()->setLocale($order->customer->settings->language) : app()->setLocale('en');
                // Mail::to($order->customer)->send(new OrderCreated($order));
                Notification::send($order->customer, new OrderStateChanged($order_manager->getOrder()));
            }
            if ($order->customer && $request->state_id == OrderState::DELIVERED && $request->has('add_loyalty_points') && $request->get('add_loyalty_points')) {
                $amount = $order->invoice->promo_id ? $order->invoice->discount : $order->invoice->total_amount;
                $this->loyality->addUserPoints($order->customer, $amount, $order);
                $this->loyality->updateUserSpending($order->customer, $amount);

                $totalSpentPerCategory = $this->calculateAmountSpentPerCategory($order);
                foreach($totalSpentPerCategory as $categoryId => $totalSpent) {
                    $totalSpentRecord = $order->customer->totalSpentPerCategory()->firstOrCreate([
                        'category_id' => $categoryId
                    ]);
                    $totalSpentRecord->increment('total_spent', $totalSpent);
                }
                if ($order->referal && config('constants.refer_points')) {
                    $referer = User::where('referal', $order->referal)->first();
                    $point = [
                        "total_points" => config('constants.refer_points'),
                        "remaining_points" => config('constants.refer_points'),
                        "amount_spent" => 0,
                        "expiration_date" => $this->loyality->nextExpirationDate(),
                        "activation_date" => now(),
                        "order_id" => $order->id,
                        "referer_id" => $referer->id
                    ];

                    $referer->points()->create($point);
                    $order->customer->points()->create($point);
                    $order->customer->update(['refered' => $referer->referal]);
                }
            }
            if (($request->state_id == OrderState::CANCELLED || $request->state_id == OrderState::RETURNED) && $request->get('remove_loyalty_points', true)) {

                UserPoint::where('order_id', $order->id)->where('user_id', $order->user_id)->delete();
            }

            // if ($order->user_id && $request->shipping_method === ShippingMethods::ARAMEX) {
            //
            //     $branch = User::where('id', $request->branch_id)->where('type', 3)->firstOrFail();
            //
            //     // $options = new \stdClass();
            //     // $options->aramex_account_number = $request->get('aramex_account_number');
            //     // $options->pickup_guid = $request->get('pickup_guid');
            //     // $options->shipping_notes = $request->get('shipping_notes');
            //     // $shipment = $this->shippingFactory::make(ShippingMethods::ARAMEX)->createShipment($order, $branch, $options);
            //     $shipment = $this->aramexService->CreateShipment($request, $branch, $order, $request->get('aramex_account_number'));
            //
            //
            //
            // // if ($shipment !== true) {
            // //     return $this->errorResponse($aramex, "Invalid data", '', 422);
            // // }
            // } elseif ($order->customer && $request->shipping_method === ShippingMethods::INTERNAL) {
            //     $internalService = new InternalShippingService;
            //     $internalService->createPickup($request->order_ids, $request->shipping_notes, $request->pickup_date);
            // }
        }

        return $this->jsonResponse("Success");
    }

    public function returnItems(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $this->validate($request, [
            "items" => "required|array",
            "items.*.id" => "required",
            "items.*.returned_quantity" => "required"
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->items as $item) {
                $order_item = $order->items()->where("product_id", $item["id"])->first();

                if ($item["returned_quantity"] > $order_item->amount) {
                    throw new \Exception("Returned quantity can't be great than original quantity");
                }
                $order_item->update(["returned_quantity" => $item["returned_quantity"]]);

                $product = $order_item->product;
                $product->update(["stock" => $product->stock + $item["returned_quantity"]]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage(), "Invalid data", $e->getMessage(), 422);
        }

        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    public function editOrderItemsSerialNumber(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validator = Validator::make($request->all(), [
            "id" => "sometimes|nullable|integer|exists:order_products,product_id",
            "serial_number" => "sometimes|nullable|array",
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $request->serial_number = implode(',', $request->serial_number);
        $orderItem = $order->items()->where('product_id', $request->id)->first();
        $orderItem->update(["serial_number" => $request->serial_number]);
        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    public function returnOrder($id)
    {
        $order = Order::findOrFail($id);

        foreach ($order->items as $item) {
            $item->update(["returned_quantity" => $item->amount]);
            $product = $item->product;
            $product->update(["stock" => $product->stock + $item->amount]);
        }

        return $this->jsonResponse("Success", $this->orderTrans->transform($order));
    }

    public function assignDeliverer(Request $request, $id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        // validate request
        $validator = Validator::make($request->all(), [
            "deliverer_id" => "required|exists:users,id"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $deliverer = $this->delivererRepo->getDelivererById($request->deliverer_id);

        $om = new OrderManager($order);
        $om->assignDeliverer($deliverer, \Auth::user());

        // $this->pushService->notify($deliverer, "لديك طلب جديد", "طلب جديد");
        // $this->pushService->notify($order->customer, "Order ID #{$order->id} is now processing", "Order Processing");
        // Mail::to($order->customer)->send(new OrderCreated($order));

        return $this->jsonResponse("Success", $om->getOrder()->load("customer"));
    }

    public function cancelOrder(Request $request, $id)
    {

        $order = $this->ordersRepo->getOrderById($id);

        $om = new OrderManager($order);
        $om->cancelOrder(\Auth::user(), $request->subtract_stock);

        $order->customer->settings ? app()->setLocale($order->customer->settings->language) : app()->setLocale('en');

        Mail::to($order->customer)->send(new OrderCreated($order));
        $this->pushService->notify($order->customer, __('notifications.cancelOrderTitle', ['orderId' => $order->id]), __('notifications.cancelOrderBody'));

        if ($order->deliverer)
            $this->pushService->notify($order->customer, __('notifications.cancelOrderTitle', ['orderId' => $order->id]), __('notifications.cancelOrderBody'));

        return $this->jsonResponse("Success", $om->getOrder()->load("customer"));
    }

    public function editAddress(Request $request, $id)
    {

        $order = $this->ordersRepo->getOrderById($id);
        $this->validate($request, [
            "name" => "required",
            "address" => "required",
            "apartment" => "required",
            "floor" => "required",
            "landmark" => "sometimes|nullable",
            "city_id" => "sometimes|nullable|exists:cities,id",
            "area_id" => "sometimes|nullable|exists:areas,id",
            "district_id" => "sometimes|nullable|exists:districts,id",
            "lat" => "required",
            "lng" => "required"
        ]);
        if (!$request->area_id) {
            $request->merge(["area_id" => null]);
        }
        if (!$request->district_id) {
            $request->merge(["district_id" => null]);
        }
        $order->address()->update($request->only(["name", "address", "apartment", "floor", "landmark", "lat", "lng", "city_id", "area_id", "district_id"]));

        if ($order->invoice->delivery_fees) {
            $weight = 0;
            $numberOfPiece = 0;
            foreach ($order->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $weight += $product->weight * $item['amount'];
                $numberOfPiece += $item['amount'];
            }

            if (config('constants.delivery_method') == 'aramex') {
                $cart = Cart::where('user_id', $order->user_id)->first();
                $fees = $this->shippingFactory::make(ShippingMethods::ARAMEX)->getDeliveryFees($order->address, $cart);
            } else {
                $fees = $this->locationService->getAddressDeliveryFees($order->address, $weight);
            }

            $order->invoice->update(["delivery_fees" => $fees]);
        }

        return $this->jsonResponse("Success", $this->detailsTransformer->transform($order));
    }

    public function proceedOrder($id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        $om = new OrderManager($order);

        try {
            $om->proceedOrder(\Auth::user());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), "Error", [], 409);
        }

        return $this->jsonResponse("Success", $this->orderTrans->transform($om->getOrder()->load("customer")));
    }

    public function completeOrder($id)
    {
        $order = $this->ordersRepo->getOrderById($id);
        $om = new OrderManager($order);
        $om->changeState(OrderState::DELIVERED, \Auth::user());

        if ($order->payment_method == PaymentMethod::METHOD_CASH) {
            $invoice = $order->invoice;
            if (!is_null($invoice->discount)) {
                $invoice->update(["paid_amount" => $invoice->discount + $invoice->delivery_fees]);
            } else {
                $invoice->update(["paid_amount" => $invoice->total_amount + $invoice->delivery_fees]);
            }
            // $invoice->update(["paid_amount" => $order->invoice->total_amount]);
        }

        $amount = $order->invoice->promo_id ? $order->invoice->discount : $order->invoice->total_amount;
        $this->loyality->addUserPoints($order->customer, $amount, $order->id);
        $this->loyality->updateUserSpending($order->customer, $amount);


        if ($order->referal && config('constants.refer_points')) {
            $referer = User::where('referal', $order->referal)->first();
            $point = [
                "total_points" => config('constants.refer_points'),
                "remaining_points" => config('constants.refer_points'),
                "amount_spent" => 0,
                "expiration_date" => $this->loyality->nextExpirationDate(),
                "activation_date" => now(),
                "order_id" => $order->id,
                "referer_id" => $referer->id
            ];

            $referer->points()->create($point);
            $order->customer->points()->create($point);
            $order->customer->update(['refered' => $referer->referal]);
        }

        $this->pushService->notify($order->customer, __('notifications.completedOrderTitle', ['orderId' => $order->id]), __('notifications.completedOrderBody'), null, $this->customerOrderTrans->transform($om->getOrder()));
        return $this->jsonResponse("Success", $this->orderTrans->transform($om->getOrder()->load("customer")));
    }

    public function prepareOrder($id)
    {
        $order = $this->ordersRepo->getOrderById($id);
        $om = new OrderManager($order);

        $om->changeState(OrderState::PREPARED, \Auth::user());
        $this->pushService->notify($order->customer, __('notifications.preparedOrderTitle', ['orderId' => $order->id]), __('notifications.preparedOrderBody'));
        return $this->jsonResponse("Success", $this->orderTrans->transform($om->getOrder()->load("customer")));
    }

    public function deliverOrder($id)
    {
        $order = $this->ordersRepo->getOrderById($id);
        $om = new OrderManager($order);

        $om->changeState(OrderState::ONDELIVERY, Auth()->user());
        $this->pushService->notify($order->customer, __('notifications.deliveryOrderTitle', ['orderId' => $order->id]), __('notifications.deliveryOrderBody'));
        return $this->jsonResponse("Success", $this->orderTrans->transform($om->getOrder()->load("customer")));
    }

    public function removeItems(Request $request, $id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        // validate request
        $validator = Validator::make($request->all(), [
            "item_ids" => "required|array"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        // remove item policy
        $order->items()->whereIn("id", $request->item_ids)->delete();

        $total = $order->getTotal();
        $invoice = $order->invoice;

        $invoice->total_amount = $total;
        if ($invoice->promo) {
            $promo = $invoice->promo;
            $discount = PromoCalculator::calculate($promo, $total);
            $invoice->discount = $invoice->total_amount - $discount;
        }


        if ($order->payment_method == PaymentMethods::VISA && $invoice->discount) {
            $invoice->remaining = $invoice->paid_amount - $invoice->discount;
        } elseif ($order->payment_method == PaymentMethods::VISA) {
            $invoice->remaining = $invoice->paid_amount - $invoice->total_amount;
        }

        $invoice->save();

        return $this->jsonResponse("Success", $order->items->load("product"));
    }

    public function addItems(Request $request, $id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        // validate request
        $validator = Validator::make($request->all(), [
            "items" => "required|array",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        // add items
        $om = new OrderManager($order);
        $om->addItems($request->items);

        $order = $om->getOrder();

        $total = $order->getTotal();
        $invoice = $order->invoice;

        $invoice->total_amount = $total;
        if ($invoice->promo) {
            $promo = $invoice->promo;
            $discount = PromoCalculator::calculate($promo, $total);
            $invoice->discount = $invoice->total_amount - $discount;
        }


        if ($order->payment_method == PaymentMethods::VISA && ($invoice->discount > 0)) {
            $invoice->remaining = $invoice->paid_amount - $invoice->discount;
        } elseif ($order->payment_method == PaymentMethods::VISA) {
            $invoice->remaining = $invoice->paid_amount - $invoice->total_amount;
        }

        $invoice->save();


        return $this->jsonResponse("Success", $om->getOrder()->items->load("product"));
    }

    public function getAvailableDeliverers($id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        // get order area
        $area = $order->getArea();

        $deliverers = $this->delivererRepo->getAllDeliverers();

        // if ($order->deliverer_id) {
        //     $deliverers = $deliverers->filter(function ($item) use ($order)
        //     {
        //         return $item->id !== $order->deliverer_id;
        //     });
        // }

        return $this->jsonResponse("Success", $deliverers->load("delivererProfile.city", "delivererProfile.area", "delivererProfile.districts"));
    }

    public function show($id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        return $this->jsonResponse("Success", $this->detailsTransformer->transform($order));
    }

    public function createShipment($id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        return $this->jsonResponse("Success", $this->detailsTransformer->transform($order));
    }

    public function createPickup($id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        return $this->jsonResponse("Success", $this->detailsTransformer->transform($order));
    }

    public function updatePaidAmount(Request $request, $id)
    {
        $order = $this->ordersRepo->getOrderById($id);

        $validator = Validator::make($request->all(), [
            "paid_amount" => "required"
        ]);

        $invoice = $order->invoice;
        $invoice->update(["cost_amount" => $request->paid_amount]);

        return $this->jsonResponse("Success", $order->load("customer", "invoice"));
    }

    public function updateItemPrice(Request $request, $order_id, $id)
    {
        $order = $this->ordersRepo->getOrderById($order_id);

        $item = $order->items()->where("product_id", $id)->firstOrFail();


        if ($item->price < $request->discount_price) {
            return $this->errorResponse("Can't apply discount because price less than discount", "invalid data");
        }

        //To set price zero
        $item->update(["discount_price" => $request->get('discount_price')]);

        // if($request->has('discount_price') && $request->get('discount_price') > 0){
        //     $item->update(["discount_price" => $request->discount_price]);
        // }else{
        //     $item->update(["discount_price" => null]);
        // }

        $order->load("items");
        $total = $order->getTotal();

        $order->invoice->update(["total_amount" => $total]);

        if ($request->notify_customer && !app()->environment('local')) {
            Notification::send($order->customer, new OrderEdited($order));
        }

        return $this->jsonResponse("Success");
    }

    public function updateInvoiceDiscount(Request $request, $order_id)
    {
        $order = $this->ordersRepo->getOrderById($order_id);

        $validator = Validator::make($request->all(), [
            "discount" => "required"
        ]);

        $invoice = $order->invoice;

        if ($invoice->total_amount < $request->discount) {
            return $this->errorResponse("Can't apply discount because price less than discount", "invalid data");
        }
        if($request->discount > 0){
            $invoice->update(["discount" => $invoice->total_amount - $request->discount]);
        }else{
            $invoice->update(["discount" => $request->discount]);
        }

        if ($request->notify_customer && !app()->environment('local')) {
            Notification::send($order->customer, new OrderEdited($order));
        }

        return $this->jsonResponse("Success");
    }

    /**
     * Export orders to excel
     *
     * @return void
     */
    public function export()
    {
        $fileName = 'Order_by_' . auth()->user()->name . '_' . date("Y_m_d H_i_s") . '.xlsx';
        $filePath = 'public/exports/orders/' . $fileName;
        Excel::store(new OrdersExport, $filePath);
        $fileUrl = url("storage/exports/orders") ."/". $fileName;
        Log::channel('exports')->info('Action: Export Order, File link: ' . url($filePath) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->user()->id);
        return $this->jsonResponse("Success");
    }

    public function calculateAmountSpentPerCategory(Order $order)
    {
        $data = [];
        foreach($order->items as $item)
        {
            if (isset($data[$item->product->category_id])) {
                $data[$item->product->category_id] += $item->product->price * $item->amount;
            } else {
                $data[$item->product->category_id] = $item->product->price * $item->amount;
            }
        }

        return $data;
    }

    private function calculateTotalPointsPerCategory(array $amountsPerCategory)
    {
        $data = [];
        foreach($amountsPerCategory as $categoryId => $amountSpent)
        {
            $category = Category::find($categoryId);
            $categoryRatePts = $category->ex_rate_pts ?? null;
            $categoryRateEgp = $category->ex_rate_egp ?? null;
            if ($categoryRatePts && $categoryRateEgp) {
                $data[$categoryId] = (floatval($amountSpent) * intval($categoryRatePts)) / $categoryRateEgp;
            }
        }

        return $data;
    }
}
