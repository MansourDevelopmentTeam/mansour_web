<?php
namespace App\Sheets\Export\Products;

use App\Models\Products\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    public function __construct()
    {
        $products = Product::with("category.parent", 'categories', "brand")->withCount('categories')->get();
        $productCategoriesCount = $products->sortByDesc("categories_count")->first();
        $productCategoriesCount = $productCategoriesCount->categories_count;
        $this->productCategoriesCount = $productCategoriesCount ;
        $this->products = $products ;
    }
    public function collection()
    {
        return $this->products;
    }


    public function map($item): array
    {
        // dd(array_values($player));
        $brand_name = $item->brand ? $item->brand->name : "";

        $images = $item->images->pluck('url')->toArray();
        array_unshift($images, $item->image);
        $images = implode(",", $images);
        $mainProductsArray = [
            $item->id,
            $item->name,
            $item->name_ar,
            $item->description,
            $item->description_ar,
//                        $item->category->parent->name,
//                        $item->category->name,
            $brand_name,
            $item->sku,
            $item->order,
            $item->orders_count,
            $item->price,
            $item->discount_price,
            $images,
            (int)$item->active
        ];
        foreach ($item->categories as $category) {
            array_push($mainProductsArray, optional($category->parent)->name ?? "");
            array_push($mainProductsArray, optional($category)->name ?? "");
            array_push($mainProductsArray, isset($item->category->group[0]) ? $item->category->group[0]->name_en : "");
        }
     return $mainProductsArray;
    }

    public function headings(): array
    {
        $headingArray = ["id", "name", "name_ar", "description", "description_ar", "brand", "main_sku","order", "total_orders", "price", "discount_price", "image", "active"];
        for ($x = 1; $x <= (int) $this->productCategoriesCount; $x++) {
            array_push($headingArray, "category_parent_name_$x");
            array_push($headingArray, "subcategory_name_$x");
            array_push($headingArray, "group_name_$x");
        }
        return $headingArray;
    }
}
