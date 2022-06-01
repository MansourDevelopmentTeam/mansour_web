<?php

namespace App\Sheets\Import\Products;

use App\Models\Inventories\Inventory;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\CategoryOption;
use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Models\Products\Product;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\ProductPrice;
use App\Models\Products\ProductTag;
use App\Models\Products\Tag;
use App\Models\Retails\RetailDraft;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;

class ProductFullImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure, WithBatchInserts
{
    use SkipsFailures;

    private $approved;
    public $reportData;
    public $status;
    public $statusCode;
    public $errorMessage;

    public function __construct($history_id, $approved = 1)
    {
        parent::__construct();
        $this->history_id = $history_id;
    }
    // public function __construct($approved = 1, $pushService)
    // {
    //     $this->approved = $approved;
    //     $this->pushService = $pushService;
    // }

    public function collection(Collection $rows)
    {

        $approved = 1; //$this->approved;
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
        $index = 0;
        try {
            foreach ($rows as $rowKey => $row) {
                $rowNumber = $rowKey + 2;
                if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {

                    if ($row['price'] == 0) {
                        $productsHasZeroPrice[] = $row['main_sku'];
                        continue;
                    }

                    Log::info("Row: {$rowNumber}");
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
                    $productActive = isset($row['active']) ? $row['active'] : 1;
                    $productFreeDelivery = isset($row['free_delivery']) ? $row['free_delivery'] : 0;
                    $productPreorder = isset($row['preorder']) && !empty($row['preorder']) ? $row['preorder'] : 0;
                    $preorderStartDate = isset($row['preorder_start_date']) && !empty($row['preorder_start_date']) && $row['preorder_start_date'] > 0 ? $row['preorder_start_date'] : null;
                    $preorderEndDate = isset($row['preorder_end_date']) && !empty($row['preorder_end_date']) && $row['preorder_end_date'] > 0 ? $row['preorder_end_date'] : null;
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
                    if (isset($row['main_sku']) && !empty($row['main_sku'])) {
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
                            "free_delivery" => $productFreeDelivery,
                            "subtract_stock" => $productSubtractStock,
                            "category_id" => $categoryOptional,
                            "optional_sub_category_id" => $subcategoryOptional,
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
                            "free_delivery" => $productFreeDelivery,
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
                        if (isset($row['subcategory_slug']) && !empty($row['subcategory_slug'])) {
                            $subCategory = Category::whereNotNull("parent_id")->where("slug", $row['subcategory_slug'])->first();
                            if ($subCategory) {
                                $subCategoryID = $subCategory->id;
                            }
                        } else {
                            if (isset($row['subcategory']) && !empty($row['subcategory']) && isset($row['category']) && !empty($row['category'])) {
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
                        if (isset($row['brand']) && !empty($row['brand'])) {
                            $brandData = Brand::where("name", $row['brand'])->first();
                            if ($brandData) {
                                $brandID = $brandData->id;
                                $productData['brand_id'] = $brandID;
                                $productVariantData['brand_id'] = $brandID;
                            } else {
                                $totalMissedProductsCount++;
                                $missedDetails[] = 'variant with sku ' . $MainSku . '( Brand Not Found )';
                            }
                        }
                        if (!$subCategoryID) {
                            $totalMissedProductsCount++;
                            $missedDetails[] = 'variant with sku ' . $MainSku . '( Category Not Found )';
                            continue;
                        } else {
                            $productData['category_id'] = $subCategoryID;
                            $productVariantData['category_id'] = $subCategoryID;
                        }
                        if (isset($row['category_optional'], $row['subcategory_optional'])) {
                            $optionalSubCategory = Category::where('name', $subcategoryOptional)
                                ->whereHas('parent', function ($q) use ($categoryOptional) {
                                    $q->where('name', $categoryOptional);
                                })->first();
                            $productData['optional_sub_category_id'] = optional($optionalSubCategory)->id;
                            $productVariantData['optional_sub_category_id'] = optional($optionalSubCategory)->id;
                        }
                        if (!in_array($MainSku, $mainSkuArray)) {
                            if ($mainProduct) {
                                $totalCreatedProductsCount++;
                                $approved == 1 ? $mainProduct->update($productData) : '';
                                $approved == 1 ? $index++ : null;
                                $priceInstance['product_id'] = $mainProduct->id;
                                $approved == 1 ? ProductPrice::create($priceInstance) : '';
                            } else {
                                $totalUpdatedProductsCount++;
                                $approved == 1 ? $mainProduct = Product::create($productData) : '';
                                $approved == 1 ? $index++ : null;
                                $priceInstance['product_id'] = $mainProduct->id;
                                $approved == 1 ? ProductPrice::create($priceInstance) : '';
                            }
                            $mainSkuArray[] = $MainSku;
                        }
                        if (isset($row['variant_sku']) && !empty($row['variant_sku'])) {
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
                        if (isset($variantProduct)) {
                            $x = 1;
                            $approved == 1 ? ProductOptionValues::where('product_id', $variantProduct->id)->where("type", '1')->delete() : '';
                            $approved == 1 ? ProductOptionValues::where('product_id', $mainProduct->id)->where("type", '1')->delete() : '';
                            while ((isset($row['option_name_' . $x]) && !empty($row['option_name_' . $x]))) {
                                $option = Option::where('name_en', trim($row['option_name_' . $x]))->first();

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
                        if (isset($variantProduct)) {
                            $s = 1;
                            $approved == 1 ? ProductOptionValues::where('product_id', $variantProduct->id)->where("type", '0')->delete() : '';
                            $subCategoryID = $variantProduct->parent->category->id;
                            while ((isset($row['attribute_name_' . $s]) && !empty($row['attribute_name_' . $s]))) {
                                $option = Option::where('name_en', $row['attribute_name_' . $s])->first();
                                if ($option) {
                                    if (isset($row['attribute_value_' . $s]) && $row['attribute_value_ar_' . $s]) {

                                        $subCategoryOption = CategoryOption::where('sub_category_id', $subCategoryID)->where('option_id', $option->id)->first();
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
                            $variantProduct->bundleProduct()->delete();
                            if (count($bundleSkus)) {
                                Log::info($bundleSkus);
                                foreach ($bundleSkus as $bsku) {
                                    $bundleProduct = Product::where("sku", $bsku)->first();
                                    // Log::info("PRODUCT: ", ["sku" => $bsku, "id" => $bundleProduct ? $bundleProduct->id : null, "variant" => $variantProduct->sku]);
                                    if ($bundleProduct) {
                                        $variantProduct->bundleProduct()->attach($bundleProduct->id);
                                    }
                                }
                            }
                        }
                        if (is_array($productTags) && count($productTags)) {
                            if ($mainProduct && $approved == 1) {
                                $approved == 1 ? ProductTag::where('product_id', $mainProduct->id)->delete() : '';
                            }
                            foreach ($productTags as $tag) {
                                $tagData = Tag::where("name_en", $tag)->first();
                                if ($tagData) {
                                    if ($mainProduct && $approved == 1) {
                                        $data = [
                                            'tag_id' => $tagData->id,
                                            'product_id' => $mainProduct->id,
                                        ];
                                        $approved == 1 ? ProductTag::updateOrCreate($data) : '';
                                    }
                                } else {
                                    $totalMissedProductsCount++;
                                    $missedDetails[] = 'Product with sku ' . $MainSku . '( Tag  ' . $tag . ' Not Found )';
                                }
                            }
                        }
                        if (count($relatedSkus)) {
                            $mainProduct->relatedSkus()->delete();
                            foreach ($relatedSkus as $sku) {
                                $mainProduct->relatedSkus()->create(["sku" => $sku]);
                            }
                        }
                        isset($variantProduct) ? $product = $variantProduct : $product = $mainProduct;
                        if (isset($product) && $approved == 1) {
                            if (is_array($productImages) && count($productImages)) {
                                $approved == 1 ? $product->images()->delete() : '';
                                foreach ($productImages as $image) {
                                    if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
                                        $image = str_replace(' ', '-', $image);
                                        $image = url("storage/uploads/" . $image);
                                    }
                                    $approved == 1 ? $product->images()->create(["url" => $image]) : '';
                                }
                            }
                        }
                        Log::info("Imported Row: " . $rowNumber);
                    }

                    $progress = floor(($index / count($rows)) * 100);
                    $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
                    $this->status = 'success';
                } else {
                    $this->status = 'cancelled';
                    Log::channel('imports')->info('Import Canceled');
                    break;
                }
            }
            
            $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);

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
            // $this->pushService->notifyAdmins("File Imported", "Your import has completed! You can check the result from", '', 10, json_encode($data), auth()->user()->id);

            $this->statusCode = '200';
            $this->reportData = $data;
            $this->errorMessage = null;
            return $data;
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = [];
            $this->errorMessage = $e->getMessage();
            Log::channel('imports')->error($e->getMessage());
            // Log::channel('imports')->error($e->getTrace());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $this->history_id);
        }
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

    public function import($file, $history_id)
    {
        // TODO: Implement import() method.
    }
}
