<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomAdsResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "name_en" => $this->name_en,
            "name_ar" => $this->name_ar,
            "description_ar" => $this->description_ar,
            "description_en" => $this->description_en,
            "image_en" => $this->image_en,
            "image_ar" => $this->image_ar,
            "type" => $this->type,
            "active" => $this->active,
            "dev_key" => $this->dev_key,
            "item_id" => $this->item_id,
            "item_data" => $this->getItemData(),
        ];
    }
}
