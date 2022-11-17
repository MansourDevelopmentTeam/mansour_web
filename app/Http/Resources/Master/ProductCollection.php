<?php

namespace App\Http\Resources\Master;

use Carbon\Carbon;

use App\Models\Payment\Promo;
use App\Models\Products\Product;
use App\Exceptions\CartEmptyException;
use App\Http\Resources\Customer\BrandsResource;
use App\Http\Resources\Admin\ProductVariantResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Customer\GroupsWithoutSubCategoriesResource;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($product){

            $variants = $product->availableProductVariants->sortByDesc('order');

            $promos = Promo::whereNotNull('list_id')
                ->where('active', 1)
                ->whereDate('expiration_date', '>=', now())
                ->whereHas('list.products', function ($q) use ($product) {
                    $q->where('products.id', $product->parent_id ? $product->parent->id : $product->id);
                })
                ->get();

            if (is_null($product->parent_id)) {
                $firstVariant = $product->productVariants()->orderBy("stock", "DESC")->first();
                $stock = $variants->sum('stock');
            } else {
                $role = auth()->user()->role;
                if($role == 'ws'){
                    $product->price = $product->price_ws;
                }
                $firstVariant = $product;
                $stock = $product->stock;
            }

            if (!$firstVariant) {
                $firstVariant = $product;
            }
            try {
                if (!$product->amount && auth()->check() && auth()->id() !== 999999) {
                    $cartItems = app()->make('App\Models\Repositories\CartRepository')->getUserCartItems();
                    foreach ($cartItems as $item) {
                        if ($item['id'] == $product->id) {
                            $product->amount = $item['amount'];
                        }
                    }
                }
            }catch(CartEmptyException $e){
                $product->amount = 0;
            }

            if ($product->affiliate_commission && config('constants.enable_affiliate')) {
                $price = $product->discount_price ?? $product->price;
                $commission_amount = $price * ($product->affiliate_commission / 100);
            }else {
                $commission_amount = 0;
            }
            $promotion = count($product->promotions()) > 0 ? $product->promotions()[0] : null;

            return [
                'id' => $product->id,
                'parent_id' => $product->parent_id,
                'sku' => $product->sku,
                'name' => $product->getName(request()->header('lang')),
                'name_en' => $product->name,
                'name_ar' => $product->name_ar,
                'slug' => $product->getSlug(request()->header('lang')),
                'featured' => (bool) $product->featured,
                'description' => $firstVariant->getDescription(request()->header('lang')),
                'meta_title' => $firstVariant->meta_title,
                'meta_description' => $firstVariant->meta_description,
                'keywords' => $firstVariant->keywords,
                "preorder" => (boolean) $product->active_preorder,
                'preorder_price' => $firstVariant->preorder_price,
                'preorder_start_date' => $product->preorder_start_date,
                'preorder_end_date' => $product->preorder_end_date,
                'image' => $firstVariant->image,
                'images' => $firstVariant->images,
                'thumbnail_image' => $product->thumbnail,
                'downloadable_url' => $product->downloadable_url,
                'downloadable_label' => $product->downloadable_label,
                'video' => $firstVariant->video,
                'available_soon' => (bool) ($firstVariant->parent_id ? $firstVariant->parent->available_soon : $firstVariant->available_soon),
                'price' => !is_null($firstVariant->price) ? (double)round($firstVariant->price, 2) : null,
                'discount_price' => $product->active_discount ? $product->discount_price : null,
                'discount_start_date' => $product->discount_start_date,
                'discount_end_date' => $product->discount_end_date,
                'direct_discount' => !is_null($product->getOriginal('discount_price')),
                'category' => $product->getCategoryTree(request()->header('lang')),
                "group" => isset($product->category->group[0]) ? new GroupsWithoutSubCategoriesResource($product->category->group[0]) : null,
                'optional_sub_category_id' => $product->optional_sub_category_id,
                'in_stock' => $stock > 0,// && $product->amount <= $stock,
                'stock' => floatval($stock),
                'promotion' => isset($promotion) ? $promotion->name : null,

                'promotion_en' => isset($promotion) ? $promotion->name : null,
                'promotion_ar' => isset($promotion) ? $promotion->name_ar : null,

                'is_favourite' => $product->is_favourite,
                'is_compare' => $product->is_compare,
                'brand' => new BrandsResource($product->brand),
                'share_link' => $product->getShareLink(request()->header('lang')),
                'rate' => $product->rate,
                'payment_methods_discount_name_en' => $product->active_discount ? $product->payment_methods_discount_name_en : null,
                'payment_methods_discount_name_ar' => $product->active_discount ? $product->payment_methods_discount_name_ar : null,
                'promos' => $promos,
                'product_variants_options' => $product->getVariantOptionsList($product->parent_id ? [$product] : $product->productVariants),
                'product_variants' => ProductVariantResource::collection($variants),
                'order' => $product->order,
                'weight' => $product->weight,
                'active' => (bool) ($product->parent_id ? ($product->parent->active && $product->active) : $product->active),
                'amount' => floatval($product->amount),
                'variants_stock_count' => floatval($product->variants_stock_count),
                'can_buy' => $product->can_buy,
                'soft_deleted' => $product->deleted_at == null ? false : true,
                'max_per_order' => $firstVariant->parent_id ? $firstVariant->parent->max_per_order : $firstVariant->max_per_order,
                'type' => $firstVariant->parent_id ? $firstVariant->parent->type : $firstVariant->type,
                'commission_amount' => $commission_amount,
                "affiliate_commission" => $product->affiliate_commission,
            ];

            // $product->parent->active && $product->active

        });
    }
}
