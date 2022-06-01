<?php

namespace App\Services\ImportFiles\ImportTemplate;

class CitiesTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/cities_template.xlsx';

    public function mandatoryColumns():array
    {
        return [
            'city_name',
            'city_name_ar',
            'area_name',
            'area_name_ar',
        ];
    }

    public function optionalColumns() :array{
        return [
            'city_fees',
            'area_fees',
            'district_name',
            'district_name_ar',
            'district_fees',
        ];
    }
}
