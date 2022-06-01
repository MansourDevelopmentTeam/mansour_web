<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("order_id")->unsigned();
            $table->foreign("order_id")->references("id")->on("orders")->onDelete("cascade");
            $table->integer("cost_amount")->nullable();
            $table->integer("total_amount")->nullable();
            $table->integer("paid_amount")->nullable();
            $table->integer("discount")->nullable();
            $table->integer("remaining")->nullable();
            $table->integer("promo_id")->nullable();
            $table->decimal("admin_discount", 8, 2)->nullable();
            $table->integer("delivery_fees")->default(0);
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
        Schema::dropIfExists('invoices');
    }
}
