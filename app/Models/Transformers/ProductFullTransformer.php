<?php

namespace App\Models\Transformers;

use App\Http\Resources\Admin\ProductVariantResource;
use Facades\App\Models\Services\UploadService;
use Illuminate\Http\Request;

/**
 *
 */
class ProductFullTransformer extends Transformer
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function transform($product)
    {
        $variants = $product->productVariants;
        $stock = $product->parent_id ? $product->stock : $variants->sum('stock');
        $promotion = count($product->promotions()) > 0 ? $product->promotions()[0] : null;

        return [
            "id" => $product->id,
            "parent_id" => $product->parent_id,
            "name" => $product->name,
            "name_ar" => $product->name_ar,
            'featured' => (bool) $product->featured,
            "description" => $product->description,
            "meta_title" => $product->meta_title,
            "meta_title_ar" => $product->meta_title_ar,
            "meta_description" => $product->meta_description,
            "meta_description_ar" => $product->meta_description_ar,
            "keywords" => $product->keywords,
            "preorder" => (boolean) $product->active_preorder,
            "preorder_price" => $product->preorder_price,
            "preorder_start_date" => $product->preorder_start_date,
            "preorder_end_date" => $product->preorder_end_date,
            "description_ar" => $product->description_ar,
            "long_description_ar" => $product->long_description_ar,
            "long_description_en" => $product->long_description_en,
            "image" => $product->image,
            "thumbnail_image" => $product->thumbnail,
            "last_editor" => $product->updator,
            "last_editor_id" => $product->last_editor,
            "video" => $product->video,
            "available_soon" => (boolean)$product->available_soon,
            "brand_id" => $product->brand_id,
            "images" => $product->images->map(function($image) {
                return [
                    "id" => $image->id,
                    "product_id" => $image->product_id,
                    "url" => $image->url,
                    "thumbnail" => UploadService::getImageThumbnailLink($image->url),
                ];
            }),
            "price" => $product->price,
            'payment_methods_discount_name_en' => $product->payment_methods_discount_name_en,
            'payment_methods_discount_name_ar' => $product->payment_methods_discount_name_ar,
            'downloadable_url' => $product->downloadable_url,
            'downloadable_label' => $product->downloadable_label,
            'payment_method_discount_ids' => $product->paymentMethods->pluck('id'),
            'discount_price' => $product->active_discount ? $product->discount_price : null,
            "discount_start_date" => $product->discount_start_date,
            "discount_end_date" => $product->discount_end_date,

            "created_at" => (string)$product->created_at,
            "category" => $product->getCategoryTree(),
            "optional_category" => $product->optional_sub_category_id ? $product->getOptionalCategoryTree() : null,
            "category_id" => $product->category_id,
            "optional_sub_category_id" => $product->optional_sub_category_id,

            'promotion' => isset($promotion) ? $promotion->name : null,
            'promotion_en' => isset($promotion) ? $promotion->name : null,
            'promotion_ar' => isset($promotion) ? $promotion->name_ar : null,

            "tags" => $product->tags,
            "options" => $product->adminAttributesWithVlues(),
            "product_variant_options" => $product->productVariantOptions()->with('values')->get()->unique(),
            // "product_variant_options" => $product->getAdminVariantOptionsList($product->parent_id ? [$product] : $variants),
            "product_variants" => ProductVariantResource::collection($product->ProductVariants),
            "active" => (boolean) $product->active,
            "deactivation_notes" => $product->deactivation_notes,
            "sku" => $product->sku,
            "stock" => $stock,
            "weight" => $product->weight,
            "stock_alert" => $product->stock_alert,
            "rate" => $product->rate,
            "rates" => $product->allRates,
            "ratesAvg" => $product->ratesApprovedAvg(),
            "history" => $product->getHistory(),
            "bundleProduct" => $this->transformCollection($product->bundleProduct),
            "relatedProducts" => $this->transformCollection($product->relatedProducts),
            "type" => $product->type,
            "order" => $product->order,
            "max_per_order" => $product->max_per_order,
            "min_days" => $product->min_days,
            "bundle_checkout" => $product->bundle_checkout,
            "has_stock" => $product->has_stock,
            "affiliate_commission" => $product->affiliate_commission,
            "free_delivery" => $product->free_delivery,
        ];
    }
}
