<?php

namespace App\Http\Resources\Admin;

use App\Models\Transformers\CustomerFullTransformer;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "order_details" => $this->order_details,
            "customer" => $this->customer,
            "order" => $this->order,
            "order_pay_id" => $this->payment_transaction,
            "card_info" => $this->card_info,
            "transaction_response" => $this->transaction_response,
            "transaction_status" => $this->status_label,
            "total_amount" => $this->total_amount / 100 ,
            "customer_id" => $this->customer_id,
            "payment_method" => new PaymentMethodsResource($this->paymentMethod),
            "created_at" => (string)$this->created_at,
        ];
    }
}
