<?php

namespace App\Http\Resources\Admin;

use App\Models\Transformers\OrderTransformer;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPickupResource extends JsonResource
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
            "order" => $this->order->load("customer", "address"),
            "shipping_id" => $this->shipping_id,
            "foreign_hawb" => $this->foreign_hawb,
            "shipment_url" => $this->shipment_url,
            "update_description" => $this->update_description,
            "tracking_result" => $this->tracking_result,
            "id" => $this->id
        ];
    }
}
