<?php

namespace App\Models\Transformers;

/**
*
*/
class OrderItemTransformer extends Transformer
{

	function transform($item)
	{
		$price_instance = $item->price;
		$product = $item->product;
		$parent = $product->parent()->withTrashed()->first();
        $productTax = 0;
        if ($item->fix_tax) {
            $productTax = $item->fix_tax;
        } elseif ($item->tax_percentage) {
            $productTax = ($item->tax_percentage / 100) * ($item->discount_price ?? $item->price);
        }
		return [
			"id" => $item->product_id,
			"product" => $product,
			"sku" => $product->sku,
			"serial_number" => $item->serial_number,
			"amount" => $item->amount,
			"sub_category" => $product->parent_id ? $parent->category->name : $product->category->name,
			"category" => $product->parent_id ? $parent->category->parent->name : $product->category->parent->name,
			"image" =>  $product->image,
			"price" => $item->price,
			"discount_price" => $item->discount_price,
            "affiliate_commission" => $item->affiliate_commission,
			"options" => $product->customerVariantOptionsLists(request()->header('lang')),
            'tax' => $productTax
		];
	}
}
