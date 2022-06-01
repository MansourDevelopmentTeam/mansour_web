<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("user_id")->unsigned()->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null");
            
            $table->integer("deliverer_id")->unsigned()->nullable();
            $table->foreign("deliverer_id")->references("id")->on("users")->onDelete("set null");

            $table->integer("state_id")->unsigned()->nullable();
            $table->foreign("state_id")->references("id")->on("order_states")->onDelete("set null");

            $table->integer("sub_state_id")->unsigned()->nullable();
            $table->foreign("sub_state_id")->references("id")->on("order_states")->onDelete('set null');
            $table->text("feedback")->nullable();
            $table->string("fawry_ref")->nullable();
            $table->integer("paid_amount")->nullable();
            $table->text("notes")->nullable();
            $table->integer("rate")->nullable();
            $table->integer("payment_method");
            $table->integer("parent_id")->nullable()->unsigned();
            $table->foreign("parent_id")->references("id")->on("orders")->onDelete("set null");
            $table->string('referal')->nullable();
            $table->integer("address_id")->unsigned()->nullable();
            $table->foreign("address_id")->references("id")->on("addresses")->onDelete("set null");
            $table->integer("customer_rate")->nullable();
            $table->string("unique_id")->nullable();
            $table->string("success_indicator")->nullable();
            $table->datetime("scheduled_at")->nullable();
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
        Schema::dropIfExists('orders');
    }
}
