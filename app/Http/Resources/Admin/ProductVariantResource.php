<?php

namespace App\Http\Resources\Admin;


use App\Exceptions\CartEmptyException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ProductVariantResource extends JsonResource
{
    public function toArray($request)
    {
        $options = $this->customerVariantOptionsLists($request->header('lang'));
        $value_ids = array_map(function ($item)
        {
            if (isset($item["values"][0]["id"])) {
                return $item["values"][0]["id"];
            }
        }, $options);

        $cartRepo = app()->make("App\Models\Repositories\CartRepository");
        $productTax = 0;
        if ($this->fix_tax && floatval($this->fix_tax) > 0) {
            $productTax = floatval($this->fix_tax);
        } elseif ($this->tax_percentage && floatval($this->tax_percentage) > 0) {
            $productTax = (floatval($this->tax_percentage) / 100) * (($this->discount_price ?? $this->price));
        }
        try{
            if (!$this->amount && auth()->check() && 999999 !== auth()->id()) {
                $cartItems = $cartRepo->getUserCartItems();
                foreach ($cartItems as $item) {
                    if ($item['id'] == $this->id) {
                        $this->amount = $item['amount'];
                    }
                }
            }
        }catch(CartEmptyException $e){
            $this->amount = 0;
        }


        if ($this->affiliate_commission && config('constants.enable_affiliate')) {
            $price = $this->discount_price ?? $this->price;
            $commission_amount = $price * ($this->affiliate_commission / 100);
        }else {
            $commission_amount = 0;
        }
        $promotion = count($this->promotions()) > 0 ? $this->promotions()[0] : null;

        return [
            "id" => $this->id,
            "name" => $this->getName($request->header("lang")),
            "name_en" => $this->name,
            "name_ar" => $this->name_ar,
            "description" => $this->getDescription($request->header("lang")),
            "description_en" => $this->getDescription(1),
            "description_ar" => $this->getDescription(2),

            "long_description" => $this->getLongDescription($request->header("lang")),
            "long_description_en" => $this->long_description_en,
            "long_description_ar" => $this->long_description_ar,
            "sku" => $this->sku,
            "price" => $this->price,
            'discount_price' => $this->active_discount ? $this->discount_price : null,
            "stock" => floatval($this->stock),
            "stock_alert" => $this->stock_alert,
            "options" => $this->customerVariantOptionsLists($request->header('lang')),
            "default_variant" => $this->default_variant,
            "order" => $this->order,
            "video" => $this->video,
            "details" => $this->getDetails($request),
            "is_favourite" => $this->is_favourite,
            "is_compare" => $this->is_compare,
            "available_soon" => (boolean)$this->parent->available_soon,
            "preorder" => (boolean) $this->active_preorder,
            "preorder_price" => $this->preorder_price,
            'payment_methods_discount_name_en' => $this->payment_methods_discount_name_en,
            'payment_methods_discount_name_ar' => $this->payment_methods_discount_name_ar,
            'payment_method_discount_ids' => $this->paymentMethods->pluck('id'),
            "discount_start_date" => $this->discount_start_date,
            "discount_end_date" => $this->discount_end_date,
            "max_per_order" => $this->parent->max_per_order,
            // "variant_image" => $this->defaultOptionValue ? $this->defaultOptionValue->image : null,
            "value_ids" => $value_ids,
            "image" => $this->image,
            "parent_id" => $this->parent_id,
            'commission_amount' => $commission_amount,
            "affiliate_commission" => $this->affiliate_commission,
            // "bundleProduct" => ProductVariantResource::collection($this->bundleProduct),
            "images" => $this->getDecodedImages(),
            "in_stock" => $this->stock > 0,
            "active" => (boolean) $this->active,
            "amount" => floatval($this->amount),
            "free_delivery" => $this->free_delivery,
            'promotion' => isset($promotion) ? $promotion->name : null,
            'promotion_en' => isset($promotion) ? $promotion->name : null,
            'promotion_ar' => isset($promotion) ? $promotion->name_ar : null,
            'tax' => $productTax
        ];
    }

    public function getDetails($request)
    {
        $details = [
            "description" => $this->getDescription($request->header("lang")),
            "brand" => $this->brand,
            "attributes" => $this->customerAttributesWithVlues($this->brand),
        ];
        if(isset($this->is_favourite)){
            $details["is_favourite"] = $this->is_favourite;
        }
        return $details;
    }
}
