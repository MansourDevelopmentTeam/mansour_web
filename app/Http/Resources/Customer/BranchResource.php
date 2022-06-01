<?php

namespace App\Http\Resources\Customer;

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
        $type = $this->first()->type;
        $branches = getBranchTypes();

        return [
            "type" => $type,
            "name" => isset($branches[$type][1]) ? $branches[$type][1] : $type,
            "name_ar" => isset($branches[$type][0]) ? $branches[$type][0] : $type,
            "sub_branches" => $this->map(function ($branch) {
                return [
                    "id" => $branch->id,
                    "shop_name" => $branch->shop_name,
                    "shop_name_ar" => $branch->shop_name_ar,
                    "address" => $branch->address,
                    "address_ar" => $branch->address_ar,
                    "area" => $branch->area,
                    "area_ar" => $branch->area_ar,
                    "lat" => $branch->lat,
                    "lng" => $branch->lng,
                    "email" => $branch->email,
                    "phone" => $branch->phone,
                    "order" => $branch->order,
                    "direction_link" => $branch->direction_link,
                    "images" => $branch->images,
                ];
            })->sortBy('order')->values()
        ];
        
    }
}
