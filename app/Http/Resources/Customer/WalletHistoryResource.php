<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "affiliate_id" => $this->affiliate_id,
            "affiliate" => $this->affiliate,
            "order_id" => $this->order_id,
            "order" => $this->order,
            "amount" =>$this->amount,
            "due_date" => $this->due_date,
            "payment_method" => $this->payment_method,
            "phone_number" => $this->phone_number,
            "bank_name" => $this->bank_name,
            "account_name" => $this->account_name,
            "account_number" => $this->account_number,
            "iban" => $this->iban,
            "type" => $this->type,
            "status" => $this->validatedStatus(),
            "rejection_reason" => $this->rejection_reason,
            "admin_comment" => $this->admin_comment,
            "created_at" => (string)$this->created_at
        ];
    }
}
