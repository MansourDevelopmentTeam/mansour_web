<?php

namespace App\Sheets\Export\Products;

use App\Models\Inventories\Inventory;
use App\Models\Products\Product;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\SubCategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExportToFb implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    private $products;
    public function __construct()
    {
        $products = Product::with("category.parent", "brand")->get();
        $this->products = $products;
    }

    public function collection()
    {

        return $this->products;
    }


    public function map($product): array
    {
        // dd(array_values($player));
        $brand_name = $product->brand ? $product->brand->name : "";
        $mainProductsArray = [
            $product->sku,
            $product->name,
            "Description: {$product->description}",
            $product->stock > 0 ? "In Stock" : "Out of Stock",
            "New",
            $brand_name,
            "{$product->price} EGP",
            $product->discount_price ? "{$product->discount_price} EGP" : '',
            config('app.website_url')."/products/{$product->id}/{$product->name}",
            $product->image,
        ];

        return $mainProductsArray;
    }

    public function headings(): array
    {

        $headingArray = ["id", "title", "description", "availability", "condition", "brand", "price", "sale_price", "link", "image_link"];
        return $headingArray;
    }
}
