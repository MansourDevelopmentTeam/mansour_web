<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerItemResource extends JsonResource
{
    public function toArray($request)
    {
        $price_instance = $this->price;
        $product = $this->product;

        return [
            "id" => $this->product->id,
            "amount" => $this->amount,
            "name" => $this->product->name,
            "image" => $this->product->image,
//            "price" => $this->product->discount_price ?: $this->product->price,
            "active" => (bool)$this->product->active,
            "price" => $price_instance->discount_price ?: $price_instance->price,
            "rate" => $this->rate,
            "options" => $product->customerVariantOptionsLists(request()->header('lang')),
        ];
    }
}
