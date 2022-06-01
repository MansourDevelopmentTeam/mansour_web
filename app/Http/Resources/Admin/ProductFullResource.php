<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductFullResource extends JsonResource
{
    public function toArray($request)
    {
        $productTax = 0;
        if ($this->fix_tax) {
            $productTax = $this->fix_tax;
        } elseif ($this->tax_percentage) {
            $productTax = ($this->tax_percentage / 100) * ($this->discount_price ?? $this->price);
        }
        return [
            "id" => $this->id,
            "name" => $this->name,
            "name_ar" => $this->name_ar,
            "description" => $this->description,
            "description_ar" => $this->description_ar,
            "long_description_ar" => $this->long_description_ar,
            "long_description_en" => $this->long_description_en,
            "image" => $this->image,
            "brand_id" => $this->brand_id,
            "images" => $this->images,
            "price" => $this->price,
            "creator" => $this->creator,
            "created_at" => (string)$this->created_at,
            "discount_price" => $this->discount_price,
            "category" => $this->getCategoryTree(),
            "category_id" => $this->category_id,
            "tags" => $this->tags,
            "options" => $this->optionsWithVlues(),
            "active" => $this->active,
            "deactivation_notes" => $this->deactivation_notes,
            "sku" => $this->sku,
            "stock" => $this->stock,
            "stock_alert" => $this->stock_alert,
            "rateAVG" => $this->rate,
            "rates" => $this->allRates,
            'tax' => $productTax
        ];
    }
}