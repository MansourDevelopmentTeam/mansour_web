<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Database\Seeders\ChangeTransactionStatusTypeSeeder;

class ChangeTransactionStatusColumnTypeInTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seeder = new ChangeTransactionStatusTypeSeeder();
        $seeder->run();
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('transaction_status')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
