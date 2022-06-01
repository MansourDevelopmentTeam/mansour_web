<?php

namespace App\Models\Repositories;

use App\Models\Payment\PaymentMethod;

class PaymentRepository
{
    /**
     * Find payment method with credentials.
     *
     * @param int $id
     * @return PaymentMethod
     */
    public function findWithCredentials(int $id): PaymentMethod
    {
        return PaymentMethod::with('credentials')->find($id);
    }
}