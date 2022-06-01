<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PickupResource extends JsonResource
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
            // "orders" => $this->orders,
            "shipping_method" => $this->shipping_method,
            "created_at" => (string)$this->created_at,
            "pickup_date" => (string)$this->pickup_time,
            "order_pickups" => OrderPickupResource::collection($this->order_pickups),
            "notes" => $this->notes
        ];
    }
}
