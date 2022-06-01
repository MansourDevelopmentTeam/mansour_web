<?php


namespace App\Services\ImportFiles;


use App\Models\Products\Option;
use App\Sheets\Import\Brands\BrandsImport;
use App\Sheets\Import\Categories\CategoriesImport;
use App\Sheets\Import\Cities\CitiesImport;
use App\Sheets\Import\Deliverers\DeliverersImport;
use App\Sheets\Import\Groups\GroupsImport;
use App\Sheets\Import\Lists\ImportListItems;
use App\Sheets\Import\Options\OptionsImport;
use App\Sheets\Import\Products\ProductFullImport;
use App\Sheets\Import\Products\ProductFullImportV2;
use App\Sheets\Import\Products\ProductStocksImport;
use App\Sheets\Import\Promos\PromosImport;
use App\Sheets\Import\Customers\CustomersImport;

class ImportFactory
{
    private $_importType;
    private $historyID;
    private $listID;


    /**
     * ImportFactory constructor.
     * @param ImportFiles $importType
     */
    public function __construct($importType, $historyID = null,$listID = null)
    {
        $this->_importType = $importType;
        $this->historyID = $historyID;
        $this->listID = $listID;
    }


    public function import()
    {
        switch ($this->_importType) {
            case ImportConstants::BRAND_TYPE:
                return new BrandsImport($this->historyID);
            case ImportConstants::PRODUCT_TYPE:
                return new ProductFullImport($this->historyID);
            case ImportConstants::CATEGORY_TYPE:
                return new CategoriesImport($this->historyID);
            case ImportConstants::OPTION_TYPE:
                return new OptionsImport($this->historyID);
            case ImportConstants::GROUP_TYPE:
                return new GroupsImport($this->historyID);
            case ImportConstants::STOCK_TYPE:
                return new ProductStocksImport($this->historyID);
            case ImportConstants::LISTS_TYPE:
                return new ImportListItems($this->historyID,$this->listID);
            case ImportConstants::PROMO_TYPE:
                return new PromosImport($this->historyID);
            case ImportConstants::CITIES_TYPE:
                return new CitiesImport($this->historyID);
            case ImportConstants::DELIVERERS_TYPE:
                return new DeliverersImport($this->historyID);
            case ImportConstants::CUSTOMERS_TYPE:
                return new CustomersImport($this->historyID);
            default:
                throw new \Exception("Some Errors");
        }

    }


}
