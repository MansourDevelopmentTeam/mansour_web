<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum("source",[1,2,3])->nullable();
            $table->bigInteger("transaction_id")->unsigned()->nullable();
            $table->foreign("transaction_id")->references("id")->on("transactions")->onDelete("cascade");
        });
    }


    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("transaction_id");
        });
    }
}
