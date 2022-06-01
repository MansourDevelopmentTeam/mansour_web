<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orders\Transaction;

class TransferPaymentMethodTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = Transaction::all();

        foreach ($transactions as $transaction) {
            $transaction->update([
                'payment_method_id' => $transaction->order_details['payment_method'],
            ]);
        }
    }
}
