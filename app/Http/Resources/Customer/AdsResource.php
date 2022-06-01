<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class AdsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "image" => $this->getImage($request->header('lang')),
            "image_web" => $this->getImageWeb($request->header('lang')),
            "type" => $this->type,
            "item_id" => $this->item_id,
            "name" =>$this->getName(),
            "popup" => $this->popup,
            "order" => $this->order,
            "link" => $this->link,
            "banner_title" => $this->getBannerTitle($request->header('lang')),
            "banner_description" => $this->getBannerDescription($request->header('lang'))
        ];
    }
}
