<?php

namespace App\Sheets\Export\Products;

use App\Models\Products\Product;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\SubCategoryGroup;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductVariantExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    private $attributesCount;
    private $optionsCount;
    public function __construct()
    {
        $attributesCount = 0;
        $optionsCount = 0;
        $products = Product::with ("productVariants")->MainProduct()->get();
        foreach ($products as $product){
            $productAttributes = $product->optionsWithVlues();
            if (count($product->productVariants) > 0) {
                foreach ($product->productVariants as $productVariants){
                    $productOptions = $productVariants->customerVariantOptionsLists();
                    count($productOptions) > $optionsCount ? $optionsCount = count($productOptions) : '';
                }
            }
            count($productAttributes) > $attributesCount ? $attributesCount = count($productAttributes) : '';
        }
        $this->optionsCount = $optionsCount;
        $this->attributesCount = $attributesCount;
    }
    public function collection()
    {
        $products = Product::with("category.parent", "brand", "tags", "productVariants")->MainProduct()->get();
        return $products;
    }


    public function map($item): array
    {
        $category = $item->category->parent ? $item->category->parent : "";
        $subCategory = $item->category ? $item->category : "";
        $brandName = $item->brand ? $item->brand->name : "";
        $group = isset($item->category->group[0]) ? $item->category->group[0]->name_en : "";
        $tags = $item->tags->pluck('name_en')->implode(',');
        $images = $item->images->pluck('url')->implode(',');
        $variants = [];
        $i = 0;
        $attributesData= [];



        $productAttributes = $item->optionsWithVlues();
        if (!empty($productAttributes)){
            $s = 0;
            $attributesData= [];
            foreach ($productAttributes as $productAttribute){
                if ($productAttribute->option->type == 5){
                    $inputData = ProductOptionValues::where('product_id',$item->id)->where('option_id',$productAttribute->option->id)->where('value_id',$productAttribute->value->id)->where('type','0')->first();
                    array_push($attributesData ,  $productAttribute->option->name_en);
                    array_push($attributesData ,  $inputData->input_en);
                    array_push($attributesData ,  $inputData->input_ar);
                }else{
                    array_push($attributesData ,  $productAttribute->option->name_en);
                    array_push($attributesData ,  $productAttribute->value->name_en);
                    array_push($attributesData ,  $productAttribute->value->name_ar);
                }


                $s++;
            }
            if ($s < $this->attributesCount){
                for ($x = $s; $x <= $this->attributesCount; $x++) {
                    array_push($attributesData ,   "");
                    array_push($attributesData ,  "");
                    array_push($attributesData ,  "");
                }
            }
        }else{
            $attributesData= [];
            for ($x = 1; $x <= $this->attributesCount; $x++) {
                array_push($attributesData ,   "");
                array_push($attributesData ,  "");
                array_push($attributesData ,  "");
            }
        }
        $mainProductsArray = [
            $item->sku,
            '',
            $item->name,
            $item->name_ar,
            $item->description,
            $item->description_ar,
            isset($category->name) ? $category->name :"",
            $group,
            $subCategory->name,
            $subCategory->slug,
            $brandName,
            $tags,
            $item->subtract_stock,
            $item->stock,
            $item->barcode,
            $item->price,
            $item->discount_price,
            $item->image,
            $images,
            $item->active,
        ];
        foreach ($attributesData as $attributes){
            array_push($mainProductsArray ,  $attributes);
        }
        if (count($item->productVariants) > 0) {
            foreach ($item->productVariants as $productVariant) {
                $productOptions = $productVariant->customerVariantOptionsLists();
                $optionsData= [];
                    if (!empty($productOptions)){
                        $s = 0;
                        foreach ($productOptions as $productOption){
                                array_push($optionsData ,  $productOption['option']['name']);
                                array_push($optionsData ,  $productOption['values'][0]['name']);
                                array_push($optionsData ,  $productOption['values'][0]['image']);
                                $s++;
                        }
                        if ($s < $this->optionsCount){
                            for ($x = $s; $x <= $this->optionsCount; $x++) {
                                array_push($optionsData ,   "");
                                array_push($optionsData ,  "");
                                array_push($optionsData ,  "");
                            }
                        }
                    }else{
                        for ($x = 1; $x <= $this->optionsCount; $x++) {
                            array_push($optionsData ,   "");
                            array_push($optionsData ,  "");
                            array_push($optionsData ,  "");
                        }
                    }



                $variantImages = $productVariant->images->pluck('url')->implode(',');
                $productVariantArray = [
                    $item->sku,
                    $productVariant->sku,
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $productVariant->stock,
                    $productVariant->barcode,
                    $productVariant->price,
                    $productVariant->discount_price,
                    $productVariant->image,
                    $variantImages,
                    $productVariant->active,
                ];
                for ($x = 1; $x <= $this->attributesCount; $x++) {
                    array_push($productVariantArray ,   "");
                    array_push($productVariantArray ,  "");
                    array_push($productVariantArray ,  "");
                }

                foreach ($optionsData as $options){
                    array_push($productVariantArray ,  $options);
                }

                $i == 0 ? $variants[] = $mainProductsArray : '';
                $variants[] = $productVariantArray;
                $i++;
            }
            $data = $variants;

        } else {
            $data = $mainProductsArray;
        }
        return $data;
    }

    public function headings(): array
    {

        $headingArray =[
            "main_sku",
            "variant_sku",
            "name",
            "name_ar",
            "description",
            "description_ar",
            "category",
            "group",
            "subcategory",
            "subcategory_slug",
            "brand",
            "tags",
            "Subtract Stock",
            "stock",
            "barcode",
            "price",
            "discount_price",
            "main_image",
            "images",
            "active",
            ];
        for ($x = 1; $x <= $this->attributesCount; $x++) {
            array_push($headingArray ,  "attribute_name_$x");
            array_push($headingArray ,  "attribute_value_$x");
            array_push($headingArray ,  "attribute_value_ar_$x");
        }
        for ($x = 1; $x <= $this->optionsCount; $x++) {
            array_push($headingArray ,  "option_name_$x");
            array_push($headingArray ,  "option_value_$x");
            array_push($headingArray ,  "option_image_$x");
        }
        return $headingArray;
    }
}
