<?php


namespace App\Services\ImportFiles\ImportTemplate;


class ListTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/list_template.xlsx';

    public function optionalColumns(): array
    {
       return ['name','list_id'];
    }

    public function mandatoryColumns(): array
    {
        return ['sku'];
    }
}
