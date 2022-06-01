<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'id' => $this->id,
            "name_en" => $this->name_en,
            "name_ar"  => $this->name_ar,
            "description_ar"  => $this->description_ar,
            "description_en"  => $this->description_en,
            "type"  => $this->type,
            "order"  => $this->order,
            "active"  => $this->active,
            "list_id"  => $this->list_id,
            "image_type"  => $this->image_type,
            "list" => $this->list,
            "images" => SectionImageResource::collection($this->images),
        ];
    }
}
