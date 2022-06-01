<?php

namespace App\Http\Resources\Admin;

use App\Models\Payment\PaymentMethod;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\CustomerSimpleResource;
use App\Http\Resources\Admin\PaymentMethodsResource;
use Illuminate\Support\Facades\DB;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        $user = [
            "id" => $this->user_id,
            "full_name" => $this->customer->full_name,
            "name" => $this->customer->full_name,
            "phone" => $this->customer->phone,
            "email" => $this->customer->email
        ];
        $mansourOrder = DB::connection('sqlsrv')->table('dbo.Orders')->where('Order_id', $this->id)->first();

        return [
            "id" => $this->id,
            "user" => $user,//$this->customer ? new CustomerSimpleResource($this->customer): null,
            "is_guest_checkout" => (boolean) $this->user_id,
            "notes" => $this->notes,
            "affiliate" => $this->affiliate,
            "by_affiliate" => $this->byAffiliate(),
            "admin_notes" => $this->admin_notes,
            "state_id" => $this->state_id,
            "state" => $this->state,
            "sub_state" => $this->sub_state,
            "sub_state_id" => $this->sub_state_id,
            "paid_amount" => $this->invoice->paid_amount,
            "amount" => !is_null($this->invoice->discount) ?$this->invoice->discount: $this->invoice->total_amount,
            "delivery_fees" => $this->invoice->delivery_fees,
            "remaining" => $this->invoice->remaining ?: 0,
            "payment_method" => $this->payment_method,
            "payment_method_object" => new PaymentMethodsResource(PaymentMethod::find($this->payment_method)),
            "created_at" => (string)$this->created_at,
            "scheduled_at" => (string)$this->scheduled_at,
            "address" => $this->address,
            "items" => OrderItemResource::collection($this->items),
            "schedule" => $this->schedule ? $this->schedule->load("days") : null,
            "parent_id" => $this->parent_id,
            "transaction_id" => $this->transaction->payment_transaction ?? null,
            "reorder_count" => $this->reorders()->count(),
            "user_agent" => $this->user_agent,
            'tax' => $mansourOrder ? $mansourOrder->Tax : 0
        ];
    }
}
