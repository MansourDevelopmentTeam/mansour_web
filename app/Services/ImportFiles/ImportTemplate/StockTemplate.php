<?php


namespace App\Services\ImportFiles\ImportTemplate;


class StockTemplate extends ImportFilesTemplate
{
    protected $templatePath = 'templates/stock_template.xlsx';

    public function optionalColumns(): array
    {
       return  ['active','discount_start_date','discount_end_date','payment_methods', "price", "discount_price", "stock"];
    }

    public function mandatoryColumns(): array
    {
        return ["sku"];

    }
}
