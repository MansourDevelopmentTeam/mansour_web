<?php

namespace App\Services\ImportFiles\ImportTemplate;

class DeliverersTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/deliverers_template.xlsx';

    public function mandatoryColumns():array
    {
        return [];
    }

    public function optionalColumns() :array{
        return [];
    }
}
