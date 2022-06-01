<?php


namespace App\Services\ImportFiles\ImportTemplate;


class PromoTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/promos_template.xlsx';

    public function optionalColumns(): array
    {
        return ['description', 'uses'];
    }

    public function mandatoryColumns(): array
    {
        return ['name', 'type', 'amount', 'expiration_date', 'active'];
    }
}
