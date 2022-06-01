<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "address" => $this->address ? $this->address->load("city", "area") : null,
            "images" => $this->images->pluck('url'),
            "name" => $this->name,
            "note" => $this->note,
            "user" => $this->user,
            "invoice_id" => $this->invoice_id,
            "amount" => $this->amount,
            "comment" => $this->comment,
            "cancellation_id" => $this->cancellation_id,
            "cancellation_reason" => $this->CancellationReason,
            "cancellation_text" => $this->cancellation_text,
            "status" => $this->status,
            "admin" => $this->admin,
            "assigned_at" => optional($this->assigned_at)->toDateTimeString(),
            "created_at" => optional($this->created_at)->toDateTimeString()
        ];
    }
}
