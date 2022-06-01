<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string("payment_reference")->nullable();
            $table->string('response_code', 10)->nullable();
            if(!Schema::hasColumn('transactions', 'session')) {
              $table->string("session")->nullable();
            }
            if(!Schema::hasColumn('transactions', 'success_indicator')) {
              $table->string("success_indicator")->nullable();
            }
        });
    }


    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(["payment_reference", "response_code", "session", "success_indicator"]);
        });
    }
}
