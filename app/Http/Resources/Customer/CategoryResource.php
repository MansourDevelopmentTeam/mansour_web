<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name_en" => $this->name, //$this->getName($request->header('lang')),
            "description_en" => $this->description,
            "description_ar" => $this->description_ar,
            "name" => $this->name, //$this->getName($request->header('lang')),
            "name_en" => $this->name, //$this->getName($request->header('lang')),
            "name_ar" => $this->name_ar, //$this->getName($request->header('lang')),
            "description" => $this->getDescription($request->header('lang')),
            "order" => $this->order,
            "parent_id" => $this->parent_id,
            "image" => $this->image,
            "attributes" => [],
            "sub_categories" =>  CategoryResource::collection($this->subCategories),
            'payment_target' => $this->payment_target
        ];
    }
}
