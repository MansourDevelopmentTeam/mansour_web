<?php

namespace App\Http\Resources\Admin;

use App\Models\Products\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        {
            $price_instance = $this->price;
            $product = Product::where('id', $this->product->id)->withTrashed()->first();
            $parent = $product->parent()->withTrashed()->first();
            if ($product->parent_id != null) {
                return [
                    "id" => $this->product_id,
                    "product" => $product,
                    "amount" => $this->amount,
                    "sub_category" => $parent->category->name,
                    "category" => $parent->category->parent->name,
                    "brand" => isset($parent->brand) ? $parent->brand->name : '',
                    "image" => $this->product->image,
                    "price" => $this->discount_price ?: $this->price,
                    "returned_quantity" => $this->returned_quantity,
                    "options" => $product->customerVariantOptionsLists($request->header('lang')),
                ];
            } else {
                return [
                    "id" => $this->product_id,
                    "product" => $this->product,
                    "amount" => $this->amount,
                    "sub_category" => $this->product->category->name,
                    "category" => $this->product->category->parent->name,
                    "brand" => isset($this->product->brand) ? $this->product->brand->name : '',
                    "image" => $this->product->image,
                    "price" => $this->discount_price ?: $this->price,
                    "returned_quantity" => $this->returned_quantity,
                    "options" => $product->customerVariantOptionsLists($request->header('lang')),
                ];
            }
        }
    }
}
