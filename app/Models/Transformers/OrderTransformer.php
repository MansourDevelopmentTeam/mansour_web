<?php

namespace App\Models\Transformers;

use App\Http\Resources\Admin\ShipmentResource;
use App\Http\Resources\Customer\PaymentInstallmentResource;
use App\Http\Resources\Customer\PaymentMethodsResource;
use App\Models\Payment\PaymentMethod;
use Illuminate\Support\Facades\DB;

class OrderTransformer extends Transformer
{
	private $itemsTrans;

	public function __construct(OrderItemTransformer $itemsTrans)
	{
		$this->itemsTrans = $itemsTrans;
	}

	function transform($order)
	{
        $mansourOrder = DB::connection('sqlsrv')->table('dbo.Orders')->where('Order_id', $order->id)->first();
		return [
			"id" => $order->id,
			"user" => $order->customer,
            "affiliate" => $order->affiliate,
            "by_affiliate" => $order->byAffiliate(),
			"notes" => $order->notes,
            "phone" => $order->phone,
			"admin_notes" => $order->admin_notes,
            "admin_id" => $order->admin_id,
            "admin" => $order->admin,
			"state_id" => $order->state_id,
			"state" => $order->state,
			"sub_state" => $order->sub_state,
            "cancellation_id" => $order->cancellation_id,
            "cancellation_reason" => $order->CancellationReason,
            "cancellation_text" => $order->cancellation_text ?? optional($order->CancellationReason)->text,
            "paid_amount" => $order->invoice->paid_amount,
			"amount" => !is_null($order->invoice->discount) ?$order->invoice->discount: $order->invoice->total_amount,
			"delivery_fees" => $order->invoice->delivery_fees,
			"remaining" => $order->invoice->remaining ?: 0,
			"payment_method" => $order->payment_method,
			"payment_installment_plan" => $order->payment_installment_id ? new PaymentInstallmentResource($order->paymentInstallment) : null,
			"payment_method_object" => new PaymentMethodsResource(PaymentMethod::find($order->payment_method)),
            "user_agent" => $order->user_agent,
            "created_at" => (string)$order->created_at,
			"scheduled_at" => (string)$order->scheduled_at,
			"address" => $order->address ? $order->address->load("district") : null,
			"items" => $this->itemsTrans->transformCollection($order->items),
			"schedule" => $order->schedule ? $order->schedule->load("days") : null,
            "parent_id" => $order->parent_id,
            "reorder_count" => $order->reorders()->count(),
            "is_shipped" => (boolean)$order->order_pickup,
            "affiliate_total_amount" => (double)$order->affiliateTotalAmount(),
            "promotion_discount" => $order->promotion_discount,
            "shipped_data" => isset($order->order_pickup) ?  new ShipmentResource($order->order_pickup) : null,
            'tax' => $mansourOrder ? $mansourOrder->Tax : null,
        ];
	}
}
