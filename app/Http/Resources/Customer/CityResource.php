<?php

namespace App\Http\Resources\Customer;

use App\Models\Shipping\DeliveryFees;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->getName($request->header('lang')),
            "name_ar" => $this->name_ar,
            "areas" => AreaResource::collection($this->areas),
            "active" => $this->active,
            "fees_type" => $this->delivery_fees_type,
            "delivery_fees" => $this->delivery_fees,
            "fees_range" => DeliveryFees::getFeesData('city', $this->id),
        ];
    }
}
