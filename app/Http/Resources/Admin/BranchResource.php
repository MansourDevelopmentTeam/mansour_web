<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $branches = getBranchTypes();
        return [
            "id" => $this->id,
            "shop_name" => $this->shop_name,
            "shop_name_ar" => $this->shop_name_ar,
            "address" => $this->address,
            "address_ar" => $this->address_ar,
            "area" => $this->area,
            "area_ar" => $this->area_ar,
            "lat" => $this->lat,
            "lng" => $this->lng,
            "phone" => $this->phone,
            "images" => $this->images,
            "email" => $this->email,
            "type" => $this->type,
            "order" => $this->order,
            "direction_link" => $this->direction_link,
            "type_en" => isset($branches[$this->type][1]) ? $branches[$this->type][1] : $this->type,
            "type_ar" => isset($branches[$this->type][0]) ? $branches[$this->type][0] : $this->type,
            "created_at" => optional($this->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
