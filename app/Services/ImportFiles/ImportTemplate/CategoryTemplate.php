<?php


namespace App\Services\ImportFiles\ImportTemplate;


class CategoryTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/category_template.xlsx';

    public function optionalColumns(): array
    {
        return ["category_image","subcategory_image"];
    }

    public function mandatoryColumns(): array
    {
        return [
            "category",
            "category_ar",
            "subcategory",
            "subcategory_ar",
            "category_slug",
            "subcategory_slug",
            "subcategory_options",
        ];
    }
}
