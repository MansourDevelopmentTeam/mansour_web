<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    private function resourceSchedule($schedule)
    {
        return [
            "id" => $schedule->id,
            "interval" => $schedule->interval,
            "time" => $schedule->time,
            "days" => $this->resourceDays($schedule->days)
        ];
    }

    private function resourceDays($days)
    {
        return array_map(function ($item) {
            return $item["day"];
        }, $days->toArray());
    }
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user" => $this->customer,
            "notes" => $this->notes,
            "state_id" => $this->state_id,
            "sub_state_id" => $this->sub_state_id,
            "invoice" => $this->invoice,
            "paid_amount" => $this->invoice->paid_amount,
            "amount" => (!is_null($this->invoice->discount) ? $this->invoice->discount : $this->invoice->total_amount),
            "actual_amount" => $this->invoice->total_amount,
            "delivery_fees" => $this->invoice->delivery_fees,
            "discount_amount" => $this->invoice->discount,
            "remaining" => $this->invoice->remaining ?: 0,
            "payment_method" => $this->payment_method,
            "created_at" => (string)$this->created_at,
            "scheduled_at" => (string)$this->scheduled_at,
            "address" => $this->address,
            "items" =>OrderItemResource::collection($this->items),
//            "items" => $this->items->load("product"),
            "history" => $this->history,
            "rate" => $this->rate,
            "deliverer" => $this->deliverer ? $this->deliverer->load("delivererProfile") : null,
            "promo" => $this->invoice->promo,
            "updated_at" => (string)$this->updated_at,
            "feedback" => $this->feedback,
            "schedule" => $this->schedule ? $this->resourceSchedule($this->schedule->load("days")) : null,
            "parent_id" => $this->parent_id,
            "reorder_count" => $this->reorders()->count(),
        ];
    }
}
