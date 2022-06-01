<?php

namespace App\Models\Transformers;

use App\Http\Resources\Admin\ProductVariantResource;
use Illuminate\Http\Request;

/**
*
*/
class ProductVariantFullTransformer extends Transformer
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
	function transform($product)
	{
		$variants = $product->productVariants;
		$stock = $product->stock + $variants->sum('stock');

        $promotion = count($product->promotions()) > 0 ? $product->promotions()[0] : null;
        $productTax = 0;
        if ($product->fix_tax) {
            $productTax = $product->fix_tax;
        } elseif ($product->tax_percentage) {
            $productTax = ($product->tax_percentage / 100) * ($product->discount_price ?? $product->price);
        }
		return [
			"id" => $product->id,
			"parent_id" => $product->parent_id,
			"name" => $product->name,
			"name_ar" => $product->name_ar,
			"description" => $product->description,
			"description_ar" => $product->description_ar,
			"long_description_ar" => $product->long_description_ar,
			"long_description_en" => $product->long_description_en,
			"meta_title" => $product->meta_title,
            "meta_title_ar" => $product->meta_title_ar,
            "meta_description" => $product->meta_description,
            "meta_description_ar" => $product->meta_description_ar,
            "keywords" => $product->keywords,
			"image" => $product->image,
			"brand_id" => $product->brand_id,
			"images" => $product->images,
			"price" => $product->price,
			"creator" => $product->creator,
            "last_editor" => $product->updator,
            "last_editor_id" => $product->last_editor,
            "video" => $product->video,
            "available_soon" => (boolean)$product->available_soon,
			"created_at" => (string)$product->created_at,
			"discount_price" => $product->discount_price,
			"discount_start_date" => $product->discount_start_date,
            "discount_end_date" => $product->discount_end_date,
			"category" => $product->getCategoryTree(),
			"category_id" => $product->category_id,
            "optional_sub_category_id" => $product->optional_sub_category_id,

            'promotion' => isset($promotion) ? $promotion->name : null,
            'promotion_en' => isset($promotion) ? $promotion->name : null,
            'promotion_ar' => isset($promotion) ? $promotion->name_ar : null,

            "tags" => $product->tags,
            "options" => $product->adminAttributesWithVlues(),
			'payment_method_discount_ids' => $product->paymentMethods->pluck('id'),
            "product_variant_options" =>  $product->fullVariantOptionsLists(),
            "product_variants" => ProductVariantResource::collection($product->ProductVariants),
			"active" => (boolean) $product->active,
			"deactivation_notes" => $product->deactivation_notes,
			"sku" => $product->sku,
			"weight" => $product->weight,
			"stock" => $stock,
			"preorder_price" => $product->preorder_price,
            "preorder" => (boolean) $product->active_preorder,
			"stock_alert" => $product->stock_alert,
			"rate" => $product->rate,
            "rates" => $product->allRates,
            "ratesAvg" => $product->ratesApprovedAvg(),
            "bundleProducts" => $this->transformCollection($product->bundleProduct),
			"history" => $product->getHistory(),
            "order" => $product->order,
			"max_per_order" => $product->max_per_order,
			"min_days" => $product->min_days,
            "affiliate_commission" => $product->affiliate_commission,
            "free_delivery" => $product->free_delivery,
            'tax' => $productTax
		];
	}
}
