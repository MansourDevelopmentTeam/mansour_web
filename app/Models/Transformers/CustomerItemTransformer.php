<?php 

namespace App\Models\Transformers;

/**
* 
*/
class CustomerItemTransformer extends Transformer
{
	
	function transform($item)
	{
		$price_instance = $item->price;
		$product = $item->product;
		return [
			"id" => $item->product->id,
			"amount" => floatval($item->amount),
            "serial_number" => $item->serial_number,
			"sku" => $item->product->sku,
			"name" => $item->product->name,
			"name_ar" => $item->product->name_ar,
			"image" => $item->product->image,
			"price" => (double)$item->price,
			"discount_price" => !is_null($item->discount_price) ? (double)$item->discount_price : null,
			"active" => (bool)$item->product->active,
			"rate" => $item->rate,
			"options" => $product->customerVariantOptionsLists(request()->header('lang')),
		];
	}
}