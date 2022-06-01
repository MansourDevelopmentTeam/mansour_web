<?php

namespace App\Sheets\Export\Products;

use App\Models\Inventories\Inventory;
use App\Models\Products\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductToFbExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    public function collection()
    {
        return Product::active()->whereNotNull('parent_id')->with("category.parent", "brand","parent")->get();
    }

    public function map($product): array
    {
        $brand_name = optional($product->parent)->brand ? optional($product->parent)->brand->name : "";

        $url = config('app.website_url') . "/products/" . str_replace(' ', '-', $product->name ) . "/{$product->parent_id}" . "?variant=". $product->id;

        $desc = strip_tags(htmlspecialchars_decode($product->description));

        return  [
            $product->sku,
            $product->name,
            "Description: {$desc}",
            $product->stock > 0 ? "In Stock" : "Out of Stock",
            "New",
            $brand_name,
            "{$product->price} EGP",
            $product->discount_price ? "{$product->discount_price} EGP" : '',
            $url,
            $product->image,
        ];
    }

    public function headings(): array
    {
        return  ["id", "title", "description", "availability", "condition", "brand", "price", "sale_price", "link", "image_link"];
    }
}
