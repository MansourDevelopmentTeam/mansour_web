<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->getName($request->header('lang')),
            "name_en" => $this->name,
            "image" => $this->image,
            "is_online" => (boolean)$this->is_online,
            "active" => (boolean)$this->active,
            "deactivation_notes" => $this->deactivation_notes,
        ];
    }
}
