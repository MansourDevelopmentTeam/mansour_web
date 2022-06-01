<?php


namespace App\Services\ExportFiles;


use Exception;

class ExportFactory
{
    private $_exportType;


    /**
     * ImportFactory constructor.
     * @param int $exportType
     */
    public function __construct(int $exportType)
    {
        $this->_exportType = $exportType;
    }

    /**
     * @throws Exception
     */
    public function export(){
        switch ($this->_exportType) {
            case ExportConstants::BRAND_TYPE:
                return new ExportBrand();
            case ExportConstants::PRODUCT_TYPE:
                return new ExportProduct();
            case ExportConstants::CATEGORY_TYPE:
                return new ExportCategory();
            case ExportConstants::GROUP_TYPE:
                return new ExportGroups();
            case ExportConstants::OPTION_TYPE:
                return new ExportOptions();
            case ExportConstants::STOCK_TYPE:
                return new ExportStock();
            case ExportConstants::LISTS_TYPE:
                return new ExportList();
            case ExportConstants::PRESCRIPTION_TYPE:
                return new ExportPrescription();
            default:
                throw new Exception("Some Errors");
        }

    }
}
