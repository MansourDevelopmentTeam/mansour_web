<?php

namespace App\Http\Resources\Customer\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupLinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"             => $this->id,
            "link"           => $this->link,
            "name"           => $this->name_en,
            "name_en"        => $this->name_en,
            "name_ar"        => $this->name_ar,
            "image"          => null,
            "order"          => $this->order,
            "level3" => SubCategoryLinkResource::collection($this->subcategories)
        ];
    }
}
