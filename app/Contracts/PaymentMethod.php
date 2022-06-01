<?php


namespace App\Contracts;

use App\Models\Orders\Transaction;


interface PaymentMethod
{
    /**
     * Get redirect url
     *
     * @return string
     */
    public function getPaymentUrl();

    /**
     * Complete payment
     *
     * @param Transaction $transaction
     * @return void
     */
    public function completePayment(Transaction $transaction);

    public function isOnline();
}