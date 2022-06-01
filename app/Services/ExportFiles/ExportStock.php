<?php


namespace App\Services\ExportFiles;


use App\Models\Products\Product;
use Generator;

class ExportStock extends ExportFiles
{
    protected $_reportName = 'Stock_';

    public function prepareExportDataArray($filterData = null): Generator
    {
        $products = Product::with('productVariants')->MainProduct()->get();
        $this->_count = $products->count();
        foreach ($products as $item) {
            if (count($item->productVariants) > 0) {
                $variantsStocks = [];
                foreach ($item->productVariants as $product) {
                    $variantsStocks[] = [
                        $product->sku, $product->price,$product->discount_price, $product->stock, $product->active,
                    ];
                }
                yield $variantsStocks;
            }
        }
    }

}