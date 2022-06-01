<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('affiliate_id')->nullable()->unsigned();
            $table->foreign('affiliate_id')->references('id')->on('users')->onDelete('set null');
            $table->integer("order_id")->nullable()->unsigned();
            $table->foreign("order_id")->references('id')->on('orders')->onDelete('set null');
            $table->decimal("amount", 8, 2)->nullable();
            $table->dateTime("due_date")->nullable();

            $table->tinyInteger("payment_method")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("account_name")->nullable();
            $table->string("account_number")->nullable();
            $table->string("iban")->nullable();

            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text("rejection_reason")->nullable();
            $table->text("admin_comment")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_history');
    }
}
