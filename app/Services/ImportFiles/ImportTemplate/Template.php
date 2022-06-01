<?php


namespace App\Services\ImportFiles\ImportTemplate;
use App\Services\ImportFiles\ImportConstants;


class Template
{

    private $templateType;

    /**
     * Template constructor.
     * @param $templateType
     */
    public function __construct($templateType)
    {
        $this->templateType = $templateType;
    }


    public function getTemplate(){
        switch ($this->templateType) {
            case ImportConstants::BRAND_TYPE:
                return new BrandTemplate();
            case ImportConstants::PRODUCT_TYPE:
                return new ProductTemplate();
            case ImportConstants::CATEGORY_TYPE:
                return new CategoryTemplate();
            case ImportConstants::LISTS_TYPE:
                return  new ListTemplate();
            case ImportConstants::STOCK_TYPE:
                return new StockTemplate();
            case ImportConstants::GROUP_TYPE:
                return new GroupTemplate();
            case ImportConstants::OPTION_TYPE:
                return new OptionsTemplate();
            case ImportConstants::PROMO_TYPE:
                return new PromoTemplate();
            case ImportConstants::CITIES_TYPE:
                return new CitiesTemplate();
            case ImportConstants::DELIVERERS_TYPE:
                return new DeliverersTemplate();
            case ImportConstants::CUSTOMERS_TYPE:
                return new CustomersTemplate();
            default:
                throw new \Exception("Some Errors");
        }

    }

}
