<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerSimpleResource extends JsonResource
{
    public function toArray($request)
    {

        $address = $this->addresses->first();
        $area = "";
        if($address && $address->area) {
            $area = $address->area->name;
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            'full_name' => $this->full_name,
            "phone" => $this->phone,
            "address" => $area,
            "orders" => $this->orders->count(),
            "active" => $this->active
        ];
    }
}
