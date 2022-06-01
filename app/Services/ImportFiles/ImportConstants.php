<?php


namespace App\Services\ImportFiles;


final class ImportConstants
{
    const BRAND_TYPE = 1;
    const PRODUCT_TYPE = 2;
    const CATEGORY_TYPE = 3;
    const OPTION_TYPE = 4;
    const GROUP_TYPE = 5;
    const STOCK_TYPE = 6;
    const LISTS_TYPE = 7;
    const PROMO_TYPE = 8;
    const CITIES_TYPE = 9;
    const DELIVERERS_TYPE = 10;
    const CUSTOMERS_TYPE = 11;

    const STATE_CANCEL = 1;
    const STATE_PROGRESS = 2;
    const STATE_COMPLETE = 3;
    const STATE_ERROR = 4;
    const STATE_PENDING = 5;

    final public static function getStateConstantsNames($constantId): string
    {
        switch ($constantId) {
            case ImportConstants::STATE_CANCEL:
                return "Canceled";
            case ImportConstants::STATE_ERROR:
                return "ERROR";
            case ImportConstants::STATE_COMPLETE:
                return 'Completed';
            case ImportConstants::STATE_PROGRESS:
                return 'Progress';
            case ImportConstants::STATE_PENDING:
                return 'Pending';
            default:
                return '';
        }
    }

}
