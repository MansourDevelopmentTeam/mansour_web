<?php

namespace App\Models\Transformers;


use Illuminate\Http\Request;
use App\Models\Payment\Promo;
use App\Models\Products\Product;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CartEmptyException;
use App\Models\Repositories\CartRepository;
use Facades\App\Models\Services\UploadService;
use App\Http\Resources\Customer\GroupsResource;
use App\Http\Resources\Admin\ProductVariantResource;
use App\Http\Resources\Customer\GroupsWithoutSubCategoriesResource;
use Illuminate\Support\Facades\Log;

/**
*
*/
class ProductDetailTransformer extends Transformer
{
	private $request;
	private $cartRepo;

	public function __construct(Request $request, CartRepository $cartRepo)
	{
		$this->request = $request;
		$this->cartRepo = $cartRepo;
	}


	function transform($product)
	{
        $productTax = 0;
        if ($product->fix_tax && floatval($product->fix_tax) > 0) {
            $productTax = floatval($product->fix_tax);
        } elseif ($product->tax_percentage && floatval($product->tax_percentage) > 0) {
            $productTax = (floatval($product->tax_percentage) / 100) * (($product->discount_price ?? $product->price));
        }
        $firstVariant = $product->productVariants->first() ?? $product;
        $variants = $product->productVariants()->orderBy('order')->get();

        if ($product->parent_id) {
            $stock = $firstVariant->stock;
        } else {
            $stock = $variants->sum('stock');
        }

        $promos = Promo::whereNotNull('list_id')
            ->where('active', 1)
            ->whereDate('expiration_date', '>=', now())
            ->whereHas('list', function ($q) use ($product) {
                $q->whereHas('products', function ($q) use ($product) {
                    $q->where('products.id', $product->parent_id ? $product->parent->id : $product->id);
                });
            })->get();

        try {
            if (!$product->amount && auth()->check() && 999999 !== auth()->id()) {
                $cartItems = $this->cartRepo->getUserCartItems();
                foreach ($cartItems as $item) {
                    if ($item['id'] == $product->id) {
                        $product->amount = $item['amount'];
                    }
                }
            }
        }catch(CartEmptyException $e){
            $product->amount = 0;
        }


        if ($firstVariant->affiliate_commission && config('constants.enable_affiliate')) {
            $price = $firstVariant->discount_price ?? $firstVariant->price;
            $commission_amount = $price * ($firstVariant->affiliate_commission / 100);
        }else {
            $commission_amount = 0;
        }

        $promotion = count($product->promotions()) > 0 ? $product->promotions()[0] : null;

		return [
            "id" => $product->id,
            "parent_id" => $product->parent_id,
            "sku" => $product->sku,
			"name" => $product->getName($this->request->header("lang")),
            "name_en" => $product->name,
            "name_ar" => $product->name_ar,
						"description" => $firstVariant->getDescription($this->request->header("lang")),
						"description_en" => $firstVariant->getDescription(1),
						"description_ar" => $firstVariant->getDescription(2),
            "meta_title" => $firstVariant->getMetaTitle($this->request->header("lang")),
            "meta_description" => $firstVariant->meta_description,
            "keywords" => $firstVariant->keywords,
            "preorder" => (boolean) $product->active_preorder,
            "preorder_price" => $product->preorder_price,
            "long_description" => $firstVariant->getLongDescription($this->request->header("lang")),
						"long_description_en" => $firstVariant->getLongDescription(1),
						"long_description_ar" => $firstVariant->getLongDescription(2),
			"image" => $firstVariant->image,
            'images' => $firstVariant->images,
            "thumbnail_image" => $product->thumbnail,
            'payment_methods_discount_name_en' => $product->payment_methods_discount_name_en,
            'payment_methods_discount_name_ar' => $product->payment_methods_discount_name_ar,
            'downloadable_url' => $product->downloadable_url,
            'downloadable_label' => $product->downloadable_label,
            "video" => $product->video,
            "available_soon" => (boolean)($firstVariant->parent_id ? $firstVariant->parent->available_soon : $firstVariant->available_soon),
			"related_skus" => $product->relatedSkus->pluck('sku')->toarray(),
			"price" => (double)$firstVariant->price,
            'discount_price' => $product->active_discount ? $product->discount_price : null,
            "direct_discount" => !is_null($product->getOriginal("discount_price")),
			"category" => $product->getCategoryTree($this->request->header("lang")),
            "optional_sub_category_id" => $product->optional_sub_category_id,
            "group" => isset($product->category->group[0]) ? new GroupsWithoutSubCategoriesResource($product->category->group[0]) : null,
			"details" => $this->getDetails($firstVariant),
            "in_stock" => $stock > 0,
            'commission_amount' => $commission_amount,
			"stock" => floatval($stock),
            "weight" => $product->weight,
			"is_favourite" => $product->is_favourite,
            "is_compare" => $product->is_compare,
            "promos" => $promos,
            'promotion' => $promotion->name ?? null,
            'promotion_en' => $promotion->name ?? null,
            'promotion_ar' => $promotion->name_ar ?? null,
            'promotion_description' =>  $promotion->description ?? null,
            'promotion_description_ar' => $promotion->description_ar ?? null,
			"share_link" => $product->getShareLink($this->request->header("lang")),
			"rate" => $product->rate,
            // "reviews" => $product->approvedRates,
            "order" => $product->order,
            // "bundleProduct" =>$this->transformCollection($product->bundleProduct),
            "type" => $product->type,
            // "product_variants_options" => $product->customerVariantOptionsLists($this->request->header('lang')),
            "product_variants_options" => $product->getVariantOptionsList($product->parent_id ? [$product] : $product->productVariants),
            "product_variants" => ProductVariantResource::collection($variants),
            // "reviewsAvg" => $product->ratesApprovedAvg(),
            // "active" => (boolean) ($firstVariant->parent_id ? $firstVariant->parent->active : $firstVariant->active),
            'active' => $product->parent ? $product->is_active : (bool) $product->active,
            // 'active' => (bool) ($product->parent && $product->parent->active) ? ($product->active ? true : false) : false,
			"amount" => floatval($product->amount),
            'max_per_order' => $product->parent_id ? $product->parent->max_per_order : $product->max_per_order,
            "affiliate_commission" => $product->affiliate_commission,
            "free_delivery" => $product->free_delivery,
            'tax' => $productTax
		];
	}

    public function getDetails($product)
    {
        $details = [
            // "images" => $product->images->pluck("url")->toArray(),
            "description" => $product->getDescription($this->request->header("lang")),
            "brand" => $product->brand,
            "attributes" => $product->customerAttributesWithVlues($product->brand),
            // "tags" => $this->getTags($product)
        ];
        if(isset($product->is_favourite)){
            $details["is_favourite"] = $product->is_favourite;
        }
        return $details;
    }

    public function getTags($product)
    {
        $productTags = $product->tags->where('status',1);
        $finalData = [];
        foreach ($productTags as $productTag){
            if ($this->request->header("lang") == 2){
                $finalData[] = [
                    'name' => $productTag->name_ar,
                    'description'  => $productTag->description_ar
                ];
            }else{
                $finalData[] = [
                    'option' => $productTag->name_en,
                    'value'  => $productTag->description_en
                ];
            }
        }
        return $finalData;
    }
}
