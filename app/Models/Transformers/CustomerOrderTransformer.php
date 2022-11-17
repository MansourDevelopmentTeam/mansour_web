<?php

namespace App\Models\Transformers;

use Illuminate\Http\Request;
use App\Models\Payment\PaymentMethod;
use App\Http\Resources\Customer\PaymentMethodsResource;
use App\Http\Resources\Customer\PaymentInstallmentResource;
use Illuminate\Support\Facades\DB;


/**
 *
 */
class CustomerOrderTransformer extends Transformer
{
    private $itemTrans;
    private $request;

    public function __construct(CustomerItemTransformer $itemTrans, Request $request)
    {
        $this->itemTrans = $itemTrans;
        $this->request = $request;
    }


    function transform($order)
    {
        $cancelReasonLang = $this->request->header('lang') == 2 ? 'text_ar' : 'text';

        $installment = [];
        if (in_array($order->payment_method, [PaymentMethod::METHOD_VALU, PaymentMethod::METHOD_PREMIUM])) {
            $itemsPrices = $order->items->reduce(function ($carry, $item) {
                if (is_null($item->discount_price)) {
                    return $carry + $item->price;
                } else {
                    return $carry + $item->discount_price;
                }
            }, 0);

            $installment = [
                "down_payment"              => $order->invoice->total_amount,
                "total_before_down_payment" => $itemsPrices,
                "installment_message"       => $order->transaction->transaction_response['data_message'] ?? null
            ];
        }

        $user = [
            "id" => $order->user_id,
            "full_name" => $order->customer->full_name ?? $order->address->customer_full_name,
            "name" => $order->customer->full_name ?? $order->address->customer_full_name,
            "phone" => $order->customer->phone ?? $order->address->phone,
        ];
        $mansourOrder = DB::connection('sqlsrv')->table('dbo.test_Orders')->where('Order_id', $order->id)->first();

        return [
            "id"                    => $order->id,
            "user"                  => $user,
            "date"                  => (string)$order->created_at,
            "payment_method"        => $order->payment_method,
            "by_affiliate"          => $order->byAffiliate(),
            "user_agent"            => $order->user_agent,
            "state_id"              => $order->state_id,
            "phone"                 => $order->phone,
            "state"                 => $order->state ? $this->getState($order->state, $this->request->header("lang")) : null,
            "cancellation_id"       => $order->cancellation_id,
            "cancellation_reason"   => $order->CancellationReason,
            "cancellation_text"     => $order->cancellation_text ?? optional($order->CancellationReason)->{$cancelReasonLang},
            "items"                 => $this->itemTrans->transformCollection($order->items),
            "states"                => $order->getStates($this->request->header("lang")),
            "rate"                  => $order->rate,
            "address"               => $order->address,
            "notes"                 => $order->notes,
            "installment"           => $installment,
            "total"                 => ((!is_null($order->invoice->discount) ? $order->invoice->discount : $order->getTotal()) + $order->invoice->delivery_fees),
            "item_total"            => $order->getTotal(),
            "delivery_fees"         => $order->invoice->delivery_fees,
            "discount"              => (!is_null($order->invoice->discount) ? $order->invoice->total_amount - $order->invoice->discount : 0),
            "active"                => $order->isActive(),
            "scheduled_at"          => $order->scheduled_at,
            "schedule"              => $order->schedule ? $this->transformSchedule($order->schedule->load("days")) : null,
            "reorder_count"         => $order->reorders()->count(),
            "feedback"              => $order->feedback,
            "shipped_data"          => isset($order->order_pickup) ? "https://www.aramex.com/us/en/track/results?mode=0&ShipmentNumber=" . $order->order_pickup->shipping_id : null,
            "fawry_ref"             => $order->fawry_ref,
            "total_delivery_fees"   => $order->invoice->total_delivery_fees,
            "free_delivery"         => (boolean)$order->invoice->free_delivery,
            "deliverer"             => $order->deliverer ? $order->deliverer->load("delivererProfile") : null,
            "transaction_id"        => $order->transaction_id,
            "payment_method_object" => new PaymentMethodsResource(PaymentMethod::find($order->payment_method)),
            "payment_installment_plan" => $order->payment_installment_id ? new PaymentInstallmentResource($order->paymentInstallment) : null,
            "affiliate_total_amount"=> (double)$order->affiliateTotalAmount(),
            'tax' => $mansourOrder ? $mansourOrder->Tax : null,
            'total_cashback' => $order->cashback_amount,
            'wallet_redeem' => $order->wallet_redeem,
            'total_incentive' => $mansourOrder ? $mansourOrder->Total_Incentives : 0,
        ];
    }

    private function transformSchedule($schedule)
    {
        return [
            "id"       => $schedule->id,
            "interval" => $schedule->interval,
            "time"     => $schedule->time,
            "days"     => $this->transformDays($schedule->days)
        ];
    }

    private function transformDays($days)
    {
        return array_map(function ($item) {
            return $item["day"];
        }, $days->toArray());
    }

    public function getState($state, $lang)
    {
        return [
            "id"      => $state->id,
            // "name" => $state->getName($lang),
            "name"    => $state->name,
            "name_ar" => $state->name_ar,
        ];
    }
}
