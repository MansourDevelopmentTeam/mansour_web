<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Facades\App\Models\Transformers\ProductTransformer;

class AffiliateSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        $address = $this->addresses->first();
        $area = "";

        if($address) {
            $area = $address->area->name;
        }
        $cartItems = optional($this->cart()->with('cartItems.product')->first())->cartItems;

        return [
            "id" => $this->id,
            "name" => $this->name,
            "last_name" => $this->last_name,
            "phone" => $this->phone,
            "email" => $this->email,
            "cart_items" => $cartItems ? optional($cartItems)->map(function ($item) {
                return ProductTransformer::transform($item->product) + ['cart_amount' => $item->amount];
            }) : [],
            "address" => $area,
            "addresses" => $this->addresses,
            "language" => $this->settings->language ?? null,
            "orders" => $this->affiliateOrders->count(),
            "active" => $this->active,
            "closed_payment_methods" => $this->closedPaymentMethods,
            "type" => $this->type
        ];
    }
}
