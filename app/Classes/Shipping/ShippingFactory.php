<?php

namespace App\Classes\Shipping;

use \App\Models\Services\AramexService;
use \App\Models\Services\AramexServiceV2;
use App\Models\Services\BostaService;
use \App\Models\Services\InternalShippingService;
use App\Models\Services\QatarPostShippingService;

class ShippingFactory
{
    static function make($shippingMethod) {
        switch ($shippingMethod) {
            case 1:
                return new InternalShippingService();
            case 2:
            case 3:
                return new AramexService();
                // return new AramexServiceV2();
            case 4:
                return new BostaService();
            case 5:
                return new QatarPostShippingService();
        }
    }
}
