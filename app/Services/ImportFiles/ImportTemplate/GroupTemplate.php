<?php


namespace App\Services\ImportFiles\ImportTemplate;



class GroupTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/group_template.xlsx';

    public function optionalColumns(): array
    {
       return ['group_image'];
    }

    public function mandatoryColumns(): array
    {
        return  ['group_ar', 'group','category', 'subcategory','subcategory_slug', 'group_slug'];
    }
}
