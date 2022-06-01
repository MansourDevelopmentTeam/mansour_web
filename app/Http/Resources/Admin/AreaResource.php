<?php

namespace App\Http\Resources\Admin;

use App\Models\Shipping\DeliveryFees;
use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            "name" => $this->getName($request->header('lang')),
            "name_ar" => $this->name_ar,
            "city_id" => $this->city_id,
            "active" => $this->active,
            "deactivation_notes" => (string) $this->deactivation_notes,
            "fees_type" => $this->delivery_fees_type,
            "delivery_fees" => $this->delivery_fees,
            "fees_range" => DeliveryFees::getFeesData('area', $this->id),
            "aramex_area_name" => $this->aramex_area_name,
            "city" => $this->city,
            "districts" => DistrictResource::collection($this->districts),
        ];
    }
}
