<?php

namespace App\Sheets\Export\Products;

use App\Models\Inventories\Inventory;
use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Models\Products\Product;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\SubCategoryGroup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsFullExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    private $products;
    private $attributes;
    private $attributesCount;
    private $optionsCount;
    private $inventories;
    private $inventoriesNames;

    public function __construct(Request $request)
    {
        $attributesCount = 0;
        $optionsCount = 0;
        $products = Product::query();
        $products->when(isset($request->sub_category_id) && !empty(isset($request->sub_category_id)), function ($q) use ($request) {
            $q->where('category_id', $request->sub_category_id);
        });
        $fileName = 'products_' . date("Y-m-d-H-i-s");
        $products = $products->MainProduct()->with('ProductOptionValues', 'productVariantOptions', 'brand', 'category', 'category.parent', 'category.group', 'tags', 'images', 'productVariants', 'productVariants.images')->get();

        $attributes = Option::all();

        // $productAttributesMaxCount = Product::withCount('ProductOptions')->orderBy('product_options_count', 'DESC')->first();
        $productVariantOptionsMaxCount = Product::withCount('productVariantOptions')->where('parent_id', '!=', null)->orderBy('product_variant_options_count', 'DESC')->first();

        $this->optionsCount = $productVariantOptionsMaxCount ? $productVariantOptionsMaxCount->product_variant_options_count : $optionsCount;
        // $this->attributesCount = $productAttributesMaxCount ? $productAttributesMaxCount->product_options_count : $attributesCount;
        $this->attributes = $attributes;
        $this->attributesCount = $attributes->count();

        $this->products = $products;
    }

    public function collection()
    {

        return $this->products;
    }


    public function map($item): array
    {


        // Log::info("Exporting Row: {$key}");
        $category = $item->category ? $item->category->parent : "";
        $subCategory = $item->category ? $item->category : "";
        $brandName = $item->brand ? $item->brand->name : "";
        $group = isset($item->category->group[0]) ? $item->category->group[0]->name_en : "";
        $tags = $item->tags->pluck('name_en')->implode(',');
        $images = $item->images->pluck('url')->implode(',');
        $variants = [];
        $relatedSkus = implode(',', $item->relatedSkus->pluck('sku')->toArray());
        $bundleSkus = implode(',', $item->bundleProduct->pluck('sku')->toArray());
        $i = 0;
        $attributesData = [];
        // if (!empty($attributes)) {
        //     $s = 0;
        //     $attributesData = [];

        foreach ($this->attributes  as $attribute) {
            // $productAttribute = $attribute->whereHas('attributeProducts', function ($q) use ($item) {
            //     $q->where('products.id',$item->id);
            // })->first();
            $productAttributePivot = ProductOptionValues::where('option_id', $attribute->id)->where('product_id', $item->id)->where('type', '0')->first();
            array_push($attributesData, $attribute->name_en);
            if ($productAttributePivot) {
                if ($attribute->type == 5) {
                    array_push($attributesData, $productAttributePivot->input_en);
                    array_push($attributesData, $productAttributePivot->input_ar);
                } else {
                    $value = OptionValue::find($productAttributePivot->value_id);
                    if ($value) {
                        array_push($attributesData, $value->name_en);
                        array_push($attributesData, $value->name_ar);
                    } else {
                        array_push($attributesData, '');
                        array_push($attributesData, '');
                    }
                }
            } else {
                array_push($attributesData, '');
                array_push($attributesData, '');
            }
        }

        //     foreach ($productAttributes as $productAttribute) {

        //         if ($productAttribute['option']->type == 5) {
        //             //$inputData = ProductOptionValues::where('product_id', $item->id)->where('option_id', $productAttribute->option->id)->where('value_id', $productAttribute->value->id)->where('type', '0')->first();
        //             array_push($attributesData, $productAttribute['option']->name_en);
        //             array_push($attributesData, $productAttribute['value']['input_en']);
        //             array_push($attributesData, $productAttribute['value']['input_ar']);
        //         } else {
        //             array_push($attributesData, $productAttribute['option']->name_en);
        //             array_push($attributesData, $productAttribute['value']->name_en);
        //             array_push($attributesData, $productAttribute['value']->name_ar);
        //         }


        //         $s++;
        //     }

        //     if ($s < $this->attributesCount) {
        //         for ($x = $s + 1; $x <= $this->attributesCount; $x++) {
        //             array_push($attributesData, "");
        //             array_push($attributesData, "");
        //             array_push($attributesData, "");

        //         }
        //     }
        // } else {
        //     $attributesData = [];
        //     for ($x = 1; $x <= $this->attributesCount; $x++) {
        //         array_push($attributesData, "");
        //         array_push($attributesData, "");
        //         array_push($attributesData, "");
        //     }

        // }

        $mainProductsArray = [
            '',
            $item->sku,
            '',
            $relatedSkus,
            $item->name,
            $item->name_ar,
            $item->description,
            $item->description_ar,
            $item->long_description_en,
            $item->long_description_ar,
            $item->meta_title,
            $item->meta_title_ar,
            $item->meta_description,
            $item->meta_description_ar,
            $item->keywords,
            $item->preorder,
            $item->preorder_start_date,
            $item->preorder_end_date,
            // $item->preorder_price,
            $item->weight,
            isset($category->name) ? $category->name : "",
            $group,
            $subCategory ? $subCategory->name : "",
            $subCategory ? $subCategory->slug : "",
            optional(optional($item->optionalSubCategory)->parent)->name,
            optional($item->optionalSubCategory)->name,
            $brandName,
            $tags,
            $item->subtract_stock,
            $item->stock,
            $item->barcode,
            $item->price,
            $item->discount_price,
            $item->discount_start_date,
            $item->discount_end_date,
            $item->image,
            $images,
            $item->order,
            $item->active,
            $item->free_delivery,
            $item->type,
            $item->has_stock,
            $item->bundle_checkout,
            $bundleSkus,
        ];

        foreach ($attributesData as $attribute) {
            array_push($mainProductsArray, $attribute);
        }

        if (count($item->productVariants) > 0) {

            foreach ($item->productVariants as $productVariant) {
                $productOptions = $productVariant->customerVariantOptionsLists();
                $attributesData = [];
                foreach ($this->attributes  as $attribute) {
                    $productAttributePivot = ProductOptionValues::where('option_id', $attribute->id)->where('product_id', $productVariant->id)->where('type', '0')->first();
                    array_push($attributesData, $attribute->name_en);
                    if ($productAttributePivot) {
                        if ($attribute->type == 5) {
                            array_push($attributesData, $productAttributePivot->input_en);
                            array_push($attributesData, $productAttributePivot->input_ar);
                        } else {
                            $value = OptionValue::find($productAttributePivot->value_id);
                            if ($value) {
                                array_push($attributesData, $value->name_en);
                                array_push($attributesData, $value->name_ar);
                            } else {
                                array_push($attributesData, '');
                                array_push($attributesData, '');
                            }
                        }
                    } else {
                        array_push($attributesData, '');
                        array_push($attributesData, '');
                    }
                }

                $optionsData = [];
                if (!empty($productOptions)) {
                    $s = 0;
                    foreach ($productOptions as $productOption) {
                        array_push($optionsData, $productOption['option']['name']);
                        array_push($optionsData, isset($productOption['values'][0]) ? $productOption['values'][0]['name'] : "");
                        array_push($optionsData, isset($productOption['values'][0]) ? $productOption['values'][0]['image'] : "");
                        $s++;
                    }
                    if ($s < $this->optionsCount) {
                        for ($x = $s; $x <= $this->optionsCount; $x++) {
                            array_push($optionsData, "");
                            array_push($optionsData, "");
                            array_push($optionsData, "");
                        }
                    }
                } else {
                    for ($x = 1; $x <= $this->optionsCount; $x++) {
                        array_push($optionsData, "");
                        array_push($optionsData, "");
                        array_push($optionsData, "");
                    }
                }
                $bundleSkus = implode(',', $productVariant->bundleProduct->pluck('sku')->toArray());
                $variantImages = $productVariant->images->pluck('url')->implode(',');
                $productVariantArray = [
                    $productVariant->parent_id,
                    $item->sku,
                    $productVariant->sku,
                    $relatedSkus,
                    $productVariant->name,
                    $productVariant->name_ar,
                    $productVariant->description,
                    $productVariant->description_ar,
                    $productVariant->long_description_en,
                    $productVariant->long_description_ar,
                    $productVariant->meta_title,
                    $productVariant->meta_title_ar,
                    $productVariant->meta_description,
                    $productVariant->meta_description_ar,
                    $productVariant->keywords,
                    $item->preorder,
                    $item->preorder_start_date,
                    $item->preorder_end_date,
                    // $item->preorder_price,
                    $productVariant->weight,
                    isset($category->name) ? $category->name : "",
                    $group,
                    $subCategory ? $subCategory->name : "",
                    $subCategory ? $subCategory->slug : "",
                    optional(optional($item->optionalSubCategory)->parent)->name,
                    optional($item->optionalSubCategory)->name,
                    $brandName,
                    $tags,
                    $item->subtract_stock,
                    $productVariant->stock,
                    $productVariant->barcode,
                    $productVariant->price,
                    $productVariant->discount_price,
                    $productVariant->discount_start_date,
                    $productVariant->discount_end_date,
                    $productVariant->image,
                    $variantImages,
                    $productVariant->order,
                    $productVariant->free_delivery,
                    $productVariant->active,
                    $item->type,
                    $item->has_stock,
                    $item->bundle_checkout,
                    $bundleSkus,
                ];

                foreach ($attributesData as $attribute) {
                    array_push($productVariantArray, $attribute);
                }

                foreach ($optionsData as $options) {
                    array_push($productVariantArray, $options);
                }

                //$i == 0 ? $variants[] = $mainProductsArray : '';
                $variants[] = $productVariantArray;
                $i++;
            }
            return $variants;
        } else {
            return [];
        }
    }

    public function headings(): array
    {

        $headingArray =[
            "main_id",
            "main_sku",
            "variant_sku",
            "related_skus",
            "name",
            "name_ar",
            "description",
            "description_ar",
            "long_description_en",
            "long_description_ar",
            "meta_title",
            "meta_title_ar",
            "meta_description",
            "meta_description_ar",
            "keywords",
            "preorder",
            "preorder_start_date",
            "preorder_end_date",
            // "preorder_price",
            "weight",
            "category",
            "group",
            "subcategory",
            "subcategory_slug",
            "category_optional",
            "subcategory_optional",
            "brand",
            "tags",
            "Subtract Stock",
            "stock",
            "barcode",
            "price",
            "discount_price",
            "discount_start_date",
            "discount_end_date",
            "main_image",
            "images",
            "order",
            "free_delivery",
            "item",
            "type",
            "has_stock",
            "bundle_checkout",
            "bundle_skus"
        ];

        for ($x = 1; $x <= $this->attributesCount; $x++) {
            array_push($headingArray, "attribute_name_$x");
            array_push($headingArray, "attribute_value_$x");
            array_push($headingArray, "attribute_value_ar_$x");
        }

        for ($x = 1; $x <= $this->optionsCount; $x++) {
            array_push($headingArray, "option_name_$x");
            array_push($headingArray, "option_value_$x");
            array_push($headingArray, "option_image_$x");
        }

        return $headingArray;
    }
}
