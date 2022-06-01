<?php

namespace App\Sheets\Import\Products;

use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\CategoryOption;
use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Models\Products\Product;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\ProductTag;
use App\Models\Products\Tag;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class ProductVariantImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    private $approved;

    public function __construct($approved = 1)
    {
        $this->approved = $approved;
    }

    public function collection(Collection $rows)
    {
        $totalCount = 0;
        $totalMainProductCount = 0;
        $totalVariantProductCount = 0;
//        $totalApprovedCount = 0;
//        $totalApprovedProductsCount = 0;
//        $totalApprovedVariantsCount = 0;
//        $totalMissedCount = 0;
        $totalMissedProductsCount = 0;
        $totalMissedVariantsCount = 0;
//        $totalCreatedCount = 0;
        $totalCreatedProductsCount = 0;
        $totalCreatedVariantsCount = 0;
//        $totalUpdatedCount = 0;
        $totalUpdatedProductsCount = 0;
        $totalUpdatedVariantsCount = 0;
        $missedDetails = [];
        $mainSkuArray = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $MainSku = isset($row['main_sku']) && !empty($row['main_sku']) ? $row['main_sku'] : '';
                $VariantSku = isset($row['variant_sku']) && !empty($row['variant_sku']) ? $row['variant_sku'] : '';
                $productNameEn = isset($row['name']) && !empty($row['name']) ? $row['name'] : '';
                $productNameAr = isset($row['name_ar']) && !empty($row['name_ar']) ? $row['name_ar'] : '';
                $productDescriptionEn = isset($row['description']) && !empty($row['description']) ? $row['description'] : '';
                $productDescriptionAr = isset($row['description_ar']) && !empty($row['description_ar']) ? $row['description_ar'] : '';
                $productMainImage = isset($row['main_image']) && !empty($row['main_image']) ? $row['main_image'] : '';
                $productActive = isset($row['active']) && !empty($row['active']) ? $row['active'] : 1;
                $productSubtractStock = isset($row['subtract_stock']) && !empty($row['subtract_stock']) ? $row['subtract_stock'] : 1;
                $productStock = isset($row['stock']) && !empty($row['stock']) && ($row['stock']) > 0 ? $row['stock'] : 0;
                $productBarcode = isset($row['barcode']) && !empty($row['barcode']) ? $row['barcode'] : '';
                $productPrice = isset($row['price']) && !empty($row['price']) ? $row['price'] : 0;
                $productDiscountPrice = isset($row['discount_price']) && !empty($row['discount_price']) ? $row['discount_price'] : 0;
                $productTags = isset($row['tags']) && !empty($row['tags']) ? explode(',', $row['tags']) : '';
                $productImages = isset($row['images']) && !empty($row['images']) ? explode(',', $row['images']) : '';
                $brandID = null;
                $subCategoryID = null;
                $product = null;
                $totalCount++;

                if (isset($row['subcategory_slug']) && $row['subcategory_slug'] != null) {
                    $subCategory = Category::whereNotNull("parent_id")->where("slug", $row['subcategory_slug'])->first();
                    if ($subCategory) {
                        $subCategoryID = $subCategory->id;
                    }

                } else {

                    if (isset($row['subcategory']) && $row['subcategory'] != null && isset($row['category']) && $row['category'] != null) {
                        $query = Category::query();
                        $query->where('name', $row['subcategory']);
                        $query->whereHas('parent', function ($q) use ($row) {
                            $q->where('name', $row['category']);
                        });
                        $query->when(isset($row['group']) && !empty($row['group']), function ($q) use ($row) {
                            $q->whereHas('group', function ($q) use ($row) {
                                $q->where('groups.name_en', $row['group']);
                            });
                        });
                        $subCategory = $query->first();
                        if ($subCategory) {
                            $subCategoryID = $subCategory->id;
                        }
                    }
                }
                if (isset($row['brand']) && $row['brand'] != null) {
                    $brandData = Brand::where("name", $row['brand']);
                    if ($brandData) {
                        $brandID = $brandData->id;
                    } else {
                        $totalMissedProductsCount++;
                        $missedDetails[] = 'variant with sku ' . $MainSku . '( Brand Not Found )';
                    }
                }


                $productData = [
                    "sku" => $MainSku,
                    "name" => $productNameEn,
                    "name_ar" => $productNameAr,
                    "description" => $productDescriptionEn,
                    "description_ar" => $productDescriptionAr,
                    "image" => $productMainImage,
                    "brand_id" => $brandID,
                    "stock" => $productStock,
                    "barcode" => $productBarcode,
                    "active" => $productActive,
                    "subtract_stock" => $productSubtractStock,
                    "category_id" => $subCategoryID,
                    "price" => $productPrice,
                    "discount_price" => $productDiscountPrice,
                ];
                $productVariantData = [
                    "sku" => $VariantSku,
                    "image" => $productMainImage,
                    "stock" => $productStock,
                    "barcode" => $productBarcode,
                    "active" => $productActive,
                    "price" => $productPrice,
                    "discount_price" => $productDiscountPrice,
                ];


                if ($row['variant_sku'] != null || $row['variant_sku'] != null) {
                    $totalVariantProductCount++;
                    $parentProduct = Product::where('sku', $MainSku)->first();
                    if ($parentProduct) {
                        $productVariantData['parent_id'] = $parentProduct->id;
                        $product = Product::where('sku', $VariantSku)->first();
                        if ($product) {
                            $totalUpdatedVariantsCount++;
                            $this->approved == 1 ? $product->update($productVariantData) : '';
                        } else {
                            $totalCreatedVariantsCount++;
                            $this->approved == 1 ? $product = Product::create($productVariantData) : '';
                        }
                    } else {
                        if (in_array($MainSku, $mainSkuArray)) {
                            $totalCreatedVariantsCount++;
                        } else {
                            $totalMissedVariantsCount++;
                            $missedDetails[] = 'variant with sku ' . $VariantSku . '( parent ' . $MainSku . ' not found )';
                        }
                    }
                } else {
                    if ($subCategoryID) {
                        $totalMainProductCount++;
                        $mainSkuArray[] = $MainSku;
                        $product = Product::where('sku', $MainSku)->first();
                        if ($product) {
                            $totalUpdatedProductsCount++;
                            $this->approved == 1 ? $product->update($productData) : '';
                        } else {
                            $totalCreatedProductsCount++;
                            $this->approved == 1 ? $product = Product::create($productData) : '';
                        }
                    } else {
                        $totalMissedProductsCount++;
                        $missedDetails[] = 'Product with sku ' . $MainSku . '( Category Not Found )';
                    }
                }
                if (isset($product) && $product->parent_id != null) {
                    $x = 1;
                    while ((isset($row['option_name_' . $x]) && !empty($row['option_name_' . $x]))) {
                        $option = Option::where('name_en', $row['option_name_' . $x])->first();
                        if ($option) {
                            $value = OptionValue::where('name_en', $row['option_value_' . $x])->where('option_id', $option->id)->first();
                            if ($value) {
                                if ($product && $this->approved == 1) {

                                    $variantOptionValueData = [
                                        'product_id' => $product->id,
                                        'option_id' => $option->id,
                                        'value_id' => $value->id,
                                        'type' => '1'
                                    ];
                                    if ($option->type == 4) {
                                        $variantOptionValueData['image'] = isset($row['option_image_' . $x]) ? $row['option_image_' . $x] : '';
                                    }
                                    $this->approved == 1 ? ProductOptionValues::updateOrCreate($variantOptionValueData) : '';
                                    //$this->approved == 1 ? $product->resetProductVariants() : '';
                                }
                            } else {
                                $totalMissedVariantsCount++;
                                $missedDetails[] = 'variant with sku ' . $VariantSku . '( value ' . $row['option_value_' . $x] . ' Not Found )';
                            }
                        } else {
                            $totalMissedVariantsCount++;
                            $missedDetails[] = 'variant with sku ' . $VariantSku . '( option ' . $row['option_name_' . $x] . ' Not Found )';
                        }
                        $x++;
                    }
                }
                $s = 1;
                if (isset($product) && $product->parent_id == null) {
                    if ($product && $this->approved == 1) {
                        $this->approved == 1 ? ProductOptionValues::where('product_id', $product->id)->delete() : '';
                    }
                    while ((isset($row['attribute_name_' . $s]) && !empty($row['attribute_name_' . $s]))) {
                        $option = Option::where('name_en', $row['attribute_name_' . $s])->first();
                        if ($option) {
                            $subCategoryOption = CategoryOption::where('sub_category_id', $subCategoryID)->where('option_id', $option->id)->first();
                            if ($subCategoryOption) {
                                $value = OptionValue::where('name_en', $row['attribute_value_' . $s])->where('option_id', $option->id)->first();
                                if ($value) {
                                    if ($product && $this->approved == 1) {
                                        $ProductOptionValueData = [
                                            'product_id' => $product->id,
                                            'option_id' => $option->id,
                                            'value_id' => $value->id,
                                            'type' => '0'
                                        ];
                                        if ($option->type == 5) {
                                            $ProductOptionValueData['input_en'] = isset($row['attribute_value_' . $s]) ? $row['attribute_value_' . $s] : '';
                                            $ProductOptionValueData['input_ar'] = isset($row['attribute_value_ar_' . $s]) ? $row['attribute_value_ar_' . $s] : '';
                                        }
                                        $this->approved == 1 ? ProductOptionValues::updateOrCreate($ProductOptionValueData) : '';
                                    }
                                } else {
                                    $totalMissedProductsCount++;
                                    $missedDetails[] = 'Product with sku ' . $MainSku . '( Attribute value ' . $row['attribute_value_' . $s] . ' Not Found )';
                                }
                            } else {
                                $totalMissedProductsCount++;
                                $missedDetails[] = 'Product with sku ' . $MainSku . '( Attribute ' . $row['attribute_name_' . $s] . ' Not added in Sub Category ' . $product->category->name . ')';
                            }
                        } else {
                            $totalMissedProductsCount++;
                            $missedDetails[] = 'Product with sku ' . $MainSku . '( Attribute ' . $row['attribute_name_' . $s] . ' Not Found )';
                        }
                        $s++;
                    }
                }
                if ($product && $this->approved == 1) {
                    if (is_array($productImages) && count($productImages)) {
                        $this->approved == 1 ? $product->images()->delete() : '';
                        foreach ($productImages as $image) {
                            $this->approved == 1 ? $product->images()->create(["url" => $image]) : '';
                        }
                    }
                }
                if (is_array($productTags) && count($productTags)) {
                    if ($product && $this->approved == 1) {
                        $this->approved == 1 ? ProductTag::where('product_id', $product->id)->delete() : '';
                    }
                    foreach ($productTags as $tag) {
                        $tagData = Tag::where("name_en", $tag)->first();
                        if ($tagData) {
                            if ($product && $this->approved == 1) {
                                $data = [
                                    'tag_id' => $tagData->id,
                                    'product_id' => $product->id,
                                ];
                                $this->approved == 1 ? ProductTag::updateOrCreate($data) : '';
                            }
                        } else {
                            $totalMissedProductsCount++;
                            $missedDetails[] = 'Product with sku ' . $MainSku . '( Tag  ' . $tag . ' Not Found )';
                        }
                    }
                }
            }
        }
        $totalApprovedProductsCount = $totalCreatedProductsCount + $totalUpdatedProductsCount;
        $totalApprovedVariantsCount = $totalCreatedVariantsCount + $totalUpdatedVariantsCount;
        $totalApprovedCount = $totalApprovedProductsCount + $totalApprovedVariantsCount;
        $totalMissedCount = $totalMissedProductsCount + $totalMissedVariantsCount;
        $totalCreatedCount = $totalCreatedProductsCount + $totalCreatedVariantsCount;
        $totalUpdatedCount = $totalUpdatedProductsCount + $totalUpdatedVariantsCount;
        return response()->json([
            "code" => 200,
            "message" => "Success",
            "data" => [
                'total_count' => $totalCount,
                'total_product_count' => $totalMainProductCount,
                'total_variant_product_count' => $totalVariantProductCount,
                'total_approved_count' => $totalApprovedCount,
                'total_approved_products_count' => $totalApprovedProductsCount,
                'total_approved_variants_count' => $totalApprovedVariantsCount,
                'total_missed_count' => $totalMissedCount,
                'total_missed_products_count' => $totalMissedProductsCount,
                'total_missed_variants_count' => $totalMissedVariantsCount,
                'total_created_count' => $totalCreatedCount,
                'total_created_products_count' => $totalCreatedProductsCount,
                'total_created_variants_count' => $totalCreatedVariantsCount,
                'total_updated_count' => $totalUpdatedCount,
                'total_updated_products_count' => $totalUpdatedProductsCount,
                'total_updated_variants_count' => $totalUpdatedVariantsCount,
                'missed_details' => $missedDetails,
            ]
        ], 200)->send();
    }

    public function onError(\Throwable $e)
    {

    }

    public function onFailure(Failure ...$failures)
    {

    }
}
