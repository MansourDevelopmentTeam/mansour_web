<?php


namespace App\Services\ExportFiles;


use App\Models\Products\Product;
use Generator;

class ExportProduct extends ExportFiles
{
    protected $_reportName = 'Products_';

    public function prepareExportDataArray($filterData): Generator
    {
        $query = Product::with("category.parent", "brand");

        $query->when(isset($filterData['category_id']) && !empty($filterData['category_id']), function ($q) use ($filterData){
            $q->where('category_id', $filterData['category_id']);
        });

        $query->when(isset($filterData['sub_category_id']) && !empty($filterData['sub_category_id']), function ($q) use ($filterData){
            $q->where('optional_sub_category_id', $filterData['optional_sub_category_id']);
        });

        $products = $query->get();
        $this->_count = $products->count();
        foreach ($products as $product) {
            $brand_name = ($product->brand && isset($product->brand->name)) ? $product->brand->name : "";
            yield [$product->id , $product->name, $product->name_ar,
                $product->description, $product->meta_title, $product->meta_description, $product->keywords,
                $product->preorder, $product->preorder_price, $product->description_ar, $product->category->parent->name,
                $product->category->name ?? '', $brand_name, $product->sku, $product->orders_count, $product->price,
                $product->discount_price, $product->image, (int)$product->active, $product->weight,
            ];
        }
    }
}