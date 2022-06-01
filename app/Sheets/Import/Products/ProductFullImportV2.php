<?php

namespace App\Sheets\Import\Products;

use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\CategoryOption;
use App\Models\Products\Group;
use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Models\Products\Product;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\ProductPrice;
use App\Models\Products\ProductTag;
use App\Models\Products\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;

class ProductFullImportV2 implements ToCollection, WithHeadingRow, SkipsOnFailure, WithBatchInserts
{
    use SkipsFailures;

    private $approved;
    private $pushService;

    public function __construct($approved = 1, $pushService)
    {
        $this->approved = $approved;
        $this->pushService = $pushService;
    }

    public function collection(Collection $rows)
    {
        //        dd($rows);
        $approved = $this->approved;
        $totalCount = 0;
        $totalMainProductCount = 0;
        $totalVariantProductCount = 0;
        $totalMissedProductsCount = 0;
        $totalMissedVariantsCount = 0;
        $totalCreatedProductsCount = 0;
        $totalCreatedVariantsCount = 0;
        $totalUpdatedVariantsCount = 0;
        $totalUpdatedProductsCount = 0;
        $missedDetails = [];
        $mainSkuArray = [];
        $productsHasZeroPrice = [];

        if (!empty($rows)) {
            foreach ($rows as $rowKey => $row) {

                if($row['price'] == 0){
                    $productsHasZeroPrice[] = $row['main_sku'];
                    continue;
                }

                Log::info("Row: {$rowKey}");
                if (isset($row["main_sku"]) && is_float($row['main_sku'])) {
                    $MainSku = (int)$row['main_sku'];
                } elseif (isset($row["main_sku"])) {
                    $MainSku = $row['main_sku'];
                }

                $productNameEn = isset($row['name']) && !empty($row['name']) ? $row['name'] : '';
                $VariantSku = isset($row['variant_sku']) && !empty($row['variant_sku']) ? $row['variant_sku'] : '';
                $productNameAr = isset($row['name_ar']) && !empty($row['name_ar']) ? $row['name_ar'] : '';
                $productDescriptionEn = isset($row['description']) && !empty($row['description']) ? $row['description'] : '';
                $productDescriptionAr = isset($row['description_ar']) && !empty($row['description_ar']) ? $row['description_ar'] : '';
                $productLongDescriptionEn = isset($row['long_description_en']) && !empty($row['long_description_en']) ? $row['long_description_en'] : '';
                $productLongDescriptionAr = isset($row['long_description_ar']) && !empty($row['long_description_ar']) ? $row['long_description_ar'] : '';
                $productmeta_title = isset($row['meta_title']) && !empty($row['meta_title']) ? $row['meta_title'] : '';
                $productmeta_title_ar = isset($row['meta_title_ar']) && !empty($row['meta_title_ar']) ? $row['meta_title_ar'] : '';
                $productmeta_description = isset($row['meta_description']) && !empty($row['meta_description']) ? $row['meta_description'] : '';
                $productmeta_description_ar = isset($row['meta_description_ar']) && !empty($row['meta_description_ar']) ? $row['meta_description_ar'] : '';
                $productkeywords = isset($row['keywords']) && !empty($row['keywords']) ? $row['keywords'] : '';
                $productMainImage = isset($row['main_image']) && !empty($row['main_image']) ? $row['main_image'] : '';
                $productActive = isset($row['active']) ? (int) $row['active'] : 0;
                $productPreorder = isset($row['preorder']) && !empty($row['preorder']) ? $row['preorder'] : 0;
                $preorderStartDate = isset($row['preorder_start_date']) && !empty($row['preorder_start_date']) && $row['preorder_start_date'] > 0 ? $row['preorder_start_date'] : null;
                $preorderEndDate = isset($row['preorder_start_date']) && !empty($row['preorder_start_date']) && $row['preorder_start_date'] > 0 ? $row['preorder_start_date'] : null;
                // $productPreorderPrice = isset($row['preorder_price']) && !empty($row['preorder_price']) ? $row['preorder_price'] : null;
                $productWeight = isset($row['weight']) && !empty($row['weight']) ? $row['weight'] : null;
                $productSubtractStock = isset($row['subtract_stock']) && !empty($row['subtract_stock']) ? $row['subtract_stock'] : 1;
                $productStock = isset($row['stock']) && !empty($row['stock']) && ($row['stock']) > 0 ? $row['stock'] : 0;
                $productBarcode = isset($row['barcode']) && !empty($row['barcode']) ? $row['barcode'] : '';
                $productPrice = isset($row['price']) && !empty($row['price']) && $row['price'] > 0 ? $row['price'] : null;
                $productOrder = isset($row['order']) && !empty($row['order']) ? $row['order'] : 0;
                $type = isset($row['type']) && !empty($row['type']) ? $row['type'] : 1;
                $has_stock = isset($row['has_stock']) && !empty($row['has_stock']) ? $row['has_stock'] : 0;
                $bundle_checkout = isset($row['bundle_checkout']) && !empty($row['bundle_checkout']) ? $row['bundle_checkout'] : 0;
                $productDiscountPrice = isset($row['discount_price']) && !empty($row['discount_price']) && $row['discount_price'] > 0 ? $row['discount_price'] : null;
                $discountStartDate = isset($row['discount_start_date']) && !empty($row['discount_start_date']) && $row['discount_start_date'] > 0 ? $row['discount_start_date'] : null;
                $discountEndDate = isset($row['discount_end_date']) && !empty($row['discount_end_date']) && $row['discount_end_date'] > 0 ? $row['discount_end_date'] : null;
                $productTags = isset($row['tags']) && !empty($row['tags']) ? explode(',', $row['tags']) : '';
                $relatedSkus = isset($row['related_skus']) && !empty($row['related_skus']) ? explode(',', $row['related_skus']) : [];
                $bundleSkus = isset($row['bundle_skus']) && !empty($row['bundle_skus']) ? explode(',', $row['bundle_skus']) : [];
                $productImages = isset($row['images']) && !empty($row['images']) ? explode(',', $row['images']) : '';

                $categoryOptional = isset($row['category_optional']) && !empty($row['category_optional']) ? $row['category_optional'] : null;
                $subcategoryOptional = isset($row['subcategory_optional']) && !empty($row['subcategory_optional']) ? $row['subcategory_optional'] : null;

                $brandID = null;
                $subCategoryID = null;
                $product = null;
                $variantProduct = null;
                $mainProduct = null;
                $totalCount++;

                if (filter_var($productMainImage, FILTER_VALIDATE_URL) === FALSE) {
                    $productMainImage = str_replace(' ', '-', $productMainImage);
                    $productMainImage = url("storage/uploads/" . $productMainImage);
                }

                if (isset($row['main_sku']) && $row['main_sku'] != null) {
                    $productData = [
                        "sku" => $MainSku,
                        "name" => $productNameEn,
                        "name_ar" => $productNameAr,
                        "description" => $productDescriptionEn,
                        "description_ar" => $productDescriptionAr,
                        "long_description_en" => $productLongDescriptionEn,
                        "long_description_ar" => $productLongDescriptionAr,
                        "meta_title" => $productmeta_title,
                        "meta_description" => $productmeta_description,
                        "keywords" => $productkeywords,
                        "preorder" => $productPreorder,
                        "preorder_start_date" => $preorderStartDate,
                        "preorder_end_date" => $preorderEndDate,
                        // "preorder_price" => $productPreorderPrice,
                        "image" => $productMainImage,
                        "weight" => $productWeight,
                        "stock" => $productStock,
                        "barcode" => $productBarcode,
                        "active" => $productActive,
                        "subtract_stock" => $productSubtractStock,
                        "category_optional" => $categoryOptional,
                        "subcategory_optional" => $subcategoryOptional,
                        "price" => null,
                        "order" => $productOrder,
                        "type" => $type,
                        "has_stock" => $has_stock,
                        "bundle_checkout" => $bundle_checkout,
                        "discount_price" => null,
                    ];

                    $productVariantData = [
                        "sku" => $VariantSku,
                        "name" => $productNameEn,
                        "name_ar" => $productNameAr,
                        "description" => $productDescriptionEn,
                        "description_ar" => $productDescriptionAr,
                        "long_description_en" => $productLongDescriptionEn,
                        "long_description_ar" => $productLongDescriptionAr,
                        "meta_title" => $productmeta_title,
                        "meta_title_ar" => $productmeta_title_ar,
                        "meta_description" => $productmeta_description,
                        "meta_description_ar" => $productmeta_description_ar,
                        "keywords" => $productkeywords,
                        "preorder" => $productPreorder,
                        "weight" => $productWeight,
                        "image" => $productMainImage,
                        "stock" => $productStock,
                        "barcode" => $productBarcode,
                        "active" => $productActive,
                        "price" => $productPrice,
                        "order" => $productOrder,
                        "discount_price" => $productDiscountPrice,
                        "discount_start_date" => $discountStartDate,
                        "discount_end_date" => $discountEndDate
                    ];
                    $priceInstance = [
                        'price' => $productPrice,
                        "discount_price" => $productDiscountPrice,
                        "discount_start_date" => $discountStartDate,
                        "discount_end_date" => $discountEndDate
                    ];

                    $mainProduct = Product::where('sku', $MainSku)->first();

                    /*********************
                     *    Category       *
                     *********************/
                    $subCategoryID = $this->getSubCategory($row);
                    $productData['category_id'] = $subCategoryID;
                    $productVariantData['category_id'] = $subCategoryID;

                    /***************************
                     *    Category Optional    *
                     **************************/
                    $subCategoryOptionalID = $this->getSubCategoryOptional($row);
                    if ($subCategoryOptionalID) {
                        $productData['optional_sub_category_id'] = $subCategoryOptionalID;
                        $productVariantData['optional_sub_category_id'] = $subCategoryOptionalID;
                    }

                    /*********************
                     *      Brand        *
                     *********************/
                    $brand = $this->getBrand($row);
                    if ($brand) {
                        $productData['brand_id'] = $brand->id;
                        $productVariantData['brand_id'] = $brand->id;
                    }

                    if (!in_array($MainSku, $mainSkuArray)) {
                        if ($mainProduct) {
                            $totalCreatedProductsCount++;
                            $approved == 1 ? $mainProduct->update($productData) : '';
                            $priceInstance['product_id'] = $mainProduct->id;
                            $approved == 1 ? ProductPrice::create($priceInstance) : '';
                        } else {
                            $totalUpdatedProductsCount++;
                            $approved == 1 ? $mainProduct = Product::create($productData) : '';
                            // dd($mainProduct);
                            $priceInstance['product_id'] = $mainProduct->id;
                            $approved == 1 ? ProductPrice::create($priceInstance) : '';
                        }

                        $mainSkuArray[] = $MainSku;
                    }

                    if ($row['variant_sku'] != null) {
                        $totalVariantProductCount++;
                        $productVariantData['parent_id'] = $mainProduct->id;
                        $variantProduct = Product::where('sku', $VariantSku)->first();
                        if ($variantProduct) {
                            $totalUpdatedVariantsCount++;
                            $approved == 1 ? $variantProduct->update($productVariantData) : '';
                        } else {
                            $totalCreatedVariantsCount++;
                            $approved == 1 ? $variantProduct = Product::create($productVariantData) : '';
                        }
                        $priceInstance['product_id'] = $variantProduct->id;
                        $approved == 1 ? ProductPrice::create($priceInstance) : '';
                    }

                    /*********************
                     *      Options      *
                     *********************/
                    if (isset($variantProduct)) {
                        $x = 1;
                        $approved == 1 ? ProductOptionValues::where('product_id', $variantProduct->id)->where("type", '1')->delete() : '';
                        $approved == 1 ? ProductOptionValues::where('product_id', $mainProduct->id)->where("type", '1')->delete() : '';
                        while ((isset($row['option_name_' . $x]) && !empty($row['option_name_' . $x]))) {
                            $option = Option::updateOrCreate(['name_en' => trim($row['option_name_' . $x])]);

                            if ($option) {

                                if ($x == 1) {
                                    // make first option the default
                                    $mainProduct->update(["option_default_id" => $option->id]);
                                    $variantProduct->update(["option_default_id" => $option->id]);
                                }

                                $value = OptionValue::where('name_en', trim($row['option_value_' . $x]))->where('option_id', $option->id)->first();
                                if (!$value && $option->type != 5) {
                                    $value = OptionValue::create(['name_en' => trim($row['option_value_' . $x]), 'name_ar' => isset($row['option_value_ar_' . $x]) ? trim($row['option_value_ar_' . $x]) : trim($row['option_value_' . $x]), 'option_id' => $option->id]);
                                }
                                if ($approved == 1) {
                                    $variantOptionValueData = [
                                        'product_id' => $variantProduct->id,
                                        'option_id' => $option->id,
                                        'type' => '1'
                                    ];

                                    if ($option->type == 4 && $value) {
                                        $variantOptionValueData['value_id'] = $value ? $value->id : null;
                                        $image = isset($row['option_image_' . $x]) ? $row['option_image_' . $x] : '';
                                        if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
                                            $image = str_replace(' ', '-', $image);
                                            $image = url("storage/uploads/" . $image);
                                        }
                                        $variantOptionValueData['image'] = isset($row['option_image_' . $x]) ? $image : '';
                                        $approved == 1 ? ProductOptionValues::updateOrCreate(['product_id' => $variantProduct->id, 'option_id' => $option->id], $variantOptionValueData) : '';
                                    } elseif ($value) {
                                        $variantOptionValueData['value_id'] = $value->id;
                                        $approved == 1 ? ProductOptionValues::updateOrCreate(['product_id' => $variantProduct->id, 'option_id' => $option->id], $variantOptionValueData) : '';
                                    } else {
                                        $totalMissedVariantsCount++;
                                        $missedDetails[] = 'variant with sku ' . $VariantSku . '( value ' . $row['option_value_' . $x] . ' Not Found )';
                                    }

                                }
                            } else {
                                $totalMissedVariantsCount++;
                                $missedDetails[] = 'variant with sku ' . $VariantSku . '( option ' . $row['option_name_' . $x] . ' Not Found )';
                            }

                            $x++;
                        }

                        $mainOptions = $mainProduct->variantOptions()->where('product_option_values.type', "1")->groupBy("option_id")->get();
                        foreach ($mainOptions as $mainOption) {
                            $pov = ProductOptionValues::where("product_id", $mainProduct->id)->where("option_id", $mainOption->option_id)->first();
                            if (!$pov) {
                                ProductOptionValues::updateOrCreate(['product_id' => $mainProduct->id, 'option_id' => $mainOption->option_id, 'value_id' => $mainOption->value_id, 'type' => $mainOption->type]);
                            }
                        }
                    }

                    /*********************
                     *    Attributes     *
                     *********************/
                    if (isset($variantProduct)) {
                        $s = 1;
                        $approved == 1 ? ProductOptionValues::where('product_id', $variantProduct->id)->where("type", '0')->delete() : '';
                        $subCategoryID = $variantProduct->parent->category->id;
                        while ((isset($row['attribute_name_' . $s]) && !empty($row['attribute_name_' . $s]))) {
                            $option = Option::updateOrCreate(['name_en' => $row['attribute_name_' . $s]]);
                            if ($option) {
                                if (isset($row['attribute_value_' . $s]) && $row['attribute_value_ar_' . $s]) {
                                    $subCategoryOption = CategoryOption::updateOrCreate(['sub_category_id' => $subCategoryID], ['option_id' => $option->id]);
                                    if ($subCategoryOption) {
                                        $value = OptionValue::where('name_en', $row['attribute_value_' . $s])->where('option_id', $option->id)->first();
                                        $ProductOptionValueData = [
                                            'product_id' => $variantProduct->id,
                                            'option_id' => $option->id,
                                            'type' => '0'
                                        ];
                                        if (!$value && $option->type != 5) {
                                            $value = OptionValue::create(['name_en' => trim($row['attribute_value_' . $s]), 'name_ar' => trim($row['attribute_value_ar_' . $s]), 'option_id' => $option->id]);
                                        }
                                        if ($option->type == 5) {
                                            $ProductOptionValueData['input_en'] = isset($row['attribute_value_' . $s]) ? $row['attribute_value_' . $s] : '';
                                            $ProductOptionValueData['input_ar'] = isset($row['attribute_value_ar_' . $s]) ? $row['attribute_value_ar_' . $s] : '';
                                            $approved == 1 ? ProductOptionValues::updateOrCreate($ProductOptionValueData) : '';
                                        } else {
                                            if ($value) {
                                                $ProductOptionValueData['value_id'] = $value->id;
                                                $approved == 1 ? ProductOptionValues::updateOrCreate($ProductOptionValueData) : '';
                                            } else {
                                                ProductOptionValues::where('product_id', $variantProduct->id)->where('option_id', $option->id)->where('type', '0')->delete();
                                                $totalMissedProductsCount++;
                                                $missedDetails[] = 'Product with sku ' . $MainSku . '( Attribute value ' . $row['attribute_value_' . $s] . ' Not Found )';
                                            }
                                        }
                                    } else {
                                        $totalMissedProductsCount++;
                                        $missedDetails[] = 'Product with sku ' . $MainSku . '( Attribute ' . $row['attribute_name_' . $s] . ' Not added in Sub Category ' . $mainProduct->category->name . ' with ID ' . $subCategoryID . ' and option ID ' . $option->id . ')';
                                    }
                                } else {
                                    ProductOptionValues::where('product_id', $variantProduct->id)->where('option_id', $option->id)->where('type', '0')->delete();
                                }
                            } else {
                                $totalMissedProductsCount++;
                                $missedDetails[] = 'Product with sku ' . $MainSku . '( Attribute ' . $row['attribute_name_' . $s] . ' Not Found )';
                            }

                            $s++;
                        }
                    }

                    /*********************
                     *      Tags         *
                     *********************/
                    if (is_array($productTags) && count($productTags)) {
                        if ($mainProduct && $approved == 1) {
                            ProductTag::where('product_id', $mainProduct->id)->delete();
                        }

                        foreach ($productTags as $tag) {
                            $tagData = Tag::updateOrCreate(["name_en" => $tag]);
                            if ($mainProduct && $approved == 1) {
                                ProductTag::updateOrCreate(['tag_id' => $tagData->id, 'product_id' => $mainProduct->id,]);
                            }
                        }
                    }

                    if (count($relatedSkus)) {
                        $mainProduct->relatedSkus()->delete();
                        foreach ($relatedSkus as $sku) {
                            $mainProduct->relatedSkus()->create(["sku" => $sku]);
                        }
                    }

                    $variantProduct->bundleProduct()->delete();

                    if (count($bundleSkus)) {
                        Log::info($bundleSkus);
                        foreach ($bundleSkus as $bsku) {
                            $bundleProduct = Product::where("sku", $bsku)->first();
                            Log::info("PRODUCT: ", ["sku" => $bsku, "id" => $bundleProduct ? $bundleProduct->id : null, "variant" => $variantProduct->sku]);
                            if ($bundleProduct) {
                                $variantProduct->bundleProduct()->attach($bundleProduct->id);
                            }
                        }
                    }

                    isset($variantProduct) ? $product = $variantProduct : $product = $mainProduct;
                    if (isset($product) && $approved == 1 && (is_array($productImages) && count($productImages))) {
                        $product->images()->delete();
                        foreach ($productImages as $image) {
                            if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
                                $image = str_replace(' ', '-', $image);
                                $image = url("storage/uploads/" . $image);
                            }

                            $product->images()->create(["url" => $image]);
                        }
                    }
                }

                Log::info("Imported Row: " . $rowKey);
            }
        }

        $totalApprovedProductsCount = $totalCreatedProductsCount + $totalUpdatedProductsCount;
        $totalApprovedVariantsCount = $totalCreatedVariantsCount + $totalUpdatedVariantsCount;
        $totalApprovedCount = $totalApprovedProductsCount + $totalApprovedVariantsCount;
        $totalMissedCount = $totalMissedProductsCount + $totalMissedVariantsCount;
        $totalCreatedCount = $totalCreatedProductsCount + $totalCreatedVariantsCount;
        $totalUpdatedCount = $totalUpdatedProductsCount + $totalUpdatedVariantsCount;

        $data = [
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
            'product_has_zero_price' => $productsHasZeroPrice
        ];

        Log::info("IMPORT FINISHED");
        Artisan::call('cache:clear');

        $this->pushService->notifyAdmins("File Imported", "Your import has completed! You can check the result from", '', 10, json_encode($data), auth()->user()->id);

        return response()->json([
            "code" => 200,
            "message" => "Success",
            "data" => $data
        ], 200)->send();
    }

    public function getSubCategory($row)
    {
        if (empty($row['category']) || empty($row['subcategory'])) {
            return null;
        }

        /*********************
         *    Category       *
         *********************/
        $categoryUpdate = ['active' => 1];

        if (isset($row['category_ar'])) {
            $categoryUpdate['name_ar'] = $row['category_ar'];
        }

        if (isset($row['category_description'])) {
            $categoryUpdate['description'] = $row['category_description'];
        }

        if (isset($row['category_description_ar'])) {
            $categoryUpdate['description_ar'] = $row['category_description_ar'];
        }

        if (isset($row['category_image'])) {
            $categoryUpdate['image'] = $row['category_image'];
        }

        if (isset($row['category_order'])) {
            $categoryUpdate['order'] = (int) $row['category_order'];
        }

        $categoryUpdateChecking = ['name' => $row['category']];
        if (isset($row['category_slug'])) {
            if (empty($row['category_slug'])) {
                $categoryUpdateChecking['slug'] = $row['category'] . '_' . now()->timestamp;
            } else {
                $categoryUpdateChecking['slug'] = $row['category_slug'];
            }
        }

        $checkCategory = Category::updateOrCreate($categoryUpdateChecking, $categoryUpdate);

        /**********************
         *   Sub Category     *
         *********************/
        $subCategoryUpdate = ['active' => 1];

        if (isset($row['subcategory_ar'])) {
            $subCategoryUpdate['name_ar'] = $row['subcategory_ar'];
        }

        if (isset($row['subcategory_description'])) {
            $subCategoryUpdate['description'] = $row['subcategory_description'];
        }

        if (isset($row['subcategory_description_ar'])) {
            $subCategoryUpdate['description_ar'] = $row['subcategory_description_ar'];
        }

        if (isset($row['subcategory_image'])) {
            $subCategoryUpdate['image'] = $row['subcategory_image'];
        }

        if (isset($row['subcategory_order'])) {
            $subCategoryUpdate['order'] = (int) $row['subcategory_order'];
        }

        $subCategoryUpdateChecking = ['name' => $row['subcategory'], 'parent_id' => $checkCategory->id];
        if (isset($row['subcategory_slug'])) {
            if (empty($row['subcategory_slug'])) {
                $subCategoryUpdateChecking['slug'] = $row['subcategory'] . '_' . now()->timestamp;
            } else {
                $subCategoryUpdateChecking['slug'] = $row['subcategory_slug'];
            }
        }

        $getSubCategory = Category::updateOrCreate($subCategoryUpdateChecking, $subCategoryUpdate);

        if (!empty($row['group'])) {

            /**********************
             *   Sub Category     *
             *********************/
            $groupUpdate = ['active' => 1];

            if (isset($row['group_ar'])) {
                $groupUpdate['name_ar'] = $row['group_ar'];
            }

            if (isset($row['group_description'])) {
                $groupUpdate['description'] = $row['group_description'];
            }

            if (isset($row['group_description_ar'])) {
                $groupUpdate['description_ar'] = $row['group_description_ar'];
            }

            if (isset($row['group_image'])) {
                $groupUpdate['image'] = $row['group_image'];
            }

            if (isset($row['group_order'])) {
                $groupUpdate['order'] = (int) $row['group_order'];
            }

            $groupUpdateChecking = ['name_en' => $row['group']];
            if (isset($row['group_slug'])) {
                if (empty($row['group_slug'])) {
                    $groupUpdateChecking['slug'] = $row['group'] . '_' . now()->timestamp;
                } else {
                    $groupUpdateChecking['slug'] = $row['group_slug'];
                }
            }

            $getGroup = Group::updateOrCreate($groupUpdateChecking, $groupUpdate);
            $checkCategory->groupSubCategory()->updateOrCreate(['group_id' => $getGroup->id, 'category_id' => $checkCategory->id, 'sub_category_id' => $getSubCategory->id]);
        }

        return $getSubCategory->id;
    }

    public function getSubCategoryOptional($row)
    {
        if (empty($row['category_optional']) || empty($row['subcategory_optional'])) {
            return null;
        }

        /*********************
         *    Category       *
         *********************/
        $categoryUpdate = ['active' => 1];

        if (isset($row['category_ar_optional'])) {
            $categoryUpdate['name_ar'] = $row['category_ar_optional'];
        }

        if (isset($row['category_description_optional'])) {
            $categoryUpdate['description'] = $row['category_description_optional'];
        }

        if (isset($row['category_description_ar_optional'])) {
            $categoryUpdate['description_ar'] = $row['category_description_ar_optional'];
        }

        if (isset($row['category_image_optional'])) {
            $categoryUpdate['image'] = $row['category_image_optional'];
        }

        if (isset($row['category_order_optional'])) {
            $categoryUpdate['order'] = (int) $row['category_order_optional'];
        }

        $categoryUpdateChecking = ['name' => $row['category_optional']];
        if (isset($row['category_slug_optional'])) {
            if (empty($row['category_slug_optional'])) {
                $categoryUpdateChecking['slug'] = $row['category_optional'] . '_' . now()->timestamp;
            } else {
                $categoryUpdateChecking['slug'] = $row['category_slug_optional'];
            }
        }

        $checkCategory = Category::updateOrCreate($categoryUpdateChecking, $categoryUpdate);

        /**********************
         *   Sub Category     *
         *********************/
        $subCategoryUpdate = ['active' => 1];

        if (isset($row['subcategory_ar_optional'])) {
            $subCategoryUpdate['name_ar'] = $row['subcategory_ar_optional'];
        }

        if (isset($row['subcategory_description_optional'])) {
            $subCategoryUpdate['description'] = $row['subcategory_description_optional'];
        }

        if (isset($row['subcategory_description_ar_optional'])) {
            $subCategoryUpdate['description_ar'] = $row['subcategory_description_ar_optional'];
        }

        if (isset($row['subcategory_image_optional'])) {
            $subCategoryUpdate['image'] = $row['subcategory_image_optional'];
        }

        if (isset($row['subcategory_order_optional'])) {
            $subCategoryUpdate['order'] = $row['subcategory_order_optional'];
        }

        $subCategoryUpdateChecking = ['name' => $row['subcategory_optional'], 'parent_id' => $checkCategory->id];
        if (isset($row['category_slug_optional'])) {
            if (empty($row['category_slug_optional'])) {
                $subCategoryUpdateChecking['slug'] = $row['subcategory_optional'] . '_' . now()->timestamp;
            } else {
                $subCategoryUpdateChecking['slug'] = $row['category_slug_optional'];
            }
        }

        $getSubCategory = Category::updateOrCreate($subCategoryUpdateChecking, $subCategoryUpdate);

        return $getSubCategory->id;
    }

    public function getBrand($row)
    {
        if (empty($row['brand'])) {
            return null;
        }

        return Brand::updateOrCreate(["name" => $row['brand']], ["name_ar" => $row['brand_ar']]);
    }

    public function batchSize(): int
    {
        return 100;
    }
    //    public function chunkSize(): int
    //    {
    //        return 100000;
    //    }
    public function onError(\Throwable $e)
    {

    }

    public function onFailure(Failure ...$failures)
    {

    }
}
