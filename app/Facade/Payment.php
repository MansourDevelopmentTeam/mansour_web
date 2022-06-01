<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;
use App\Classes\Payment\PaymentManager;

class Payment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'payment';
    }
}
