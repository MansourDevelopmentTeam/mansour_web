<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RewardsResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->getName($request->header("lang")),
            "name_en" => $this->name,
            "name_ar" => $this->name_ar,
            "description" => $this->getDescription($request->header("lang")),
            "is_gold" => $this->is_gold,
            "point_cost" => $this->point_cost,
            "type" => $this->type,
            "image" => $this->image
        ];
    }
}
