<?php

namespace App\Models\Orders;

use App\Facade\Sms;
use Octw\Aramex\Aramex;

use App\Models\Users\User;
use App\Models\Orders\Order;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Log;
use App\Models\Services\PushService;
use App\Models\Shipping\OrderPickup;
use App\Models\Payment\PaymentMethod;
use App\Models\Payment\PaymentMethods;
use App\Models\Services\LoyalityService;
use App\Models\Transformers\CustomerOrderTransformer;

/**
 *
 */
class OrderManager
{

    private $order;

    function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function assignDeliverer(User $deliverer, User $user)
    {
        // check if a deliverer can be assigned
        // if(!OrderAssignmentPolicy::canAssign($this->order)) {
        // 	throw new \Exception("This Order is Unassignable", 1);
        // }

        $this->order->deliverer_id = $deliverer->id;
        $this->order->save();

        // $this->changeState(OrderState::PROCESSING, $user);
    }

    public function changeState($state, $user, $subtract_stock = false)
    {
        if ($state == OrderState::CANCELLED) {
            $request = request();
            $this->order->update([
                'cancellation_id' => $request->cancellation_id,
                'cancellation_text' => $request->cancellation_text
            ]);

            $customer = $this->order->customer;
            $hasUncancelledOrders = $customer->orders()->where("state_id", "!=", OrderState::CANCELLED)->exists();
            if (!$hasUncancelledOrders) {
                $customer->update(["first_order" => 0]);
            }
            if ($this->order->state_id != $state && $subtract_stock) {
                $this->restockOrder();
            }
            $orderPickup = $this->order->order_pickup;
            if ($orderPickup) {
               $pickup =  $orderPickup->pickup;
               $pickupGuid = $pickup->shipping_guid;
                try {
                    $cancelPickup = Aramex::cancelPickup($pickupGuid, null);
                    $pickup->update(['status' => 3]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }

        if ($state == OrderState::PROCESSING) {
            $this->order->customer->update(["admin_first_order" => 1]);
        }

        if ($state == OrderState::DELIVERED) {
            $this->completeOrder();
        }
        $this->order->state_id = $state;
        $this->order->save();
        $this->logStateHistory($this->order->state_id, $this->order->sub_state_id, $user);
    }

    public function changeSubState($state, $user)
    {
        $this->order->sub_state_id = $state;
        $this->order->save();

        // log history
        $this->logStateHistory($this->order->state_id, $this->order->sub_state_id, $user);
    }

    public function changeStates($state, $sub_state_id, $user, $status_notes = null, $subtract_stock = true)
    {

        // validate policy
        // if(!StatePolicy::validateStateChange($this->order->state_id, $state, $user->getRole()->id)) {
        // 	throw new \Exception("Invalid State Change", 1);
        // }
        // change order state
        if ($state == OrderState::CANCELLED) {
            $request = request();
            // $request->validate([
            //     "cancellation_id" => "required",
            //     "cancellation_text" => "sometimes"
            // ]);
            if(request()->has('cancellation_id')){
                $this->order->update([
                    'cancellation_id' => $request->cancellation_id,
                    'cancellation_text' => $request->cancellation_text
                ]);
            }

            $customer = $this->order->customer;
            $hasUncancelledOrders = $customer->orders()->where("state_id", "!=", OrderState::CANCELLED)->exists();
            if (!$hasUncancelledOrders) {
                $customer->update(["first_order" => 0]);
            }
            if ($this->order->state_id != $state && $subtract_stock == "true") {
                $customer->update(["first_order" => 0]);
                $this->restockOrder();
                // foreach ($this->order->items as $item) {
                //     $product = Product::where('id', $item['product_id'])->first();
                //     $productStocks = $product->stock;
                //     $product->update(['stock' => $item['amount'] + $productStocks]);
                // }
            }
            if ($state == OrderState::RETURNED) {
                if ($this->order->state_id != $state) {
                    foreach ($this->order->items as $item) {
                        $product = Product::where('id', $item['product_id'])->first();
                        $productStocks = $product->stock;
                        $product->update(['stock' => $item['amount'] + $productStocks]);
                    }
                }
                $this->order->customer->update(["admin_first_order" => 1]);
            }
        }

        if ($state == OrderState::PROCESSING) {
            $this->order->customer->update(["admin_first_order" => 1]);
        }
        $this->order->state_id = $state;
        $this->order->sub_state_id = $sub_state_id;
        $this->order->save();
        // log history
        $this->logStateHistory($this->order->state_id, $this->order->sub_state_id, $user, $status_notes);
        // notify
    }

    public function logStateHistory($state_id, $sub_state_id, $user, $status_notes = null)
    {
        $this->order->history()->create([
            "status_notes" => $status_notes,
            "state_id" => $state_id,
            "sub_state_id" => $sub_state_id,
            "user_id" => $user->id
        ]);
    }

    public function prepareOrder($user, $paid_amount)
    {
        $invoice = $this->order->invoice;
        $invoice->update(["cost_amount" => $paid_amount]);

        $this->changeState(OrderState::PREPARED, $user);
    }

    public function closeOrder($rate)
    {
        // change state to delivered
        $this->changeState(OrderState::DELIVERED, $this->order->deliverer);

        // rate customer
        $this->order->customer_rate = $rate;
        $this->order->save();
    }

    public function cancelOrder(User $user, $subtract_stock)
    {
        $this->changeState(OrderState::CANCELLED, $user, $subtract_stock);
    }

    public function returnOrder(User $user)
    {
        $this->changeState(OrderState::RETURNED, $user);
    }

    public function proceedOrder(User $user)
    {
        if ($this->order->items()->where("missing", 1)->get()->count()) {
            throw new \Exception("Cannot proceed order with missing items", 1);
        }

        $this->order->deliverer_id = null;
        $this->order->save();

        $this->changeState(OrderState::PROCESSING, $user);
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function addItems($items)
    {
        foreach ($items as $item) {
            $existing = $this->order->items()->where("product_id", $item["product_id"])->get()->first();
            $product = Product::find($item["product_id"]);

            if ($existing) {
                $existing->amount = $existing->amount + $item["amount"];
                $existing->save();
            } else {
                $item["price_id"] = $product->getCurrentPriceId();
                $this->order->items()->create($item);
            }
        }

        return $this->order->items;
    }

    public function updateItemList($missing_items, $user)
    {
        $this->changeState(OrderState::INVESTIGATION, $user);
        $this->order->items()->whereIn("id", $missing_items)->update(["missing" => 1]);
    }

    public static function setOrdersOnDelivery($orders)
    {
        foreach ($orders as $order) {
            $order->state_id = OrderState::ONDELIVERY;
            $order->save();

            $pushService = new PushService;
            $pushService->notifyAdmins("Order Delivering", "Order {$order->id} is now Delivering");
            $pushService->notify($order->customer, __('notifications.deliveringOrderTitle', ['orderId' => $order->id]), __('notifications.deliveringOrderBody'));

            $order->history()->create([
                "state_id" => OrderState::ONDELIVERY,
                "user_id" => $order->deliverer_id
            ]);
        }
    }

    public function completeOrder()
    {
        if ($this->order->payment_method == PaymentMethod::METHOD_CASH) {
            $invoice = $this->order->invoice;
            if (!is_null($invoice->discount)) {
                $invoice->update(["paid_amount" => $invoice->discount + $invoice->delivery_fees]);
            } else {
                $invoice->update(["paid_amount" => $invoice->total_amount + $invoice->delivery_fees]);
            }
        }

        $amount = $this->order->invoice->promo_id ? $this->order->invoice->discount : $this->order->invoice->total_amount;
        $loyality = new LoyalityService;
        $loyality->addUserPoints($this->order->customer, $amount, $this->order->id);
        $loyality->updateUserSpending($this->order->customer, $amount);


        if ($this->order->referal && config('constants.refer_points')) {
            $referer = User::where('referal', $this->order->referal)->first();
            $point = [
                "total_points" => config('constants.refer_points'),
                "remaining_points" => config('constants.refer_points'),
                "amount_spent" => 0,
                "expiration_date" => $loyality->nextExpirationDate(),
                "activation_date" => now(),
                "order_id" => $this->order->id,
                "referer_id" => $referer->id
            ];

            $referer->points()->create($point);
            $this->order->customer->points()->create($point);
            $this->order->customer->update(['refered' => $referer->referal]);
        }

        $transformer = app()->make(CustomerOrderTransformer::class);
        $pushService = new PushService;
        $pushService->notify($this->order->customer, __('notifications.completedOrderTitle', ['orderId' => $this->order->id]), __('notifications.completedOrderBody'), null, $transformer->transform($this->order));
    }

    public function restockOrder()
    {
        $items = $this->order->items()->select('*', \DB::raw('IFNULL(bundle_id, UUID()) as unq'))->groupby('unq')->get();
        foreach ($items as $item) {
            if (is_numeric($item->unq)) {
                if ($item->bundleProduct->parent->has_stock) {
                    $product = Product::where('id', $item['bundle_id'])->first();
                    $productStocks = $product->stock;
                    $product->update(['stock' => $item['amount'] + $productStocks]);
                } else {
                    $products = $item->bundleProduct->bundleProduct;
                    foreach ($products as $product) {
                        $productStocks = $product->stock;
                        $product->update(['stock' => $item['amount'] + $productStocks]);
                    }
                }
            } else {
                $product = Product::where('id', $item['product_id'])->first();
                $productStocks = $product->stock;
                $product->update(['stock' => $item['amount'] + $productStocks]);
            }
        }
    }
}
