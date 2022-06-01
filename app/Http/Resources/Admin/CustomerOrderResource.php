<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerOrderResource extends JsonResource
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
            "date" => (string)$this->created_at,
            "payment_method" => $this->payment_method,
            "state_id" => $this->state_id,
            "items" => CustomerItemResource::collection($this->items),
            "states" => $this->getStates($this->request->header("lang")),
            "rate" => $this->rate,
            "address" => $this->address,
            "notes" => $this->notes,
            "total" => ((!is_null($this->invoice->discount) ? $this->invoice->discount : $this->invoice->total_amount) + $this->invoice->delivery_fees),
            "item_total" => $this->invoice->total_amount,
            "delivery_fees" => $this->invoice->delivery_fees,
            "discount" => (!is_null($this->invoice->discount) ? $this->invoice->total_amount - $this->invoice->discount : 0),
            "active" => $this->isActive(),
            "scheduled_at" => $this->scheduled_at,
            "schedule" => $this->schedule ? $this->resourceSchedule($this->schedule->load("days")) : null,
            "reorder_count" => $this->reorders()->count(),
            "feedback" => $this->feedback,
            'full_name' => $this->full_name,
            "fawry_ref" => $this->fawry_ref
        ];
    }
}
