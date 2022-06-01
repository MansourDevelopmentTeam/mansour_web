<?php

namespace App\Models\Repositories;

use App\Models\Orders\Transaction;
use Facades\App\Models\Repositories\CartRepository;

class TransactionRepository
{
    /**
     * Get the transaction by id and auth customer id.
     *
     * @param integer $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return \App\Models\Orders\Transaction
     */
    public function getByIdAndCustomer(int $id)
    {
        return Transaction::where('id', $id)
                // ->where('customer_id', auth()->user()->id)
                ->firstOrFail();
    }

    /**
     * Get transaction by order pay id
     *
     * @param integer $id
     * @return \App\Models\Orders\Transaction
     */
    public function getByOrderPayId(int $id)
    {
        return Transaction::where('order_pay_id', $id)
                // ->has('customer')
                ->firstOrFail();
    }

    /**
     * Get transaction by payment reference
     *
     * @param string $tranRef
     * @return \App\Models\Orders\Transaction
     */
    public function getByTransRef(string $tranRef)
    {
        return Transaction::where('payment_reference', $tranRef)
                // ->has('customer')
                ->firstOrFail();
    }
    
    /**
     * Create new transaction
     *
     * @param int $total
     * @param string|null $paymentReference
     * @return \App\Models\Orders\Transaction
     */
    public function create($total, $paymentReference = null)
    {
        $orderData = request()->all();
        $items = CartRepository::getUserCartItems();
        $orderData['items'] = $items->toArray();
        $orderData['user_ip'] = getRealIp();
        $orderData['plan_id'] = isset($orderData['plan_id']) ? $orderData['plan_id'] : null;

        return Transaction::create([
                    'order_details' => $orderData,
                    'payment_transaction' => $paymentReference,
                    'payment_reference' => $paymentReference,
                    'total_amount' => $total,
                    'payment_method_id' => $orderData['payment_method'],
                    'customer_id' => auth()->user()->id ?? null
                ]);
    }
}