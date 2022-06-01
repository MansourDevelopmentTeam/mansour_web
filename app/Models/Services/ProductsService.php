<?php

namespace App\Models\Services;

use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\CategoryOption;
use App\Models\Products\Lists;
use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\ProductTag;
use App\Models\Products\Tag;
use App\Models\Transformers\ProductFullTransformer;
use App\Models\Users\CustomerClass;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;

class ProductsService
{
    private $pushService;


    public function __construct(PushService $pushService)
    {
        $this->pushService = $pushService;
    }

    public function createProduct($data)
    {
        $category = Category::find($data['category_id']);
        if ($category->parent_id == null) {
            return response()->json([
                "code" => 422,
                "message" => "The Category must be subcategory not Main Category",
                "errors" => [
                    "errorMessage" => "The Category must be subcategory not Main Category",
                    "errorDetails" => "Invalid data",
                ]
            ], 200)->send();
        }
        if ($data['brand_id'] && !is_numeric($data['brand_id'])) {
            $brand = Brand::firstOrCreate(["name" => $data['brand_id']]);
            $data['brand_id'] = $brand->id;
        }
        $data['creator_id'] = \Auth::id();
        if (auth()->User()->type == 2) {
            $data['status'] = 2;
        } else {
            $data['status'] = 1;
        }
        $productData = [
            'name' => isset($data['name']) ? $data['name'] : null,
            'name_ar' => isset($data['name_ar']) ? $data['name_ar'] : null,
            'order' => isset($data['order']) ? $data['order'] : null,
            'description' => isset($data['description']) ? $data['description'] : null,
            'description_ar' => isset($data['description_ar']) ? $data['description_ar'] : null,
            'long_description_en' => isset($data['long_description_en']) ? $data['long_description_en'] : null,
            'long_description_ar' => isset($data['long_description_ar']) ? $data['long_description_ar'] : null,
            'category_id' => isset($data['category_id']) ? $data['category_id'] : null,
            'brand_id' => isset($data['brand_id']) ? $data['brand_id'] : null,
            'image' => isset($data['image']) ? $data['image'] : null,
            'sku' => isset($data['sku']) ? $data['sku'] : null,
            'creator_id' => isset($data['creator_id']) ? $data['creator_id'] : null,
            'stock' => isset($data['stock']) ? $data['stock'] : null,
            'stock_alert' => isset($data['stock_alert']) ? $data['stock_alert'] : null,
            'max_per_order' => isset($data['max_per_order']) ? $data['max_per_order'] : null,
            'min_days' => isset($data['min_days']) ? $data['min_days'] : null,
            'status' => isset($data['status']) ? $data['status'] : 1,
            'barcode' => isset($data['barcode']) ? $data['barcode'] : null,
            'active' => 1,
            'exclude_from_promotions' => isset($data['exclude_from_promotions']) ? $data['exclude_from_promotions'] : null,
        ];
        DB::beginTransaction();
        try {
            $product = Product::create($productData);
            if (isset($data['prices']) && is_array($data['prices'])) {
                $customerClasses = CustomerClass::where('active', 1)->pluck('id')->toArray();
                foreach ($data['prices'] as $price) {
                    if (isset($price['price']) && isset($price['class_id'])) {
                        $index = array_search($price['class_id'], $customerClasses);
                        if ($index !== false) {
                            unset($customerClasses[$index]);
                            $product->prices()->create($price);
                        }
                    }
                }

//                if (!empty($customerClasses)) {
//                    return response()->json([
//                        "code" => 422,
//                        "message" => "you Should fill all customer classes Prices",
//                        "errors" => [
//                            "errorMessage" => "you Should fill all customer classes Prices",
//                            "errorDetails" => "Invalid data",
//                        ]
//                    ], 200)->send();
//                }
            }

            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    if (isset($image["url"]) && !empty($image["url"])) {
                        $product->images()->create(["url" => $image["url"]]);
                    }
                }
            }
            if (isset($data['tags']) && is_array($data['tags'])) {
                foreach ($data['tags'] as $tag) {
                    $tagQuery = Tag::find($tag);
                    if ($tagQuery) {
                        $data = [
                            'tag_id' => $tagQuery->id,
                            'product_id' => $product->id,
                        ];
                        ProductTag::updateOrCreate($data);
                    }
                }
            }
            if (isset($data['option_values']) && is_array($data['option_values'])) {
                foreach ($data['option_values'] as $option_value) {
                    $option = Option::find($option_value['option_id']);
                    if ($option) {
                        $categoryOptions = CategoryOption::where('sub_category_id', $category->id)->where('option_id', $option->id)->first();
                        $value = OptionValue::where('id', $option_value['option_value_id'])->where('option_id', $option->id)->first();
                        if ($categoryOptions && $value) {
                            $data = [
                                'product_id' => $product->id,
                                'option_id' => $option->id,
                                'value_id' => $value->id,
                                'created_by' => \Auth::id(),
                            ];
                            if ($option->type == 3) {
                                $data['image'] = $product->image;
                            } elseif ($option->type == 2 || $option->type == 4) {
                                $data['color_code'] = $product->color_code;
                            }
                            $productOptionValue = ProductOptionValues::updateOrCreate($data);
                        }
                    }
                }
            }
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage(),
                "errors" => [
                    "errorMessage" => $e->getMessage(),
                    "errorDetails" => "Invalid data",
                ]
            ], 200)->send();
        }

    }

    public function editProduct($product, $data)
    {
        $category = Category::find($data['category_id']);
        if ($category->parent_id == null) {
            return response()->json([
                "code" => 422,
                "message" => "The Category must be subcategory not Main Category",
                "errors" => [
                    "errorMessage" => "The Category must be subcategory not Main Category",
                    "errorDetails" => "Invalid data",
                ]
            ], 200)->send();
        }


        if ($data['brand_id'] && !is_numeric($data['brand_id'])) {
            $brand = Brand::firstOrCreate(["name" => $data['brand_id']]);
            $data['brand_id'] = $brand->id;
        }
        if (auth()->User()->type == 2) {
            $data['status'] = 2;
        } else {
            $data['status'] = 1;
        }
        $productData = [
            'name' => isset($data['name']) ? $data['name'] : $product->name,
            'name_ar' => isset($data['name_ar']) ? $data['name_ar'] : $product->name_ar,
            'order' => isset($data['order']) ? $data['order'] : $product->order,
            'description' => isset($data['description']) ? $data['description'] : $product->description,
            'description_ar' => isset($data['description_ar']) ? $data['description_ar'] : $product->description_ar,
            'long_description_en' => isset($data['long_description_en']) ? $data['long_description_en'] : $product->long_description_en,
            'long_description_ar' => isset($data['long_description_ar']) ? $data['long_description_ar'] : $product->long_description_ar,
            'category_id' => isset($data['category_id']) ? $data['category_id'] : $product->category_id,
            'brand_id' => isset($data['brand_id']) ? $data['brand_id'] : $product->brand_id,
            'image' => isset($data['image']) ? $data['image'] : $product->image,
            'sku' => isset($data['sku']) ? $data['sku'] : $product->sku,
            'creator_id' => isset($data['creator_id']) ? $data['creator_id'] : $product->creator_id,
            'stock' => isset($data['stock']) ? $data['stock'] : $product->stock,
            'stock_alert' => isset($data['stock_alert']) ? $data['stock_alert'] : $product->stock_alert,
            'max_per_order' => isset($data['max_per_order']) ? $data['max_per_order'] : $product->max_per_order,
            'min_days' => isset($data['min_days']) ? $data['min_days'] : $product->min_days,
            'status' => isset($data['status']) ? $data['status'] : 1,
            'barcode' => isset($data['barcode']) ? $data['barcode'] : $product->barcode,
            'exclude_from_promotions' => isset($data['exclude_from_promotions']) ? $data['exclude_from_promotions'] : $product->exclude_from_promotions,
        ];
        DB::beginTransaction();
        try {


            if (auth()->User()->type == 2) {
                if ($product->stock > 0) {
                    $users = $product->stock_notifiers;
                    $product->stock_notifiers()->sync([]);
                    $this->pushService->notifyUsers($users, __('notifications.stockAvailableTitle', ['productName' => $product->name]), __('notifications.stockAvailableBody'));
                }
            } else {
                $clonedProduct = Product::where(function ($q) use ($product) {
                    $q->where('original_product_id', $product->id);
                    $q->orWhere('id', $product->id);
                });

                $clonedProduct = $clonedProduct->where('status', 1)->first();
                if ($clonedProduct) {

                    $product = $clonedProduct;
                } else {
                    $product = $this->cloneProduct($product);
                }
            }

            $product->update($productData);

            if (isset($data['prices']) && is_array($data['prices'])) {
                $customerClasses = CustomerClass::where('active', 1)->pluck('id')->toArray();
                $product->prices()->delete();
                foreach ($data['prices'] as $price) {
                    if (isset($price['price']) && isset($price['class_id'])) {
                        $index = array_search($price['class_id'], $customerClasses);
                        if ($index !== false) {
                            unset($customerClasses[$index]);
                            $product->prices()->create($price);
                        }
                    }
                }

//                if (!empty($customerClasses)) {
//                    return response()->json([
//                        "code" => 422,
//                        "message" => "you Should fill all customer classes Prices",
//                        "errors" => [
//                            "errorMessage" => "you Should fill all customer classes Prices",
//                            "errorDetails" => "Invalid data",
//                        ]
//                    ], 200)->send();
//                }
            }

            if (isset($data['deleted_images'])) {
                ProductImage::whereIn("id", $data['deleted_images'])->delete();
            }

            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    if (isset($image["url"]) && !empty($image["url"])) {
                        if (isset($image["id"])) {
                            $product->images()->find($image["id"])->update(["url" => $image["url"]]);
                        } else {
                            $product->images()->create(["url" => $image["url"]]);
                        }
                    }
                }
            }
            if (isset($data['tags']) && is_array($data['tags'])) {
                foreach ($data['tags'] as $tag) {
                    $tagQuery = Tag::find($tag);
                    if ($tagQuery) {
                        $data = [
                            'tag_id' => $tagQuery->id,
                            'product_id' => $product->id,
                        ];
                        ProductTag::updateOrCreate($data);
                    }
                }
            }

            if (isset($data['option_values']) && is_array($data['option_values'])) {
                foreach ($data['option_values'] as $option_value) {
                    $option = Option::find($option_value['option_id']);
                    if ($option) {
                        $categoryOptions = CategoryOption::where('sub_category_id', $category->id)->where('option_id', $option->id)->first();
                        $value = OptionValue::where('id', $option_value['option_value_id'])->where('option_id', $option->id)->first();
                        if ($categoryOptions && $value) {

                            $data = [
                                'product_id' => $product->id,
                                'option_id' => $option->id,
                                'value_id' => $value->id,
                                'created_by' => \Auth::id(),
                            ];
                            if ($option->type == 4 && isset($option_value['image'])) {
                                $data['image'] = $option_value['image'];
                            } elseif ($option->type == 5 && isset($option_value['input_en']) && isset($option_value['input_ar'])) {
                                $data['input_en'] = $option_value['input_en'];
                                $data['input_ar'] = $option_value['input_ar'];
                            }
                            $productOptionValue = ProductOptionValues::updateOrCreate($data);
                        }
                    }
                }
            }

            DB::commit();

            return $product;
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage(),
                "errors" => [
                    "errorMessage" => $e->getMessage(),
                    "errorDetails" => "Invalid data",
                ]
            ], 200)->send();
        }

    }

    public function cloneProduct($product)
    {

        $clonedProduct = $product->replicate();
        $x = 1;
        $mainProductSku = $product->sku . '_cloned_' . $x;
        $productWithTheSameSku = Product::where('sku', $mainProductSku)->first();
        while ($productWithTheSameSku) {
            $x++;
            $mainProductSku = $product->sku . '_cloned_' . $x;
            $productWithTheSameSku = Product::where('sku', $mainProductSku)->first();
            if (!$productWithTheSameSku) {
                break;
            }
        }
        $clonedProduct->sku = $mainProductSku;
        $clonedProduct->save();

//            foreach ($product->prices->toArray() as $price) {
//                $clonedProduct->prices()->create($price);
//            }

        if ($product->parent_id == null) {
            foreach ($product->productVariants as $productVariant) {
                $clonedProductVariant = $productVariant->replicate();
                $clonedProductVariant->parent_id = $clonedProduct->id;

                $x = 1;
                $variantProductSku = $productVariant->sku . '_cloned_' . $x;
                $productWithTheSameSku = Product::where('sku', $variantProductSku)->first();
                while ($productWithTheSameSku) {
                    $x++;
                    $variantProductSku = $product->sku . '_cloned_' . $x;
                    $productWithTheSameSku = Product::where('sku', $variantProductSku)->first();
                    if (!$productWithTheSameSku) {
                        break;
                    }
                }
                $clonedProductVariant->sku =$variantProductSku;
                $clonedProductVariant->save();

                foreach ($productVariant->images->toArray() as $image) {
                    $clonedProductVariant->images()->create($image);
                }
                foreach ($productVariant->tags->toArray() as $tag) {
                    $clonedProductVariant->tags()->create($tag);
                }
                foreach ($productVariant->pivotOptions->toArray() as $optionValue) {
                    $clonedProductVariant->pivotOptions()->create($optionValue);
                }

            }
        }

        foreach ($product->images->toArray() as $image) {
            $clonedProduct->images()->create($image);
        }
        foreach ($product->tags->toArray() as $tag) {
            $clonedProduct->tags()->create($tag);
        }
        foreach ($product->pivotOptions->toArray() as $optionValue) {
            $clonedProduct->pivotOptions()->create($optionValue);
        }

        return $clonedProduct;
    }

    public function approveProductEdits($editedProduct)
    {
        $mainProduct = $editedProduct->original_product;
        $editedArray = $editedProduct->toArray();
        if ($mainProduct) {

            $editedArray['original_product_id'] = null;
            $editedArray['status'] = 2;
            $mainProduct->update($editedArray);

            $mainProduct->prices()->delete();
            foreach ($editedProduct->prices->toArray() as $price) {
                $mainProduct->prices()->create($price);
            }
            $mainProduct->images()->delete();
            foreach ($editedProduct->images->toArray() as $image) {
                $mainProduct->images()->create($image);
            }
            $mainProduct->tags()->delete();
            foreach ($editedProduct->tags->toArray() as $tag) {
                $mainProduct->tags()->create($tag);
            }
            $mainProduct->pivotOptions()->delete();
            foreach ($editedProduct->pivotOptions->toArray() as $optionValue) {
                $mainProduct->pivotOptions()->create($optionValue);
            }
            return $mainProduct;
        }
    }


}
