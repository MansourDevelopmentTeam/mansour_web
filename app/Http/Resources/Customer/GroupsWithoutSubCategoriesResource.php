<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupsWithoutSubCategoriesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->getName($request->header('lang')),
            "description" => $this->getDescription($request->header('lang')),
            "image" => $this->image,
            "order" => $this->order,
        ];
    }
}
