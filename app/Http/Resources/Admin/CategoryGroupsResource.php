<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryGroupsResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "name_en" => $this->name_en,
            "name_ar" => $this->name_ar,
            "description_ar" => $this->description_ar,
            "description_en" => $this->description_en,
            "image" => $this->image,
            "active" => $this->active,
            "order" => $this->order,
            "category_id" => isset($this->sub_categories[0]->parent->id) ? $this->sub_categories[0]->parent->id : '',
            "sub_categories" => $this->sub_categories,
            "created_at" => $this->created_at->format('Y-m-d H:i:s'),
            "updated_at" => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
