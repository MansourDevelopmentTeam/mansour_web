<?php

namespace App\Http\Controllers\Delivery;


use App\Mail\OrderCreated;
use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Models\Orders\OrderState;
use App\Models\Orders\OrderManager;
use App\Http\Controllers\Controller;
use App\Models\Services\PushService;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment\PaymentMethod;
use App\Models\Payment\PaymentMethods;
use App\Models\Services\LoyalityService;
use Illuminate\Support\Facades\Validator;
use App\Models\Repositories\OrderRepository;
use App\Models\Transformers\OrderTransformer;
use App\Models\Transformers\CustomerOrderTransformer;

class OrdersController extends Controller
{
	private $orderRepo;
	private $orderTrans;
    private $pushService;
    private $customerOrderTrans;
    private $loyality;

	public function __construct(OrderRepository $orderRepo, OrderTransformer $orderTrans, PushService $pushService, CustomerOrderTransformer $customerOrderTrans, LoyalityService $loyality)
	{
		$this->orderRepo = $orderRepo;
		$this->orderTrans = $orderTrans;
        $this->pushService = $pushService;
        $this->customerOrderTrans = $customerOrderTrans;
        $this->loyality = $loyality;
	}


    public function index()
    {
    	$orders = $this->orderRepo->getDelivererActiveOrders(\Auth::user());

    	return $this->jsonResponse("Success", $this->orderTrans->transformCollection($orders));
    }

    public function finishOrder(Request $request, $id)
    {
    	$user = \Auth::user();
    	$order = $user->deliveries()->findOrFail($id);

    	// validate request
    	$validator = Validator::make($request->all(), [
    		"state_id" => "required|in:5,8",
    		"missing_items" => "array|required_if:state_id,5",
            "paid_amount" => "required_if:state_id,8"
    	]);



        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        if($request->state_id == 5) {
            $order_items = $order->items()->whereIn("id", $request->missing_items)->get();
            if($order_items->count() != count($request->missing_items)) {
                return $this->errorResponse("invalid items ids", "Invalid data", $validator->errors(), 422);
            }
        }

        $om = new OrderManager($order);

    	if($request->state_id == OrderState::PREPARED) {
            $this->pushService->notifyAdmins("Order Prepared", "Order ID {$order->id} is now prepared");
            $om->prepareOrder($user, $request->paid_amount);
        }else{
            $this->pushService->notifyAdmins("Order Investigating", "Order ID {$order->id} is now investigating");
            $om->updateItemList($request->missing_items, $user);
        }

    	return $this->jsonResponse("Success", $this->orderTrans->transform($om->getOrder()));
    }

    public function rateCustomer(Request $request, $id)
    {
        $user = \Auth::user();
        $order = $user->deliveries()->findOrFail($id);

    	// validate request
    	$validator = Validator::make($request->all(), [
    		"rate" => "required|integer|in:1,2,3,4,5",
    	]);

    	if ($validator->fails()) {
    	    return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
    	}

    	$om = new OrderManager($order);

        if ($order->payment_method == PaymentMethod::METHOD_CASH) {
            $invoice = $order->invoice;
            if (!is_null($invoice->discount)) {
                $invoice->update(["paid_amount" => $invoice->discount + $invoice->delivery_fees]);
            } else {
                $invoice->update(["paid_amount" => $invoice->total_amount + $invoice->delivery_fees]);
            }
            // $invoice->update(["paid_amount" => $order->invoice->total_amount]);
        }

        $om->closeOrder($request->rate);

        $amount = $order->invoice->promo_id ? $order->invoice->discount : $order->invoice->total_amount;
        $this->loyality->addUserPoints($order->customer, $amount, $order->id);
        $this->loyality->updateUserSpending($order->customer, $amount);

        
        if ($order->referal && config('constants.refer_points')) {
            $referer = User::where('referal', $order->referal)->first();
            $point = [
                "total_points" => config('constants.refer_points'),
                "remaining_points" => config('constants.refer_points'),
                "amount_spent" => $order->getTotal(),
                "expiration_date" => $this->loyality->nextExpirationDate(),
                "activation_date" => now(),
                "order_id" => $order->id
            ];

            $referer->points()->create($point);
            $order->customer->points()->create($point);
            $order->customer->update(['refered' => $referer->referal]);
        }

        // push to customer
        $this->pushService->notify($order->customer, __('notifications.completedOrderTitle', ['orderId' => $order->id]), __('notifications.completedOrderBody'), null, $this->customerOrderTrans->transform($om->getOrder()));
        $this->pushService->notifyAdmins("Order Completed", "Order ID {$order->id} is now completed");
        Mail::to($order->customer)->send(new OrderCreated($order));



        return $this->jsonResponse("Success", $this->orderTrans->transform($om->getOrder()));
    }

    public function history()
    {
        $user = \Auth::user();

        $orders = $this->orderRepo->getDelivererOrdersHistory($user);

        $orders = $orders->groupBy(function ($item)
        {
            return $item->created_at->format("Y-m-d");
        });
        // dd($user);
        $ordersArray = [];
        $ind = 0;
        foreach ($orders as $key => $order) {
            $ordersArray[$ind]["date"] = $key;
            $ordersArray[$ind]["orders"] = $this->orderTrans->transformCollection($order);
            $ind++;
        }

    	return $this->jsonResponse("Success", ["orders" => $ordersArray, "rating" => $user->rating]);
    }
}
