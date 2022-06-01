<?php

namespace App\Models\Transformers;


use Illuminate\Http\Request;
use App\Models\Payment\Promo;
use App\Models\Products\Product;
use App\Exceptions\CartEmptyException;
use App\Models\Repositories\CartRepository;
use App\Http\Resources\Admin\ProductVariantResource;
use Illuminate\Support\Facades\Log;

class ProductTransformer extends Transformer
{
    protected $cartRepo;
    private $request;

    public function __construct(Request $request, CartRepository $cartRepo)
    {
        $this->request = $request;
        $this->cartRepo = $cartRepo;
    }

    public function transform($product)
    {
        if(empty($product)){
            return [];
        }
        $variants = $product->availableProductVariants()->orderBy('order')->get();
        $productTax = 0;
        if ($product->fix_tax && floatval($product->fix_tax) > 0) {
            $productTax = $product->fix_tax;
        } elseif ($product->tax_percentage && floatval($product->tax_percentage) > 0) {
            $productTax = ($product->tax_percentage / 100) * ($product->discount_price ?? $product->price);
            Log::info('Product percentage tax ' . $productTax);
        }
        $promos = Promo::whereNotNull('list_id')
            ->where('active', 1)
            ->whereDate('expiration_date', '>=', now())
            ->whereHas('list', function ($q) use ($product) {
                $q->whereHas('products', function ($q) use ($product) {
                    $q->where('products.id', $product->parent_id && $product->parent ? $product->parent->id : $product->id);
                });
            })->get();

        if (is_null($product->parent_id)) {
            $firstVariant = $product->productVariants()->orderBy("stock", "DESC")->first();
            $stock = $variants->sum('stock');

        } else {
            $firstVariant = $product;
            $stock = $product->stock;

        }

        if(!$firstVariant){
            $firstVariant = $product;
        }

        try {
            if (!$product->amount && auth()->check() && auth()->id() !== 999999) {
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

        if ($product->affiliate_commission && config('constants.enable_affiliate')) {
            $price = $product->discount_price ?? $product->price;
            $commission_amount = $price * ($product->affiliate_commission / 100);
        }else {
            $commission_amount = 0;
        }

        $promotion = count($product->promotions()) > 0 ? $product->promotions()[0] : null;
        Log::info('Product amount tax ' . $productTax * floatval($product->amount));

        return [
            'id' => $product->id,
            'parent_id' => $product->parent_id,
            'sku' => $product->sku,
            'name' => $product->getName($this->request->header('lang')),
            'name_en' => $product->name,
            'name_ar' => $product->name_ar,
            'slug' => $firstVariant->getSlug($this->request->header('lang')),
            'featured' => (bool) $product->featured,
            'description' => $firstVariant->getDescription($this->request->header('lang')),
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
            'video' => $firstVariant->video,
            'available_soon' => (bool) ($firstVariant->parent_id ? $firstVariant->parent->available_soon : $firstVariant->available_soon),
            'price' => !is_null($firstVariant->price) ? (double)round($firstVariant->price, 2) : null,
            'discount_price' => $firstVariant->discount_price,
            'discount_start_date' => $product->discount_start_date,
            'downloadable_url' => $product->downloadable_url,
            'downloadable_label' => $product->downloadable_label,
            'discount_end_date' => $product->discount_end_date,
            'direct_discount' => !is_null($product->getOriginal('discount_price')),
            'category' => $product->getCategoryTree($this->request->header('lang')),
            'optional_sub_category_id' => $product->optional_sub_category_id,
            'in_stock' => $stock > 0,// && $product->amount <= $stock,
            'stock' => floatval($stock),
            'promotion' => isset($promotion) ? $promotion->name : null,

            'promotion_en' => isset($promotion) ? $promotion->name : null,
            'promotion_ar' => isset($promotion) ? $promotion->name_ar : null,

            'is_favourite' => $product->is_favourite,
            'is_compare' => $product->is_compare,
            'share_link' => $product->getShareLink($this->request->header('lang')),
            'rate' => $product->rate,
            'payment_methods_discount_name_en' => !is_null($firstVariant->active_discount) ? $firstVariant->payment_methods_discount_name_en : null,
            'payment_methods_discount_name_ar' => !is_null($firstVariant->active_discount) ? $firstVariant->payment_methods_discount_name_ar : null,
            'promos' => $promos,
            // "options" => $product->customerAttributesWithVlues(),
            //"product_variants_options" => $product->customerVariantOptionsLists($this->request->header('lang')),
            'product_variants_options' => $product->getVariantOptionsList($product->parent_id ? [$product] : $product->productVariants),
            'product_variants' => ProductVariantResource::collection($variants),
            'order' => $product->order,
            'weight' => $product->weight,
            'active' => (boolean) ($product->parent && $product->parent->active) ? ($product->active ? true : false) : false,
            // 'bundleProduct' => $this->transformCollection($product->bundleProduct),
            'amount' => floatval($product->amount),
            'extra_amount' => floatval($product->extra_amount),
            'variants_stock_count' => floatval($product->variants_stock_count),
            'can_buy' => $product->can_buy,
            'soft_deleted' => $product->deleted_at == null ? false : true,
            'max_per_order' => $firstVariant->parent_id ? $firstVariant->parent->max_per_order : $firstVariant->max_per_order,
            'type' => $firstVariant->parent_id ? $firstVariant->parent->type : $firstVariant->type,
            'commission_amount' => $commission_amount,
            "affiliate_commission" => $product->affiliate_commission,
            "free_delivery" => $product->free_delivery,
            'tax' => $productTax
        ];
    }
}
