<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orders\Transaction;

class ChangeTransactionStatusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::whereNull('transaction_status')
                ->update(["transaction_status" => Transaction::TRANSACTION_STATUS_PENDING]);

        Transaction::where('transaction_status', "true")
                ->update(["transaction_status" => Transaction::TRANSACTION_STATUS_SUCCESS]);

        Transaction::where('transaction_status', "false")
                ->update(["transaction_status" => Transaction::TRANSACTION_STATUS_FAILURE]);

    }
}
