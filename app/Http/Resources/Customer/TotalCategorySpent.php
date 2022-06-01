<?php

namespace App\Http\Resources\Customer;

use App\Models\Shipping\DeliveryFees;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Configuration;

class TotalCategorySpent extends JsonResource
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
            "category" => new CategoryResource($this->category),
            "spent" => $this->total_spent
        ];
    }
}
