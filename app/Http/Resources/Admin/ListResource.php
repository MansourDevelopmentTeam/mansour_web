<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
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
            'id'             => $this->id,
            'name_en'        => $this->name_en,
            'name_ar'        => $this->name_ar,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'type'           => $this->type,
            'products_count' => $this->products_count,
            'active'         => $this->active,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'products'       => $this->whenLoaded('products'),

            // Deprecated
            'image_en'       => '',
            'image_ar'       => '',
            'list_method'    => 0,
            'condition_type' => 0,

        ];
    }
}
