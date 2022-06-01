<?php

namespace App\Services\ImportFiles\ImportTemplate;

class CustomersTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/customers_template.xlsx';

    public function mandatoryColumns():array
    {
        return [
            'first_name',
            'phone',
        ];
    }

    public function optionalColumns() :array{
        return [
            'last_name',
            'email',
            'birthdate',
            'image',
            'city',
            'area',
            'district',
            'address_name',
            'street',
            'building',
            'apartment',
            'landmark'
        ];
    }
}
