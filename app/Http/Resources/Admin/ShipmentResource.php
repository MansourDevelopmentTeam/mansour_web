<?php

namespace App\Http\Resources\Admin;

use App\Models\Services\LoyalityService;
use App\Models\Settings\Settings;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "created_at" => (string)$this->created_at,
            "pickup_id" => $this->pickup_id,
            "order_id" => $this->order_id,
            "shipping_method" => $this->shipping_method,
            "shipping_id" => $this->shipping_id,
            "track_order" => $this->shipping_id ? "https://www.aramex.com/us/en/track/results?mode=0&ShipmentNumber=" . $this->shipping_id : null,
            "foreign_hawb" => $this->foreign_hawb,
            "shipment_url" => $this->shipment_url,
            "tracking_result" => $this->tracking_result,
            "update_description" => $this->update_description,
            "status" => $this->status,
            "notes" => optional($this->pickup)->notes,
            "pickup" => $this->pickup,
            "pickup_time" => optional($this->pickup)->pickup_time,
            "pickup_shipping_id" => optional($this->pickup)->shipping_id,
            "pickup_shipping_guid" => optional($this->pickup)->shipping_guid,
        ];
    }
}
