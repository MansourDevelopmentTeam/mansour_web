<?php


namespace App\Services\ImportFiles\ImportTemplate;


class OptionsTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/options_template.xlsx';

    public function optionalColumns(): array
    {
        return ['hex_code','image'];
    }

    public function mandatoryColumns(): array
    {
       return ['type','option','option_ar','values','values_ar'];
    }
}
