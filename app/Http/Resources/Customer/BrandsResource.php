<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->getName($request->header('lang')),
            "name_ar" => $this->name_ar,
            "name_en" => $this->name_en,
            "image" => $this->image,
        ];
    }
}
