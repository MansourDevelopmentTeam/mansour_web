<?php

namespace App\Models\Transformers;

use App\Models\Payment\PaymentMethod;
use App\Models\Payment\PaymentMethods;
use App\Http\Resources\Admin\ShipmentResource;
use App\Http\Resources\Admin\OrderItemResource;
use App\Models\Transformers\OrderItemTransformer;
use App\Http\Resources\Admin\CustomerOrderResource;
use App\Http\Resources\Admin\CustomerSimpleResource;
use App\Http\Resources\Admin\PaymentMethodsResource;
use App\Http\Resources\Customer\PaymentInstallmentResource;
use Illuminate\Support\Facades\DB;

class OrderDetailsTransformer extends Transformer
{
	private $itemsTrans;

	public function __construct(OrderItemTransformer $itemsTrans)
	{
		$this->itemsTrans = $itemsTrans;
	}


	public function transform($order)
	{
		$installment = [];
		if (in_array($order->payment_method, [
			PaymentMethod::METHOD_VALU,
			PaymentMethod::METHOD_PREMIUM,
			PaymentMethod::METHOD_GET_GO,
			PaymentMethod::METHOD_SHAHRY,
			PaymentMethod::METHOD_SOUHOOLA
			])) {
			$itemsPrices = $order->items->reduce(function ($carry, $item) {
				if (is_null($item->discount_price)) {
					return $carry + $item->price;
				} else {
					return $carry + $item->discount_price;
				}
			}, 0);

			$installment = [
				"down_payment" => $order->invoice->total_amount,
				"total_before_down_payment" => $itemsPrices,
				"installment_message" => $order->transaction->transaction_response['data_message'] ?? null
			];
		}

		if (in_array($order->payment_method, [
			PaymentMethod::METHOD_QNB_INSTALLMENT
			])) {
			$installment = [
				"down_payment" => 0,
				"total_before_down_payment" => 0,
				"installment_message" => "Success"
			];
		}

		$user = [
            "id" => $order->user_id,
            "full_name" => $order->customer->full_name ?? null,
            "name" => $order->customer->full_name ?? null,
            "phone" => $order->customer->phone ?? null,
            "email" => $order->customer->email ?? null,
        ];
        $mansourOrder = DB::connection('sqlsrv')->table('dbo.Orders')->where('Order_id', $order->id)->first();
		return [
			"id" => $order->id,
			"user" => $user,//$order->customer ? new CustomerSimpleResource($order->customer): null,
			"affiliate" => $order->affiliate,
			"by_affiliate" => $order->byAffiliate(),
			"notes" => $order->notes,
			"phone" => $order->phone,
			"admin_notes" => $order->admin_notes,
			"admin_id" => $order->admin_id,
			"admin" => $order->admin,
			"state_id" => $order->state_id,
			"sub_state_id" => $order->sub_state_id,
			"states" => $order->getStates(1),
			"cancellation_id" => $order->cancellation_id,
			"cancellation_reason" => $order->CancellationReason,
			"cancellation_text" => $order->cancellation_text ?? optional($order->CancellationReason)->text,
			"invoice" => $order->invoice,
			"user_agent" => $order->user_agent,
			"paid_amount" => $order->invoice->paid_amount,
			"amount" => (!is_null($order->invoice->discount) ? $order->invoice->discount : $order->invoice->total_amount),
			"actual_amount" => $order->invoice->total_amount,
			"installment" =>  $installment,
			"delivery_fees" => $order->invoice->delivery_fees,
			"discount_amount" => $order->invoice->discount,
			"remaining" => $order->invoice->remaining ?: 0,
			"payment_method" => $order->payment_method,
			"payment_installment_plan" => $order->payment_installment_id ? new PaymentInstallmentResource($order->paymentInstallment) : null,
			"payment_method_object" => new PaymentMethodsResource(PaymentMethod::find($order->payment_method)),
			"created_at" => (string)$order->created_at,
			"scheduled_at" => (string)$order->scheduled_at,
			"address" => $order->address,
			"items" => $this->itemsTrans->transformCollection($order->items->load("product")),
			"history" => $order->history->load("state", "sub_state", "user"),
			"rate" => $order->rate,
			"deliverer" => $order->deliverer ? $order->deliverer->load("delivererProfile") : null,
			"promo" => $order->invoice->promo,
			"updated_at" => (string)$order->updated_at,
			"feedback" => $order->feedback,
			"schedule" => $order->schedule ? $this->transformSchedule($order->schedule->load("days")) : null,
			"parent_id" => $order->parent_id,
			"transaction_id" => $order->transaction->order_pay_id ?? null,
			"order_pay_id" => $order->transaction->order_pay_id ?? null,
			"reorder_count" => $order->reorders()->count(),
			"is_shipped" => (bool)$order->order_pickup,
			"track_order"	=> isset($order->order_pickup) ? "https://www.aramex.com/us/en/track/results?mode=0&ShipmentNumber=" . $order->order_pickup->shipping_id : null,
			"affiliate_total_commission" => (float)$order->affiliateTotalAmount(),
			"total_delivery_fees" => $order->invoice->total_delivery_fees,
			"free_delivery" => (bool)$order->invoice->free_delivery,
			"shipped_data" => isset($order->order_pickup) ?  new ShipmentResource($order->order_pickup) : null,
			"shipments" => ShipmentResource::collection($order->order_pickups),
			'user_ip' => $order->user_ip ?? null,
            "promotion_discount" => $order->promotion_discount,
            'total_incentive' => $mansourOrder ? $mansourOrder->Total_Incentives : 0,
            'total_cashback' => $order->cashback_amount,
            'tax' => $mansourOrder ? $mansourOrder->Tax : null,
            'wallet_redeem' => $order->wallet_redeem
        ];
	}

	private function transformSchedule($schedule)
	{
		return [
			"id" => $schedule->id,
			"interval" => $schedule->interval,
			"time" => $schedule->time,
			"days" => $this->transformDays($schedule->days)
		];
	}

	private function transformDays($days)
	{
		return array_map(function ($item) {
			return $item["day"];
		}, $days->toArray());
	}
}
