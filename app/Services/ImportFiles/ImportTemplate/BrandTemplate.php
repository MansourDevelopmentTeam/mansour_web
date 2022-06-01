<?php


namespace App\Services\ImportFiles\ImportTemplate;


class BrandTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/brand_template.xlsx';

    public function mandatoryColumns():array
    {
        return ['brand','brand_ar'];
    }

    public function optionalColumns() :array{
        return ['image'];
    }
}
