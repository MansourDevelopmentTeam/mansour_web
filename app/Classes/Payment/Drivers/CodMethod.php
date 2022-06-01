<?php

namespace App\Classes\Payment\Drivers;

use App\Contracts\PaymentMethod;
use App\Models\Orders\Transaction;
use App\Classes\Shipping\ShippingConstant;

class CodMethod extends Method implements PaymentMethod
{
    /**
     * COD Method constructor.
     *
     * @param Array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * Get redirect payement url
     *
     * @return void
     */
    public function getPaymentUrl()
    {
        return null;
    }
    /**
     * Complete payment
     *
     * @param Transaction $transaction
     * @return void
     */
    public function completePayment($transaction = null)
    {
        $msg = "Success";

        $open_time = date("Y-m-d") . " " . config('constants.open_time');
        $off_time = date("Y-m-d") . " " . config('constants.off_time');
        if (strtotime(date("H:i")) < strtotime($open_time) || strtotime(date("H:i")) > strtotime($off_time)) {
            $msg = trans("mobile.errorStoreClosed");
            $this->setResponseCode(201);
        }

        return $msg;
    }

    /**
     * Calculate the order grand total to aramex.
     *
     * @param Order $order
     * @return array
     */
    public function getAramexOrderTotal($order)
    {
        //TODO: Get aramex data from payment table
        $totalAmount = !is_null($order->invoice->discount) ? $order->invoice->discount : $order->invoice->total_amount;
        $deliveryFees = $order->invoice->delivery_fees;

        return [$totalAmount + $deliveryFees, ShippingConstant::SHIPPING_ARAMEX_PAYMENT_SERVICE];
    }

    /**
     * Verify if payment is success
     *
     * @param $transaction
     * @return boolean
     */
    public function verify($transaction = null): bool
    {
        return false;
    }
}
