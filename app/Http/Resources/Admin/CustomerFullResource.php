<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerFullResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "birthdate" => $this->birthdate,
            "orders" => $this->orders->load("products"),
            "active" => $this->active,
            "deactivation_notes" => $this->deactivation_notes,
            "addresses" => $this->addresses->load("area", "city")
        ];
    }
}
