<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("order_id")->unsigned();
            $table->foreign("order_id")->references("id")->on("orders")->onDelete("cascade");
            $table->integer("state_id")->unsigned();
            $table->foreign("state_id")->references("id")->on("order_states")->onDelete("cascade");
            $table->integer("sub_state_id")->nullable()->unsigned();
            $table->foreign("sub_state_id")->references("id")->on("order_states")->onDelete("set null");
            $table->integer("user_id")->unsigned()->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null");
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
        Schema::dropIfExists('order_history');
    }
}
