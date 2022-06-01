<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionImageResource extends JsonResource
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
            "image_en" => $this->image_en,
            "image_ar" => $this->image_ar,
            "link_en" => $this->link_en,
            "section_id" => $this->section_id,
        ];
    }
}
