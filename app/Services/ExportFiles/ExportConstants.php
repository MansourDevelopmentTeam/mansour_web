<?php


namespace App\Services\ExportFiles;


final class ExportConstants
{
    const BRAND_TYPE = 1;
    const PRODUCT_TYPE = 2;
    const CATEGORY_TYPE = 3;
    const OPTION_TYPE = 4;
    const GROUP_TYPE = 5;
    const STOCK_TYPE = 6;
    const LISTS_TYPE = 7;
    //const PROMO_TYPE = 8;
    const PRESCRIPTION_TYPE = 9;

    const STATE_CANCEL = 1;
    const STATE_PROGRESS = 2;
    const STATE_COMPLETE = 3;
    const STATE_ERROR = 4;
    const STATE_PENDING = 5;

    /**
     * @param $constantId
     * @return string
     * return the import status name
     */
    final public static function getStateConstantsNames($constantId): string
    {
        switch ($constantId){
            case ExportConstants::STATE_CANCEL:
                return "Canceled";
            case ExportConstants::STATE_ERROR:
                return "ERROR";
            case ExportConstants::STATE_COMPLETE:
                return 'Completed';
            case ExportConstants::STATE_PROGRESS:
                return 'Progress';
            case ExportConstants::STATE_PENDING:
                return 'Pending';
            default:
                return '';
        }
    }
}
