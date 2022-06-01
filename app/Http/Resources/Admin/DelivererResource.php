<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DelivererResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "token" => $this->token,
            "image" => $this->delivererProfile->image,
            "status" => $this->delivererProfile->status
        ];
    }
}
