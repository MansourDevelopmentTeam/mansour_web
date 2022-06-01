<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Database\Seeders\TransferPaymentMethodTransactionSeeder;
use Database\Seeders\PaymentMethods;

class ChangePaymentMethodInTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new PaymentMethods;
        $seeder->run();

        $seeder = new TransferPaymentMethodTransactionSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
