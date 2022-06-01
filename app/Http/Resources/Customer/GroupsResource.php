<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupsResource extends JsonResource
{
    public function toArray($request)
    {
        $categoryName = isset($this->category[0]) ?  $this->category[0]->getName($request->header('lang')) .' > ': '';
        return [
            "id" => $this->id,
            "name" => $categoryName.  $this->getName($request->header('lang')),
            "description" => $this->getDescription($request->header('lang')),
            "image" => $this->image,
            "order" => $this->order,
            "sub_categories" =>  CategoryResource::collection($this->active_sub_categories)
        ];
    }
}
