<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DelivererFullResource extends JsonResource
{

    public function getProfile($profile)
    {
        return [
            "image" => $profile->image,
            "status" => $profile->status,
            "city" => $profile->city,
            "area" => $profile->area,
            "districts" => $profile->districts,
            "unique_id" => $profile->unique_id
        ];
    }
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "delivererProfile" => $this->getProfile($this->delivererProfile),
            "rating" => $this->rating,
            "numberOfRates" => $this->getNumberOfRates(),
            "active" => $this->active,
            "numberOfOrders" => $this->deliveries->count(),
            "deactivation_notes" => $this->deactivation_notes,
            "birthdate" => $this->birthdate,
            "address" => $this->addresses()->first() ? $this->addresses()->first()->address : null,
            "orders" => $this->deliveries,
            "created_at" => (string)$this->created_at
        ];
    }
}
