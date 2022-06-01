<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('order_details')->nullable();
            $table->integer("order_pay_id")->nullable();
            $table->text('card_info')->nullable();
            $table->text('transaction_response')->nullable();
            $table->text('transaction_status')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer("customer_id")->unsigned()->nullable();
            $table->foreign("customer_id")->references("id")->on("users")->onDelete("set null");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
