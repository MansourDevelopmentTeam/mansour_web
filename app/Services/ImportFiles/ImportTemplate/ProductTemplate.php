<?php


namespace App\Services\ImportFiles\ImportTemplate;


class ProductTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/product_template.xlsx';

    public function mandatoryColumns(): array
    {
        return [
            "main_sku",
            "variant_sku",
            "name",
            "name_ar",
            "description",
            "description_ar",
            "group",
            "category",
            "subcategory",
            "subcategory_slug",
            "brand",
            "stock",
            "brand",
            "price",
            "main_image",
            "images",
            "discount_price",
        ];


    }

    public function optionalColumns(): array
    {
        return [
            "order",
            "type",
            "bundle_checkout",
            "bundle_skus",
            "has_stock",
            "discount_end_date",
            "discount_start_date",
            "barcode",
            "Subtract Stock",
            "tags",
            "category_optional",
            "subcategory_optional",
            "preorder_start_date",
            "preorder",
            "preorder_price",
            "meta_description",
            "keywords",
            "meta_description_ar",
            "meta_title",
            "meta_title_ar",
            "long_description_en",
            "long_description_ar",
            "related_skus",
            "image",
            "weight",
            "active",
            "free_delivery"
        ];

    }
}
